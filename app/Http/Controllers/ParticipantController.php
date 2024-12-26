<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;
use App\Models\Event;

use Illuminate\Support\Facades\DB;

class ParticipantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            // Verifica se o evento existe
            $event = DB::table('events')
            ->join('categories','categories.id','=','events.category_id')
            ->leftJoin('participants','participants.events_id','=','events.id')
            ->leftJoin('ticketsessions','ticketsessions.events_id','=','events.id')
            ->leftJoin('tickets','tickets.events_id','=','events.id')
            ->where('events.id', $id)
            ->select('events.*', 'categories.category_title', DB::raw('COUNT(participants.id) as total_participants'), 'ticketsessions.session_title', 'ticketsessions.realized_at', 'ticketsessions.start_at', 'ticketsessions.end_at', 'tickets.ticket_title', 'tickets.price')
            ->groupBy('events.id', 'categories.category_title', 'ticketsessions.session_title', 'ticketsessions.realized_at', 'ticketsessions.start_at', 'ticketsessions.end_at', 'tickets.ticket_title', 'tickets.price')
            ->first();
            // Verifica se o organizador é o mesmo usuário
            if ($event->user_id === auth()->id()) {
                return back()->with('error', 'Você não pode participar de um evento que você organiza.');
            }

            // Verifica se o usuário já está participando do evento
            $alreadyParticipating = Participant::where('users_id', auth()->id())
                ->where('events_id', $id)
                ->exists();

            if ($alreadyParticipating) {
                dd('Já está participando');
                return back()->with('error', 'Você já está participando deste evento.');
            }

            // Cria a participação
            $participate = Participant::create([
                'users_id' => auth()->id(),
                'events_id' => $id,
            ]);

            return redirect('/deteils/' . $id)->with('status', 'Novo participante adicionado com sucesso!');
        } catch (\Throwable $th) {
            // Trata exceções e exibe uma mensagem de erro

            dd($th->getMessage());
            return back()->with('error', 'Erro ao participar do evento: ' . $th->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
