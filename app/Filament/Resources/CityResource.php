<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CityResource\Pages;
use App\Filament\Resources\CityResource\RelationManagers;
use App\Models\City;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class CityResource extends Resource
{
    protected static ?string $model = City::class;

    protected static ?string $label = 'Город';
    protected static ?string $navigationLabel = 'Города';
    protected static ?string $pluralLabel = 'Города';

    protected static ?string $breadcrumb = 'Города';

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Заголовок')
                    ->live(onBlur: true)
                    ->required()
                    ->columnSpan('full')
                    ->afterStateUpdated(fn ($state, callable $set) =>
                        $set('slug', Str::slug($state))
                    ),
                TextInput::make('slug')
                    ->label('Алиас')
                    ->columnSpan('full')
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('coors')
                    ->label('Координаты')
                    ->mask('99.999999,99.999999')
                    ->placeholder('00.000000, 00.000000')
                    ->columnSpan('full')
                    ->required()
                    ->unique(ignoreRecord: true),
                Grid::make(2)
                    ->schema([
                        Group::make()
                            ->schema([
                                TextInput::make('phone')
                                    ->label('Телефон')
                                    ->mask('+9 (999) 999-99-99')
                                    ->placeholder('+9 (999) 999-99-99')
                                    ->columnSpan('full'),
                                TextInput::make('address')
                                    ->label('Адрес')
                                    ->columnSpan('full'),
                            ]),
                        Group::make()
                        ->schema([
                            TextInput::make('metro')
                                ->label('Метро')
                                ->columnSpan('full'),
                            TextInput::make('time')
                                ->label('График работы')
                                ->columnSpan('full'),
                        ]),
                    ]),
                Toggle::make('active')
                    ->columnSpan('full')
                    ->label('Активность'),
                FileUpload::make('gallery')
                    ->label('Галерея')
                    ->panelLayout('grid')
                    ->previewable(true)
                    ->reorderable(true)
                    ->multiple()
                    ->columnSpan('full'),
                Repeater::make('social')
                    ->label('Соц. сети')
                    ->columnSpanFull()
                    ->schema([
                        Select::make('service')
                            ->label('Соц. сеть')
                            ->options([
                                'vk' => 'Вконтакте',
                                'ok' => 'Одноклассники',
                                'te' => 'Телеграм',
                            ])
                            ->required(),
                        TextInput::make('link')
                            ->label('Ссылка')
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->label('Название'),
                TextColumn::make('slug')
                    ->searchable()
                    ->label('Алиас'),
                ToggleColumn::make('active')
                    ->label('Активность'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label(''),
            ])
            ->bulkActions([
                //
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
            'index' => Pages\ListCities::route('/'),
            'create' => Pages\CreateCity::route('/create'),
            'edit' => Pages\EditCity::route('/{record}/edit'),
        ];
    }
}
