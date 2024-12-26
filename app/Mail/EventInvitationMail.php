<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    /**
     * Cria uma nova instância de mensagem.
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Define o envelope da mensagem.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Convite para o Evento',
        );
    }

    /**
     * Define o conteúdo da mensagem.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.invitation', 
            with: ['details' => $this->details], 
        );
    }

    /**
     * Define os anexos para a mensagem (se houver).
     */
    public function attachments(): array
    {
        return [];
    }
}
