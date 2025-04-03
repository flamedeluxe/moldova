<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CitizenResource\Pages;
use App\Filament\Resources\CitizenResource\RelationManagers;
use App\Models\Citizen;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class CitizenResource extends Resource
{
    protected static ?string $model = Citizen::class;

    protected static ?string $label = 'Гражданин';
    protected static ?string $navigationLabel = 'Граждане';
    protected static ?string $pluralLabel = 'Граждане';

    protected static ?string $breadcrumb = 'Граждане';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Имя')
                    ->required()
                    ->columnSpan('full'),
                TextInput::make('surname')
                    ->label('Фамилия')
                    ->required()
                    ->columnSpan('full'),
                TextInput::make('patronymic')
                    ->label('Отчество')
                    ->columnSpan('full'),
                TextInput::make('phone')
                    ->label('Телефон')
                    ->columnSpan('full'),
                TextInput::make('email')
                    ->label('E-mail')
                    ->columnSpan('full'),
                TextInput::make('card')
                    ->label('Карта')
                    ->columnSpan('full'),
                TextInput::make('id_number')
                    ->label('Идентификатор')
                    ->columnSpan('full'),
                Select::make('user_id')
                    ->label('Пользователь')
                    ->relationship('user', 'name') // связь с users
                    ->searchable()
                    ->preload()
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->label('Имя'),
                TextColumn::make('surname')
                    ->searchable()
                    ->label('Фамилия'),
                TextColumn::make('card')
                    ->searchable()
                    ->label('Карта'),
                TextColumn::make('id_number')
                    ->searchable()
                    ->label('Идентификатор'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->iconButton(),
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
            'index' => Pages\ListCitizens::route('/'),
            'create' => Pages\CreateCitizen::route('/create'),
            'edit' => Pages\EditCitizen::route('/{record}/edit'),
        ];
    }
}
