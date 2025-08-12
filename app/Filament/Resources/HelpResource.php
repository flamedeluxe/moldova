<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HelpResource\Pages;
use App\Filament\Resources\HelpResource\RelationManagers;
use App\Models\Help;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HelpResource extends Resource
{
    protected static ?string $model = Help::class;

    protected static ?string $label = 'Обратная связь';
    protected static ?string $navigationLabel = 'Обратная связь';
    protected static ?string $pluralLabel = 'Обратная связь';
    protected static ?string $breadcrumb = 'Обратная связь';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('surname')
                    ->label('Фамилия')
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->label('Имя')
                    ->maxLength(255),
                Forms\Components\TextInput::make('patrynomic')
                    ->label('Отчество')
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->label('Телефон')
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->maxLength(255),
                Forms\Components\Textarea::make('text')
                    ->label('Текст')
                    ->rows(6),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('surname')
                    ->label('Фамилия')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Имя')
                    ->searchable(),
                Tables\Columns\TextColumn::make('patrynomic')
                    ->label('Отчество')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Телефон')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('text')
                    ->label('Текст'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Редактировать'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->label('Удалить выбранные'),
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
            'index' => Pages\ListHelps::route('/'),
            'create' => Pages\CreateHelp::route('/create'),
            'edit' => Pages\EditHelp::route('/{record}/edit'),
        ];
    }
}
