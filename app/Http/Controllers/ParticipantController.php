<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ParticipantController extends Controller
{

    public function index()
    {
        $participants = Participant::with(['event', 'user'])->paginate(10);
        return view('participants.index', compact('participants'));
    }

    public function create()
    {
        $events = Event::all();
        return view('participants.create', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'events_id' => 'required|exists:events,id',
            'users_id' => 'required|exists:users,id',
        ]);

        $alreadyParticipating = Participant::where('users_id', $request->users_id)
            ->where('events_id', $request->events_id)
            ->exists();

        if ($alreadyParticipating) {
            return back()->with('error', 'Este usuário já está participando deste evento.');
        }

        Participant::create([
            'events_id' => $request->events_id,
            'users_id' => $request->users_id,
        ]);

        $event = Event::find($request->events_id);

        if ($event) {
            $eventCreator = User::find($event->user_id);
            $participant = User::find($request->users_id);
            if ($eventCreator) {
                Mail::send('emails.new_participant', [
                    'event' => $event,
                    'user' => $eventCreator,
                    'participant' => $participant 
                ], function ($message) use ($eventCreator, $event) {
                    $message->to($eventCreator->email)
                        ->subject("Nova inscrição no evento: {$event->title}");
                });
    
                info("Notificação enviada para o criador do evento sobre a nova inscrição.");
            }
        }

        return redirect()->route('participants.index')->with('status', 'Participante adicionado com sucesso!');
    }

    public function show(string $id)
    {
        try {
            $event = DB::table('events')
                ->join('categories', 'categories.id', '=', 'events.category_id')
                ->leftJoin('participants', 'participants.events_id', '=', 'events.id')
                ->leftJoin('ticketsessions', 'ticketsessions.events_id', '=', 'events.id')
                ->leftJoin('tickets', 'tickets.events_id', '=', 'events.id')
                ->where('events.id', $id)
                ->select('events.*', 'categories.category_title', DB::raw('COUNT(participants.id) as total_participants'), 'ticketsessions.session_title', 'ticketsessions.realized_at', 'ticketsessions.start_at', 'ticketsessions.end_at', 'tickets.ticket_title', 'tickets.price')
                ->groupBy('events.id', 'categories.category_title', 'ticketsessions.session_title', 'ticketsessions.realized_at', 'ticketsessions.start_at', 'ticketsessions.end_at', 'tickets.ticket_title', 'tickets.price')
                ->first();

            if (!$event) {
                return back()->with('error', 'Evento não encontrado.');
            }
            if ($event->user_id === auth()->id()) {
                return back()->with('error', 'Você não pode participar de um evento que você organiza.');
            }
            $alreadyParticipating = Participant::where('users_id', auth()->id())
                ->where('events_id', $id)
                ->exists();

            if ($alreadyParticipating) {
                return back()->with('error', 'Você já está participando deste evento.');
            }

            Participant::create([
                'users_id' => auth()->id(),
                'events_id' => $id,
            ]);

            return redirect('/deteils/' . $id)->with('status', 'Novo participante adicionado com sucesso!');
        } catch (\Throwable $th) {
            return back()->with('error', 'Erro ao participar do evento: ' . $th->getMessage());
        }
    }

    public function edit(string $id)
    {
        $participant = Participant::findOrFail($id);
        $events = Event::all();
        return view('participants.edit', compact('participant', 'events'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'events_id' => 'required|exists:events,id',
            'users_id' => 'required|exists:users,id',
        ]);
        $participant = Participant::findOrFail($id);
        $participant->update([
            'events_id' => $request->events_id,
            'users_id' => $request->users_id,
        ]);

        return redirect()->route('participants.index')->with('status', 'Participante atualizado com sucesso!');
    }

    public function destroy(string $id)
    {
        $participant = Participant::where('users_id', $id)->first();
    
        if (!$participant) {
            return redirect()->back()->with('error', 'Participante não encontrado.');
        }
    
        $event = Event::find($participant->events_id);
    
        if ($event) {
            $eventCreator = User::find($event->user_id);
    
            if ($eventCreator) {
                $participantUser = User::find($id);
    
                if ($participantUser) {
                    Mail::send('emails.cancel_participant', [
                        'event' => $event,
                        'user' => $eventCreator,
                        'participant' => $participantUser
                    ], function ($message) use ($eventCreator, $event) {
                        $message->to($eventCreator->email)
                            ->subject("Cancelamento de Inscrição: {$event->title}");
                    });
    
                    info("Notificação enviada para o criador do evento sobre o cancelamento de inscrição.");
                }
            }
        }
    
        // Remove o participante
        $participant->delete();
    
        return redirect()->back()->with('status', 'Participante removido com sucesso!');
    }

}