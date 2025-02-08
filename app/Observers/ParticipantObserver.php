<?php

namespace App\Observers;

use App\Models\Participant;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ParticipantObserver
{
    /**
     * Handle the Participant "created" event.
     */
    public function created(Participant $participant): void
    {
        // Busca o evento associado ao participante
        $event = Event::find($participant->events_id);

        if ($event) {
            // Busca o criador do evento
            $eventCreator = User::find($event->user_id);

            if ($eventCreator) {
                // Envia um e-mail para o criador do evento
                Mail::send('emails.new_participant', ['event' => $event, 'user' => $eventCreator], function ($message) use ($eventCreator, $event) {
                    $message->to($eventCreator->email)
                        ->subject("Nova inscrição no evento: {$event->title}");
                });

                info("Notificação enviada para o criador do evento sobre a nova inscrição.");
            }
        }
    }

    /**
     * Handle the Participant "deleted" event.
     */
    public function deleted(Participant $participant): void
    {
        // Busca o evento associado ao participante
        $event = Event::find($participant->events_id);

        if ($event) {
            // Busca o criador do evento
            $eventCreator = User::find($event->user_id);

            if ($eventCreator) {
                // Envia um e-mail para o criador do evento
                Mail::raw(
                    "Olá, {$eventCreator->name}, um usuário cancelou a inscrição no seu evento '{$event->title}'.",
                    function ($message) use ($eventCreator, $event) {
                        $message->to($eventCreator->email)
                            ->subject("Cancelamento de inscrição no evento: {$event->title}");
                    }
                );

            

                info("Notificação enviada para o criador do evento sobre o cancelamento de inscrição.");
            }
        }
    }
}