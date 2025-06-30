<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'original_name',
        'path',
        'url',
        'mime_type',
        'size',
        'extension',
        'description',
    ];

    protected $casts = [
        'size' => 'integer',
    ];

    /**
     * Получить полный URL к файлу
     */
    public function getFullUrlAttribute()
    {
        if ($this->url) {
            return $this->url;
        }
        
        return asset('storage/' . $this->path);
    }

    /**
     * Получить размер файла в читаемом формате
     */
    public function getFormattedSizeAttribute()
    {
        if (!$this->size) {
            return '0 B';
        }
        
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Проверить, является ли файл изображением
     */
    public function isImage()
    {
        return $this->mime_type && str_starts_with($this->mime_type, 'image/');
    }

    /**
     * Проверить, является ли файл документом
     */
    public function isDocument()
    {
        if (!$this->mime_type) {
            return false;
        }
        
        $documentTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'text/plain',
        ];
        
        return in_array($this->mime_type, $documentTypes);
    }
}
