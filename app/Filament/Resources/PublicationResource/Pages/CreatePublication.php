<?php

namespace App\Filament\Resources\PublicationResource\Pages;

use App\Filament\Resources\PublicationResource;
use App\Mail\NewPublicationCreated;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Mail;

class CreatePublication extends CreateRecord
{
    protected static string $resource = PublicationResource::class;

    protected function afterCreate(): void
    {
        $user = auth()->user();

        if ($user->role !== 'admin') {
            Mail::to(env('ADMIN_EMAIL'))->send(new NewPublicationCreated($this->record));
        }
    }
}
