<?php

namespace App\Filament\Resources;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use App\Filament\Resources\PublicationResource\Pages;
use App\Filament\Resources\PublicationResource\RelationManagers;
use App\Models\City;
use App\Models\Publication;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Pages\Actions\Action;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PublicationResource extends Resource
{
    protected static ?string $model = Publication::class;

    protected static ?string $label = 'Публикацию';
    protected static ?string $navigationLabel = 'Публикации';
    protected static ?string $pluralLabel = 'Публикации';

    protected static ?string $breadcrumb = 'Публикации';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        Group::make() // Группа для первой колонки
                            ->schema([
                                TextInput::make('title')
                                    ->label('Заголовок')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) =>
                                        $set('slug', Str::slug($state))
                                    ),
                                TextInput::make('slug')
                                    ->label('Алиас')
                                    ->unique(ignoreRecord: true),
                                Select::make('type')
                                    ->label('Тип')
                                    ->options(Publication::getTypeOptions()),
                                DatePicker::make('published_at')
                                    ->label('Дата публикации')
                                    ->required()
                                    ->maxDate(now()),
                                Select::make('city')
                                    ->label('Город')
                                    ->options(City::all()->pluck('title', 'title'))
                                    ->columnSpanFull(),
                                TextInput::make('category')
                                    ->label('Категория')
                                    ->maxLength(255),
                            ]),

                        Group::make() // Группа для второй колонки
                            ->schema([
                                FileUpload::make('image')
                                    ->label('Изображение')
                                    ->imageEditor()
                                    ->imageCropAspectRatio('12:7'),
                            ]),
                    ]),
                Toggle::make('active')
                    ->columnSpan('full')
                    ->default(true)
                    ->label('Активность'),
                TinyEditor::make('introtext')
                    ->label('Вводный текст')
                    ->columnSpan('full'),
                TinyEditor::make('content')
                    ->label('Содержимое')
                    ->required()
                    ->columnSpan('full'),
                FileUpload::make('gallery')
                    ->label('Галерея')
                    ->panelLayout('grid')
                    ->previewable(true)
                    ->imageEditor()
                    ->reorderable(true)
                    ->imageCropAspectRatio('12:7')
                    ->multiple()
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        $user = Auth::user();

        return $table
            ->query(
                static::getUserPublicationQuery($user)
            )
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Фото'),
                Tables\Columns\TextColumn::make('title')
                    ->limit(25)
                    ->searchable()
                    ->label('Заголовок'),
                Tables\Columns\TextColumn::make('type_label')
                    ->label('Тип'),
                Tables\Columns\TextColumn::make('city')
                    ->label('Город'),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Дата публикации'),
                Tables\Columns\ToggleColumn::make('active')
                    ->label('Активность'),
            ])
            ->filters([
                Filter::make('published_at')
                    ->label('Дата публикации')
                    ->form([
                        DatePicker::make('published_at')
                            ->label('Выберите дату'),
                    ])
                    ->query(fn ($query, $data) => $query->when(
                        $data['published_at'],
                        fn ($query, $date) => $query->whereDate('published_at', $date)
                    )),
                SelectFilter::make('type')
                    ->label('Тип')
                    ->options(Publication::getTypeOptions()),
                Tables\Filters\Filter::make('active')
                    ->label('Активность'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\ReplicateAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPublications::route('/'),
            'create' => Pages\CreatePublication::route('/create'),
            'edit' => Pages\EditPublication::route('/{record}/edit'),
        ];
    }

    /**
     * Фильтр записей по городам пользователя
     */
    protected static function getUserPublicationQuery($user): \Illuminate\Database\Eloquent\Builder
    {

        if($user->role == 'admin') return \App\Models\Publication::query();

        $cities = is_array($user->city)
            ? $user->city
            : array_map('trim', explode(',', (string) $user->city));

        return !empty($cities)
            ? \App\Models\Publication::query()->whereIn('city', $cities)
            : \App\Models\Publication::query();
    }

    public static function canEdit(\Illuminate\Database\Eloquent\Model $record): bool
    {
        $user = Auth::user();

        // Если у пользователя нет ограничения по городам, он может редактировать все
        if (empty($user->city) || $user->role == 'admin') {
            return true;
        }

        // Разбиваем строку городов в массив (если это строка)
        $userCities = is_array($user->city) ? $user->city : array_map('trim', explode(',', (string) $user->city));

        // Разрешаем редактирование только если город публикации есть в списке городов пользователя
        return in_array($record->city, $userCities);
    }


}
