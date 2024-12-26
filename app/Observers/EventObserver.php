<?php

namespace App\Observers;

use App\Models\Event;

class EventObserver
{
    /**
     * Handle the Event "created" event.
     */
    public function created(Event $event): void
    {
        //
    }

    /**
     * Handle the Event "updated" event.
     */
    public function updated(Event $event): void
    {
            $sessions = DB::table('ticketsessions')
                ->join('events', 'ticketsessions.events_id', '=', 'events.id')
                ->join('participants', 'participants.events_id', '=', 'events.id')
                ->join('users', 'participants.users_id', '=', 'users.id')
                ->where('events.id', $event->id)
                ->select(
                    'ticketsessions.session_title',
                    'ticketsessions.realized_at',
                    'users.email',
                    'events.title as event_title'
                )
                ->get();

            foreach ($sessions as $session) {
                Mail::raw(
                    "Olá, o evento '{$session->event_title}' foi atualizado. Além disso, você tem uma sessão futura: '{$session->session_title}' marcada para {$session->realized_at}.",
                    function ($message) use ($session) {
                        $message->to($session->email)
                            ->subject("Atualização no evento: {$session->event_title}");
                    }
                );


            info('Notificações enviadas para os participantes do evento atualizado.');
        }
    }

    /**
     * Handle the Event "deleted" event.
     */
    public function deleted(Event $event): void
    {
        //
    }

    /**
     * Handle the Event "restored" event.
     */
    public function restored(Event $event): void
    {
        //
    }

    /**
     * Handle the Event "force deleted" event.
     */
    public function forceDeleted(Event $event): void
    {
        //
    }
}
