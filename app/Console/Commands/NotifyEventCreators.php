<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class NotifyEventCreators extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-event-creators';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifica os criadores de eventos sobre novas participações';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $events = DB::table('events')
        ->join('participants', 'participants.events_id', '=', 'events.id')
        ->join('users', 'events.user_id', '=', 'users.id')
        ->where('participants.created_at', '>=', now()->subWeek())
        ->select(
            'events.title as event_title',
            'users.email',
            DB::raw('COUNT(participants.id) as new_participants')
        )
        ->groupBy('events.id', 'users.email', 'events.title')
        ->get();

    foreach ($events as $event) {
        Mail::raw(
            "Olá, o evento '{$event->event_title}' recebeu {$event->new_participants} novos participantes na última semana.",
            function ($message) use ($event) {
                $message->to($event->email)
                    ->subject('Novas Inscrições no Evento');
            }
        );
    }

    $this->info('Notificações enviadas para os criadores de eventos.');

    }
}
