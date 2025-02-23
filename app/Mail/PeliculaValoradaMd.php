<?php

namespace App\Mail;

use App\Models\Pelicula;
use App\Models\Valoracion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PeliculaValoradaMd extends Mailable
{
    use Queueable, SerializesModels;

    public $valoracion;
    public $pelicula;

    /**
     * Create a new message instance.
     */
    public function __construct(Valoracion $valoracion, Pelicula $pelicula)
    {
        $this->valoracion = $valoracion;
        $this->pelicula = $pelicula;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pelicula Valorada Md',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.pelicula-valorada-md',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
