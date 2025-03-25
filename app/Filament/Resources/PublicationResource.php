<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PublicationResource\Pages;
use App\Filament\Resources\PublicationResource\RelationManagers;
use App\Models\Publication;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;

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
                Forms\Components\TextInput::make('title')
                    ->label('Заголовок')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->label('Тип')
                    ->options(Publication::getTypeOptions()),
                Forms\Components\DatePicker::make('published_at')
                    ->label('Дата публикации')
                    ->required()
                    ->maxDate(now()),
                Forms\Components\Toggle::make('active')
                    ->columnSpan('full')
                    ->label('Активность'),
                Forms\Components\RichEditor::make('introtext')
                    ->label('Вводный текст')
                    ->columnSpan('full'),
                Forms\Components\RichEditor::make('content')
                    ->label('Содержимое')
                    ->required()
                    ->columnSpan('full'),
                Forms\Components\FileUpload::make('image')
                    ->label('Изображение')
                    ->columnSpan('full'),
                Forms\Components\FileUpload::make('gallery')
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
            'index' => Pages\ListPublications::route('/'),
            'create' => Pages\CreatePublication::route('/create'),
            'edit' => Pages\EditPublication::route('/{record}/edit'),
        ];
    }
}
