<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FileResource\Pages;
use App\Filament\Resources\FileResource\RelationManagers;
use App\Models\File;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Notifications\Notification;

class FileResource extends Resource
{
    protected static ?string $model = File::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?string $navigationLabel = 'Файловый менеджер';

    protected static ?string $modelLabel = 'Файл';

    protected static ?string $pluralModelLabel = 'Файлы';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('path')
                    ->label('Выберите файл')
                    ->required()
                    ->acceptedFileTypes(['image/*', 'application/pdf', 'text/*', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                    ->maxSize(10240) // 10MB
                    ->directory('files')
                    ->preserveFilenames()
                    ->afterStateUpdated(function ($state, $set) {
                        if ($state) {
                            $file = request()->file('path');
                            if ($file) {
                                $set('original_name', $file->getClientOriginalName());
                                $set('mime_type', $file->getMimeType());
                                $set('size', $file->getSize());
                                $set('extension', $file->getClientOriginalExtension());
                                $set('name', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
                            }
                        }
                    }),
                
                TextInput::make('name')
                    ->label('Название')
                    ->required()
                    ->maxLength(255),
                
                TextInput::make('url')
                    ->label('Внешняя ссылка')
                    ->url()
                    ->helperText('Если файл хранится на внешнем сервере'),
                
                Textarea::make('description')
                    ->label('Описание')
                    ->rows(3)
                    ->maxLength(1000),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('path')
                    ->label('Превью')
                    ->circular()
                    ->size(50)
                    ->visible(fn ($record) => $record && $record->isImage()),
                
                TextColumn::make('name')
                    ->label('Название')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('extension')
                    ->label('Тип')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'jpg', 'jpeg', 'png', 'gif', 'webp' => 'success',
                        'pdf' => 'danger',
                        'doc', 'docx' => 'primary',
                        'xls', 'xlsx' => 'warning',
                        default => 'gray',
                    }),
                
                TextColumn::make('formatted_size')
                    ->label('Размер')
                    ->sortable(query: fn ($query, $direction) => $query->orderBy('size', $direction)),
                
                TextColumn::make('created_at')
                    ->label('Дата загрузки')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('extension')
                    ->label('Тип файла')
                    ->options([
                        'jpg' => 'Изображения (JPG)',
                        'png' => 'Изображения (PNG)',
                        'pdf' => 'Документы (PDF)',
                        'doc' => 'Документы (DOC)',
                        'docx' => 'Документы (DOCX)',
                    ]),
            ])
            ->actions([
                Action::make('copy_link')
                    ->label('Показать ссылку')
                    ->icon('heroicon-o-clipboard')
                    ->action(function (File $record) {
                        $url = $record->full_url;
                        
                        // Показываем уведомление с ссылкой
                        Notification::make()
                            ->title('Ссылка на файл')
                            ->body('Скопируйте ссылку: ' . $url)
                            ->success()
                            ->send();
                    }),
                
                ViewAction::make()
                    ->url(fn (File $record): string => $record->full_url)
                    ->openUrlInNewTab(),
                
                Action::make('download')
                    ->label('Скачать')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (File $record): string => $record->full_url)
                    ->openUrlInNewTab(),
                
                EditAction::make(),
                DeleteAction::make()
                    ->before(function (File $record) {
                        // Удаляем файл с диска
                        if ($record->path && !$record->url) {
                            Storage::disk('public')->delete($record->path);
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records) {
                            // Удаляем файлы с диска
                            foreach ($records as $record) {
                                if ($record->path && !$record->url) {
                                    Storage::disk('public')->delete($record->path);
                                }
                            }
                        }),
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
            'index' => Pages\ListFiles::route('/'),
            'create' => Pages\CreateFile::route('/create'),
            'edit' => Pages\EditFile::route('/{record}/edit'),
        ];
    }
}
