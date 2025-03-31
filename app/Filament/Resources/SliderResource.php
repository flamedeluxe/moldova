<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SliderResource\Pages;
use App\Models\Slider;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;

    protected static ?string $label = 'Слайд';
    protected static ?string $navigationLabel = 'Слайды';
    protected static ?string $pluralLabel = 'Слайды';

    protected static ?string $breadcrumb = 'Слайды';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make('slides')
                    ->label('Слайды')
                    ->columnSpanFull()
                    ->schema([
                        Grid::make()
                            ->schema([
                                Group::make()
                                    ->schema([
                                        TextInput::make('title')
                                            ->label('Заголовок')
                                            ->required(),
                                        TextInput::make('text')
                                            ->label('Текст')
                                            ->required(),
                                        TextInput::make('page')
                                            ->label('Страница')
                                            ->required(),
                                        DatePicker::make('date')
                                            ->label('Текст'),
                                        TextInput::make('badge')
                                            ->label('Бейдж'),
                                        Toggle::make('active')
                                            ->label('Активность'),
                                    ]),
                                Group::make()
                                    ->schema([
                                        FileUpload::make('image')
                                            ->label('Фото')
                                            ->columnSpanFull()
                                            ->previewable(true)
                                    ])
                            ])

                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Заголовок'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->iconButton(),
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
            'index' => Pages\ListSliders::route('/'),
            'create' => Pages\CreateSlider::route('/create'),
            'edit' => Pages\EditSlider::route('/{record}/edit'),
        ];
    }
}
