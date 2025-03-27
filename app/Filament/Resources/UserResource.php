<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Publication;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use App\Models\User;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $label = 'Пользователя';
    protected static ?string $navigationLabel = 'Пользователи';
    protected static ?string $pluralLabel = 'Пользователи';

    protected static ?string $breadcrumb = 'Пользователи';

    protected static ?int $navigationSort = 199;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Имя')
                    ->columnSpanFull()
                    ->required(),
                TextInput::make('email')
                    ->label('Email')
                    ->columnSpanFull()
                    ->required(),
                Select::make('role')
                    ->label('Роль')
                    ->options(User::getRoleOptions())
                    ->columnSpanFull()
                    ->required(),
                Select::make('city')
                    ->label('Город')
                    ->options(Publication::getCityOptions())
                    ->multiple()
                    ->columnSpanFull(),
                TextInput::make('password')
                    ->label('Пароль')
                    ->columnSpanFull()
                    ->revealable()
                    ->dehydrated(fn ($state) => filled($state))
                    ->minLength(6)
                    ->password(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('id'),
                TextColumn::make('name')
                    ->label('Имя')
                    ->searchable(),
                TextColumn::make('role_label')
                    ->label('Роль'),
                TextColumn::make('updated_at')
                    ->label('Дата редактирования'),
                ToggleColumn::make('active')
                    ->label('Активность')
                    ->disabled(function (User $user): bool {
                        $currentUser = auth()->user();
                        return ($user->isAdmin() && !$currentUser->isAdmin()) ||
                            $user->id === $currentUser->id;
                    }),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()
                    ->label(''),
                DeleteAction::make()
                    ->label('')
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function canDelete(Model $record): bool
    {
        return $record->name !== 'admin';
    }

    public static function canEdit(Model $record): bool
    {
        $user = auth()->user();
        return $user->role === 'admin' || $record->role !== 'admin';
    }

    public static function canViewAny(): bool
    {
        $user = auth()->user();
        return $user->role === 'admin';
    }
}
