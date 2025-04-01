<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Filament\Resources\CompanyResource\RelationManagers;
use App\Models\City;
use App\Models\Company;
use App\Models\Publication;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
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

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

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
                                    ->required()
                                    ->afterStateUpdated(fn ($state, callable $set) =>
                                        $set('slug', Str::slug($state))
                                    ),
                                TextInput::make('slug')
                                    ->label('Алиас')
                                    ->required()
                                    ->unique(ignoreRecord: true),
                                Toggle::make('active')
                                    ->columnSpanFull()
                                    ->label('Активность'),
                            ]),
                        Group::make()
                            ->schema([
                                FileUpload::make('image')
                                    ->label('Изображение'),
                            ]),
                    ]),
                TextInput::make('address')
                    ->label('Адрес')
                    ->columnSpanFull()
                    ->required(),
                Textarea::make('introtext')
                    ->rows(3)
                    ->columnSpanFull()
                    ->label('Краткое описание'),
                Grid::make(2)
                    ->schema([
                        Select::make('city')
                            ->label('Город')
                            ->required()
                            ->options(City::all()->pluck('title', 'title')),
                        TextInput::make('way')
                            ->required()
                            ->label('Отрасль'),
                    ]),
                RichEditor::make('content')
                    ->columnSpanFull()
                    ->label('Контент'),
                Grid::make(3)
                    ->schema([
                        TextInput::make('phone')
                            ->label('Телефон')
                            ->mask('+7(999)999-99-99'),
                        TextInput::make('email')
                            ->label('E-mail'),
                        TextInput::make('site')
                            ->label('Сайт'),
                    ]),
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
                Tables\Columns\ToggleColumn::make('active')
                    ->label('Активность'),
            ])
            ->filters([
                Tables\Filters\Filter::make('active')
                    ->label('Активность'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\ReplicateAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()->iconButton()
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
