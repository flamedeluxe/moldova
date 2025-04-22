<?php

namespace App\Mail;

use App\Models\Publication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewPublicationCreated extends Mailable
{
    use Queueable, SerializesModels;

    public Publication $publication;

    public function __construct(Publication $publication)
    {
        $this->publication = $publication;
    }

    public function build(): self
    {
        return $this->subject('Создана новая публикация')
            ->view('emails.new-publication')
            ->with([
                'title' => $this->publication->title,
                'city' => $this->publication->city,
                'author' => auth()->user()->name ?? 'Неизвестный',
            ]);
    }
}
