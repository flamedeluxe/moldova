<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use App\Models\Publication;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $label = 'Проект';
    protected static ?string $navigationLabel = 'Проекты';
    protected static ?string $pluralLabel = 'Проекты';

    protected static ?string $breadcrumb = 'Проекты';

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
                                ->required()
                                ->maxLength(255),
                            Select::make('type')
                                ->label('Тип')
                                ->options(Publication::getTypeOptions()),
                            DatePicker::make('published_at')
                                ->label('Дата публикации')
                                ->required()
                                ->maxDate(now()),
                        ]),

                        Group::make() // Группа для второй колонки
                        ->schema([
                            Forms\Components\FileUpload::make('image')
                                ->label('Изображение'),
                        ]),
                    ]),
                Toggle::make('active')
                    ->columnSpan('full')
                    ->label('Активность'),
                RichEditor::make('introtext')
                    ->label('Вводный текст')
                    ->columnSpan('full'),
                RichEditor::make('content')
                    ->label('Содержимое')
                    ->required()
                    ->columnSpan('full'),
                FileUpload::make('gallery')
                    ->label('Галерея')
                    ->panelLayout('grid')
                    ->previewable(true)
                    ->reorderable(true)
                    ->multiple()
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Фото'),
                Tables\Columns\TextColumn::make('title')
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
                Tables\Actions\EditAction::make()->label(''),
                Tables\Actions\DeleteAction::make()->label(''),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
