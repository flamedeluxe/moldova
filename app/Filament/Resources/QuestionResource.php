<?php

namespace App\Filament\Resources;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use App\Filament\Resources\QuestionResource\Pages;
use App\Models\Question;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static ?string $label = 'Вопрос';
    protected static ?string $navigationLabel = 'Вопросы';
    protected static ?string $pluralLabel = 'Вопросы';

    protected static ?string $breadcrumb = 'Вопросы';
    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Заголовок')
                    ->required()
                    ->columnSpanFull()
                    ->maxLength(255),
                Toggle::make('active')
                    ->columnSpan('full')
                    ->label('Активность'),
                Textarea::make('content')
                    ->label('Текст')
                    ->columnSpanFull()
                    ->rows(5)
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
                                TinyEditor::make('content')
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
                                FileUpload::make('gallery')
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
                                TinyEditor::make('content')
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
                                        TinyEditor::make('content')
                                            ->label('Текст')
                                            ->required(),
                                        TextInput::make('link')
                                            ->label('Ссылка на фото'),
                                    ]),
                            ]),
                        Builder\Block::make('image_right')
                            ->label('Блок с фото справа')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TinyEditor::make('content')
                                            ->label('Текст')
                                            ->required(),
                                        FileUpload::make('image')
                                            ->label('Фото')
                                            ->image()
                                            ->required(),
                                        TextInput::make('link')
                                            ->label('Ссылка на фото'),
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
                TextColumn::make('title')
                    ->searchable()
                    ->label('Заголовок'),
                ToggleColumn::make('active')
                    ->label('Активность'),
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
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }
}
