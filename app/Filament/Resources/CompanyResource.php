<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Models\City;
use App\Models\Company;
use App\Models\Publication;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $label = 'Организацию';
    protected static ?string $navigationLabel = 'Организации';
    protected static ?string $pluralLabel = 'Организации';

    protected static ?string $breadcrumb = 'Организации';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        Group::make()
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
                                Select::make('city')
                                    ->label('Город')
                                    ->options(City::all()->pluck('title', 'title'))
                                    ->columnSpanFull(),
                                TextInput::make('category')
                                    ->label('Категория')
                                    ->maxLength(255),
                            ]),

                        Group::make()
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->label('Изображение'),
                            ]),
                    ]),
            ]);


    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
