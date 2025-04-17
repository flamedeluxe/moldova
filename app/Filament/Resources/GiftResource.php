<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GiftResource\Pages;
use App\Models\Gift;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class GiftResource extends Resource
{
    protected static ?string $model = Gift::class;

    protected static ?string $label = 'Предложение';
    protected static ?string $navigationLabel = 'Предложения';
    protected static ?string $pluralLabel = 'Предложения';

    protected static ?string $breadcrumb = 'Предложения';

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Название')
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(255),
                RichEditor::make('content')
                    ->label('Содержимое')
                    ->required()
                    ->columnSpan('full'),
                FileUpload::make('image')
                    ->label('Фото')
                    ->columnSpanFull()
                    ->image()
                    ->required(),
                Toggle::make('active')
                    ->columnSpan('full')
                    ->default(true)
                    ->label('Активность'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Фото'),
                TextColumn::make('title')
                    ->searchable()
                    ->label('Название'),
                ToggleColumn::make('active')
                    ->label('Активность'),
            ])
            ->filters([
                //
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
            'index' => Pages\ListGifts::route('/'),
            'create' => Pages\CreateGift::route('/create'),
            'edit' => Pages\EditGift::route('/{record}/edit'),
        ];
    }
}
