<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class NotifyParticipants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-participants';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifica os participantes sobre eventos próximos';

    /**
     * Execute the console command.
     */
    public function handle()
    {


        $sessions = DB::table('ticketsessions')
            ->join('events', 'ticketsessions.events_id', '=', 'events.id')
            ->join('participants', 'participants.events_id', '=', 'events.id')
            ->join('users', 'participants.users_id', '=', 'users.id')
            ->where('ticketsessions.realized_at', '>=', now())
            ->select(
                'ticketsessions.session_title',
                'ticketsessions.realized_at',
                'users.email',
                'events.title as event_title'
            )
            ->get();

        foreach ($sessions as $session) {
            Mail::raw(
                "Olá, você tem uma sessão futura: '{$session->session_title}' do evento '{$session->event_title}' em {$session->realized_at}.",
                function ($message) use ($session) {
                    $message->to($session->email)
                        ->subject('Lembrete de Sessão');
                }
            );
        }

        $this->info('Notificações enviadas para os participantes.');
    }
}
