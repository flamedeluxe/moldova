<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FeedbackResource\Pages;
use App\Models\Feedback;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FeedbackResource extends Resource
{
    protected static ?string $model = Feedback::class;

    protected static ?string $label = 'Вопросы юристу';
    protected static ?string $navigationLabel = 'Вопросы юристу';
    protected static ?string $pluralLabel = 'Вопросы юристу';

    protected static ?string $breadcrumb = 'Вопросы юристу';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('created_at')
                    ->label('Создан')
                    ->readOnly()
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('name')
                    ->label('Имя')
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('phone')
                    ->label('Телефон')
                    ->columnSpanFull(),
                TextInput::make('email')
                    ->label('E-mail')
                    ->columnSpanFull(),
                Textarea::make('text')
                    ->label('Текст')
                    ->columnSpanFull()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->label('Имя'),
                TextColumn::make('phone')
                    ->searchable()
                    ->label('Телефон'),
                TextColumn::make('email')
                    ->searchable()
                    ->label('E-mail'),
                TextColumn::make('created_at')
                    ->searchable()
                    ->label('Текст'),
                TextColumn::make('text')
                    ->searchable()
                    ->label('Текст')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListFeedback::route('/'),
            'create' => Pages\CreateFeedback::route('/create'),
            'edit' => Pages\EditFeedback::route('/{record}/edit'),
        ];
    }

    public static function canViewAny(): bool
    {
        $user = auth()->user();
        return $user->role === 'admin';
    }
}
