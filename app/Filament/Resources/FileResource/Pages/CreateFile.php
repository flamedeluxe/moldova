<?php

namespace App\Filament\Resources\FileResource\Pages;

use App\Filament\Resources\FileResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreateFile extends CreateRecord
{
    protected static string $resource = FileResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Если загружен файл, обрабатываем его
        if (isset($data['path']) && is_array($data['path'])) {
            $uploadedFile = request()->file('path');
            
            if ($uploadedFile) {
                // Генерируем уникальное имя файла
                $fileName = time() . '_' . Str::random(10) . '.' . $uploadedFile->getClientOriginalExtension();
                
                // Сохраняем файл
                $path = $uploadedFile->storeAs('files', $fileName, 'public');
                
                // Обновляем данные
                $data['path'] = $path;
                $data['original_name'] = $uploadedFile->getClientOriginalName();
                $data['mime_type'] = $uploadedFile->getMimeType();
                $data['size'] = $uploadedFile->getSize();
                $data['extension'] = $uploadedFile->getClientOriginalExtension();
                $data['name'] = $data['name'] ?: pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            }
        }

        return $data;
    }
}
