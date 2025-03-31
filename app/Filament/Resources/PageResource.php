<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\RelationManagers;
use App\Models\Page;
use App\Models\Publication;
use Filament\Forms;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;


class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $label = 'Страницу';
    protected static ?string $navigationLabel = 'Страницы';
    protected static ?string $pluralLabel = 'Страницы';

    protected static ?string $breadcrumb = 'Страницы';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Заголовок')
                    ->columnSpanFull()
                    ->required()
                    ->maxLength(255),
                Builder::make('blocks')
                    ->label('Блоки')
                    ->collapsible()
                    ->columnSpan('full')
                    ->blocks([
                        Builder\Block::make('heading')
                            ->label('Заголовок')
                            ->columns(1)
                            ->schema([
                                Select::make('level')
                                    ->label('Уровень')
                                    ->options([
                                        'h1' => 'H1',
                                        'h2' => 'H2',
                                        'h3' => 'H3',
                                        'h4' => 'H4',
                                        'h5' => 'H5',
                                        'h6' => 'H6',
                                    ])
                                    ->required(),
                                TextInput::make('text')
                                    ->label('Текст')
                                    ->required(),
                            ]),
                        Builder\Block::make('paragraph')
                            ->label('Параграф')
                            ->schema([
                                RichEditor::make('content')
                                    ->label('Содержимое')
                                    ->required(),
                            ]),
                        Builder\Block::make('image')
                            ->label('Изображение')
                            ->schema([
                                FileUpload::make('image')
                                    ->label('Фото')
                                    ->image()
                                    ->required(),

                            ]),
                        Builder\Block::make('gallery')
                            ->label('Галерея')
                            ->schema([
                                Forms\Components\FileUpload::make('gallery')
                                    ->label('Галерея')
                                    ->panelLayout('grid')
                                    ->previewable(true)
                                    ->reorderable(true)
                                    ->multiple()
                                    ->columnSpan('full'),
                            ]),
                        Builder\Block::make('block')
                            ->label('Блок с фоном')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Заголовок')
                                    ->required(),
                                RichEditor::make('content')
                                    ->label('Текст')
                                    ->required(),
                            ]),
                        Builder\Block::make('blockquote')
                            ->label('Цитата')
                            ->schema([
                                Textarea::make('content')
                                    ->label('Текст')
                                    ->rows(5)
                                    ->required(),
                                TextInput::make('caption')
                                    ->label('Подпись'),
                            ]),
                        Builder\Block::make('image_left')
                            ->label('Блок с фото слева')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        FileUpload::make('image')
                                            ->label('Фото')
                                            ->image()
                                            ->required(),
                                        RichEditor::make('content')
                                            ->label('Текст')
                                            ->required(),
                                    ]),
                            ]),
                        Builder\Block::make('image_right')
                            ->label('Блок с фото справа')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        RichEditor::make('content')
                                            ->label('Текст')
                                            ->required(),
                                        FileUpload::make('image')
                                            ->label('Фото')
                                            ->image()
                                            ->required(),
                                    ]),
                            ]),
                        Builder\Block::make('cards')
                            ->label('Карточки с подписями')
                            ->schema([
                                TextInput::make('title')
                                    ->columnSpanFull()
                                    ->label('Заголовок'),
                                Grid::make(2)
                                    ->schema([
                                        Repeater::make('items')
                                            ->label('Элементы')
                                            ->columnSpanFull()
                                            ->grid(3)
                                            ->schema([
                                                FileUpload::make('image')
                                                    ->label('Фото')
                                                    ->columnSpanFull()
                                                    ->image(),
                                                TextInput::make('title')
                                                    ->columnSpanFull()
                                                    ->label('Заголовок'),
                                                TextInput::make('text')
                                                    ->columnSpanFull()
                                                    ->label('Текст'),
                                            ]),
                                    ]),
                            ]),
                        Builder\Block::make('logos')
                            ->label('Карточки')
                            ->schema([
                                TextInput::make('title')
                                    ->columnSpanFull()
                                    ->label('Заголовок'),
                                Grid::make(2)
                                    ->schema([
                                        Repeater::make('items')
                                            ->label('Элементы')
                                            ->columnSpanFull()
                                            ->grid(4)
                                            ->schema([
                                                FileUpload::make('image')
                                                    ->label('Фото')
                                                    ->columnSpanFull()
                                                    ->image(),
                                            ]),
                                    ]),
                            ]),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->label('Заголовок'),
                Tables\Columns\ToggleColumn::make('active')
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
