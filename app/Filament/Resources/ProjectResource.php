<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use App\Models\Publication;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
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
use Filament\Forms\Components\Builder;
use Illuminate\Support\Str;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $label = 'Проект';
    protected static ?string $navigationLabel = 'Проекты';
    protected static ?string $pluralLabel = 'Проекты';

    protected static ?string $breadcrumb = 'Проекты';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
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
                Toggle::make('active')
                    ->columnSpanFull()
                    ->label('Активность'),
                Textarea::make('introtext')
                    ->columnSpanFull()
                    ->label('Вводный текст'),
                TextInput::make('phone')
                    ->mask('+7(999)999-99-99')
                    ->label('Телефон'),
                TextInput::make('email')
                    ->label('E-mail'),
                Section::make('Баннеры')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                FileUpload::make('banner')
                                    ->label('Баннер десктоп'),
                                FileUpload::make('image_m')
                                    ->label('Баннер телефон'),
                            ]),
                    ]),
                Section::make('Главный блок')
                    ->schema([
                            Grid::make(2)
                                ->schema([
                                    FileUpload::make('image_back')
                                        ->label('Фон'),
                                    FileUpload::make('image')
                                        ->label('Изображение'),
                                ])
                        ]),
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
                Builder::make('blocks')
                    ->label('Блоки')
                    ->collapsible()
                    ->columnSpan('full')
                    ->blocks([
                        Builder\Block::make('heading')
                            ->label('Заголовок')
                            ->columns(1)
                            ->schema([
                                RichEditor::make('text')
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
                        Builder\Block::make('person')
                            ->label('Личность')
                            ->schema([
                                TextInput::make('title')
                                    ->required()
                                    ->label('Заголовок'),
                                Grid::make(2)
                                    ->schema([
                                        Group::make()
                                            ->schema([
                                                FileUpload::make('image')
                                                    ->label('Фото')
                                                    ->image(),
                                                TextInput::make('phone')
                                                    ->label('Телефон'),
                                                TextInput::make('email')
                                                    ->label('E-mail'),
                                            ]),
                                        Group::make()
                                            ->schema([
                                                TextInput::make('fio')
                                                    ->required()
                                                    ->label('Фио'),
                                                Textarea::make('text')
                                                    ->required()
                                                    ->rows(3)
                                                    ->label('Текст'),
                                                Textarea::make('quote')
                                                    ->rows(8)
                                                    ->label('Цитата'),
                                            ])
                                    ]),
                            ]),
                        Builder\Block::make('banner')
                            ->label('Баннер')
                            ->schema([
                                FileUpload::make('image')
                                    ->label('Изображение десктоп')
                                    ->required()
                                    ->image(),
                                FileUpload::make('image_m')
                                    ->label('Изображение телефон')
                                    ->required()
                                    ->image(),
                                TextInput::make('link')
                                    ->required()
                                    ->label('Ссылка'),
                            ]),
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
                Tables\Columns\TextColumn::make('type_label')
                    ->label('Тип'),
                Tables\Columns\TextColumn::make('city')
                    ->label('Город'),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Дата публикации'),
                Tables\Columns\ToggleColumn::make('active')
                    ->label('Активность'),
            ])
            ->filters([
                Filter::make('published_at')
                    ->label('Дата публикации')
                    ->form([
                        DatePicker::make('published_at')
                            ->label('Выберите дату'),
                    ])
                    ->query(fn ($query, $data) => $query->when(
                        $data['published_at'],
                        fn ($query, $date) => $query->whereDate('published_at', $date)
                    )),
                SelectFilter::make('type')
                    ->label('Тип')
                    ->options(Publication::getTypeOptions()),
                Tables\Filters\Filter::make('active')
                    ->label('Активность'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label(''),
                Tables\Actions\DeleteAction::make()->label(''),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
