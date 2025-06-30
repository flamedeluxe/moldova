<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
        ]);

        $uploadedFile = $request->file('file');
        
        // Генерируем уникальное имя файла
        $fileName = time() . '_' . Str::random(10) . '.' . $uploadedFile->getClientOriginalExtension();
        
        // Сохраняем файл
        $path = $uploadedFile->storeAs('files', $fileName, 'public');
        
        // Создаем запись в базе данных
        $file = File::create([
            'name' => pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME),
            'original_name' => $uploadedFile->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $uploadedFile->getMimeType(),
            'size' => $uploadedFile->getSize(),
            'extension' => $uploadedFile->getClientOriginalExtension(),
            'description' => $request->input('description'),
        ]);

        return response()->json([
            'success' => true,
            'file' => $file,
            'url' => $file->full_url,
        ]);
    }

    public function show(File $file)
    {
        return response()->json($file);
    }

    public function download(File $file)
    {
        if ($file->url) {
            return redirect($file->url);
        }

        if (!Storage::disk('public')->exists($file->path)) {
            abort(404);
        }

        return response()->download(
            Storage::disk('public')->path($file->path), 
            $file->original_name
        );
    }

    public function destroy(File $file)
    {
        // Удаляем файл с диска
        if ($file->path && !$file->url) {
            Storage::disk('public')->delete($file->path);
        }

        // Удаляем запись из базы данных
        $file->delete();

        return response()->json(['success' => true]);
    }
}
