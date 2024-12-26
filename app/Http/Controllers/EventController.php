<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category;
use App\Models\Ticket;
use App\Models\Ticketsession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\EventInvitationMail;
use App\Models\Participant;


class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       try {
        $events = DB::table('events')
        ->join('categories','categories.id','=','events.category_id')
        ->leftJoin('participants','participants.events_id','=','events.id')
        ->Join('ticketsessions','ticketsessions.events_id','=','events.id')
        ->where('events.deleted_at','=',NULL)
        ->select('events.*', 'categories.category_title', DB::raw('COUNT(participants.id) as total_participants'), 'ticketsessions.session_title', 'ticketsessions.realized_at', 'ticketsessions.start_at', 'ticketsessions.end_at')
        ->groupBy('events.id', 'categories.category_title', 'ticketsessions.session_title', 'ticketsessions.realized_at', 'ticketsessions.start_at', 'ticketsessions.end_at')
        ->get();

        $events_online = DB::table('events')
        ->join('categories','categories.id','=','events.category_id')
        ->leftJoin('participants','participants.events_id','=','events.id')
        ->Join('ticketsessions','ticketsessions.events_id','=','events.id')
        ->where('events.deleted_at','=',NULL)
        ->where('event_type','online')
        ->select('events.*', 'categories.category_title', DB::raw('COUNT(participants.id) as total_participants'), 'ticketsessions.session_title', 'ticketsessions.realized_at', 'ticketsessions.start_at', 'ticketsessions.end_at')
        ->groupBy('events.id', 'categories.category_title', 'ticketsessions.session_title', 'ticketsessions.realized_at', 'ticketsessions.start_at', 'ticketsessions.end_at')
        ->get();

        $events_presencial = DB::table('events')
        ->join('categories','categories.id','=','events.category_id')
        ->leftJoin('participants','participants.events_id','=','events.id')
        ->Join('ticketsessions','ticketsessions.events_id','=','events.id')
        ->where('event_type','presencial')
        ->where('events.deleted_at','=',NULL)
        ->select('events.*', 'categories.category_title', DB::raw('COUNT(participants.id) as total_participants'), 'ticketsessions.session_title', 'ticketsessions.realized_at', 'ticketsessions.start_at', 'ticketsessions.end_at')
        ->groupBy('events.id', 'categories.category_title', 'ticketsessions.session_title', 'ticketsessions.realized_at', 'ticketsessions.start_at', 'ticketsessions.end_at')
        ->get();


          $categories = Category::all();
          $images = [
            'storage/parties.jpg',
            'storage/conference.jpg',
            'storage/workshop.jpg',
            'storage/religion.jpg',
            'storage/sport.jpg',
            'storage/others.jpg'
        ];

          return View('welcome',[
            'events' => $events,
            'events_online' => $events_online,
            'events_presencial' => $events_presencial,
            'categories' => $categories,
            'images' => $images

          ]);

       } catch (\Throwable $th) {
       return "Algo Inesperado".$th;
       }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $categories = Category::all();
                return view('event.edit',['categories' => $categories,]);

           } catch (\Throwable $th) {
            return "Algo Inesperado".$th;
           }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $categoria = Category::where('category_title', $request->category)->first();
            $data = $request->all();

            // Salvar Evento
            $event = new Event();
            $event->title = $data['event_theme'];
            $event->event_type = $data['event_type'];
            $event->location = $data['location'];
            $event->description = $data['additional_info'];
            $event->payment_info = $data['payment_info'];
            $event->banner_image = $data['event_banner'];
            $event->vacancies = $data['vacancies'];
            $event->category_id = $categoria->id;
            $event->user_id = auth()->id();
            $event->save();
            $eventId = $event->id;

            // Salvar Ingressos
            foreach ($data['ticket_name'] as $key => $value) {
                $ticket = new Ticket();
                $ticket->ticket_title = $value;
                $ticket->price = $data['ticket_price'][$key];
                $ticket->events_id = $eventId;
                $ticket->save();
            }

            // Salvar Sessões
            foreach ($data['session_date'] as $key => $value) {
                $session = new Ticketsession();
                $session->session_title = ($key + 1) . 'ª';
                $session->realized_at = $value;
                $session->start_at = $data['session_start_time'][$key];
                $session->end_at = $data['session_end_time'][$key];
                $session->events_id = $eventId;
                $session->save();
            }

            return redirect()->route('your.event')->with('success', 'Evento criado com sucesso!');
        } catch (\Throwable $th) {
            return "Algo Inesperado: " . $th->getMessage();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
            $event = DB::table('events')
            ->join('categories','categories.id','=','events.category_id')
            ->leftJoin('participants','participants.events_id','=','events.id')
            ->leftJoin('ticketsessions','ticketsessions.events_id','=','events.id')
            ->leftJoin('tickets','tickets.events_id','=','events.id')
            ->where('events.id', $id)
            ->select('events.*', 'categories.category_title', DB::raw('COUNT(participants.id) as total_participants'), 'ticketsessions.session_title', 'ticketsessions.realized_at', 'ticketsessions.start_at', 'ticketsessions.end_at', 'tickets.ticket_title', 'tickets.price')
            ->groupBy('events.id', 'categories.category_title', 'ticketsessions.session_title', 'ticketsessions.realized_at', 'ticketsessions.start_at', 'ticketsessions.end_at', 'tickets.ticket_title', 'tickets.price')
            ->get();

            $more = DB::table('events')
                    ->join('categories','categories.id','=','events.category_id')
                    ->leftJoin('participants','participants.events_id','=','events.id')
                    ->Join('ticketsessions','ticketsessions.events_id','=','events.id')
                    ->where('events.id', '<>', $id)
                    ->where('events.deleted_at','=',NULL)
                    ->select('events.*', 'categories.category_title', DB::raw('COUNT(participants.id) as total_participants'), 'ticketsessions.session_title', 'ticketsessions.realized_at', 'ticketsessions.start_at', 'ticketsessions.end_at')
                    ->groupBy('events.id', 'categories.category_title', 'ticketsessions.session_title', 'ticketsessions.realized_at', 'ticketsessions.start_at', 'ticketsessions.end_at')
                    ->take(10)
                    ->get();

                    $participante = Participant::where('events_id', $id)->get();
                    $isParticipant = Participant::where('events_id', $id)
                                            ->where('users_id', auth()->id())
                                            ->exists();

            $ticket = Ticket::where('events_id', $id)->get();
            $sessions = Ticketsession::where('events_id', $id)->get();
            $data['event'] = $event;
            $data['tickets'] =  $ticket;
            $data['sessions'] = $sessions;



            return view('search.deteils',['event' => $data, 'more' => $more, 'participante' =>  $participante, 'isParticipant' =>  $isParticipant ]);
        }catch (\Throwable $th) {
            return "Algo Inesperado".$th;
     }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

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
    try {
        $event = Event::findOrFail($id);
        if ($event->user_id !==  auth()->user()->id) {
            return back()->with([
                'error' => 'Você não tem permissão para deletar este evento.',
            ]);
        }
        $event->update(['status' => 'Cancelado']);
        $event->delete();
        return redirect('/');
    } catch (Exception $e) {
        return response()->json([
            'error' => 'Ocorreu um erro ao tentar deletar o evento.',
            'details' => $e->getMessage(),
        ], 500);
    }
}
    public function addImage(Request $request){
        try {
            $event = $request->all();
                return view('event.image',['event' => $event]);

           } catch (\Throwable $th) {
            return "Algo Inesperado".$th;
           }
    }
    public function ticket(Request $request){
        try {
            $event = $request->all();
            $request->validate([
                'event_banner' => 'required|file|mimes:jpg,png',
            ]);

            if (empty($event['event_banner'])) {
                return back()
                    ->withInput() // Repassa os dados da solicitação original
                    ->with('file_error', 'Imagem de Banner Obrigatório');
            }
            if ($request->file('event_banner')->isValid()) {
                $filePath = $request->file('event_banner')->store('uploads', 'public');
                $event['event_banner'] = $filePath;
            }
                return view('event.ticket',['event' => $event]);

           } catch (\Throwable $th) {
            return "Algo Inesperado".$th;
     }
    }
    public function review(Request $request){

        try {
            $event = $request->all();
            $categoria = Category::find($event['category'])->first();
            $event['category'] = $categoria->category_title;
                return view('event.review',['event' => $event]);
           } catch (\Throwable $th) {
            return "Algo Inesperado".$th;
     }

    }
    public function showAll(){

        $events = DB::table('events')
                    ->join('categories','categories.id','=','events.category_id')
                    ->leftJoin('participants','participants.events_id','=','events.id')
                    ->Join('ticketsessions','ticketsessions.events_id','=','events.id')
                    ->where('events.user_id', auth()->id())
                    ->where('events.deleted_at','=',NULL)
                    ->select('events.*', 'categories.category_title', DB::raw('COUNT(participants.id) as total_participants'), 'ticketsessions.session_title', 'ticketsessions.realized_at', 'ticketsessions.start_at', 'ticketsessions.end_at')
                    ->groupBy('events.id', 'categories.category_title', 'ticketsessions.session_title', 'ticketsessions.realized_at', 'ticketsessions.start_at', 'ticketsessions.end_at')
                    ->get();

        $eventsParticipating = DB::table('events')
        ->join('categories','categories.id','=','events.category_id')
        ->leftJoin('participants','participants.events_id','=','events.id')
        ->Join('ticketsessions','ticketsessions.events_id','=','events.id')
        ->where('participants.users_id', auth()->id())
        ->where('events.deleted_at','=',NULL)
        ->select('events.*', 'categories.category_title', DB::raw('COUNT(participants.id) as total_participants'), 'ticketsessions.session_title', 'ticketsessions.realized_at', 'ticketsessions.start_at', 'ticketsessions.end_at')
        ->groupBy('events.id', 'categories.category_title', 'ticketsessions.session_title', 'ticketsessions.realized_at', 'ticketsessions.start_at', 'ticketsessions.end_at')
        ->get();

        return view('home.myevents',['events' => $events, 'participantingEvent' => $eventsParticipating]);
    }

public function galery(){
    $events = Event::all();
    return view('home.galery',['events' => $events]);
}

public function sendEmail(Request $request)
{
    try {
        $event = Event::find($request->input('event_id'));
        $details = [
            'email' => $request->input('email'),
            'name' => auth()->check() ? auth()->user()->name : '',
            'message' => $request->input('message'),
            'event_name' => $event->title,
            'event_location' => $event->location,
            'event_banner' => $event->banner_image,
            'event_id' => $request->input('event_id')

        ];


        //dd( $details);

        Mail::to($details['email'])->send(new EventInvitationMail($details));

        return redirect('/deteils/' . $details['event_id'])->with('status', 'Convite enviado com sucesso!');
    } catch (\Exception $e) {
        dd( $e);
        return back()->with('error', 'Erro ao enviar o convite: ' . $e->getMessage());
    }
}


public function search(Request $request)
{
    // Receber parâmetros de busca do nome e localização
    $name = $request->input('query');
    $location = $request->input('location');
    $locations = Event::all()->unique('location');

    // Construir a query com os filtros
    $events = DB::table('events')
        ->join('categories', 'categories.id', '=', 'events.category_id')
        ->leftJoin('participants', 'participants.events_id', '=', 'events.id')
        ->join('ticketsessions', 'ticketsessions.events_id', '=', 'events.id')
        ->when($name, function ($query, $name) {
            return $query->where('events.title', 'like', '%' . $name . '%');
        })
        ->when($location, function ($query, $location) {
            return $query->where('events.location', 'like', '%' . $location . '%');
        })
        ->select(
            'events.*',
            'categories.category_title',
            DB::raw('COUNT(participants.id) as total_participants'),
            'ticketsessions.session_title',
            'ticketsessions.realized_at',
            'ticketsessions.start_at',
            'ticketsessions.end_at'
        )
        ->groupBy(
            'events.id',
            'categories.category_title',
            'ticketsessions.session_title',
            'ticketsessions.realized_at',
            'ticketsessions.start_at',
            'ticketsessions.end_at'
        )
        ->get();

    return view('search.search', ['events' => $events, 'locations' => $locations]);
}


public function searchByCategory($categoryId)
{
    // Construir a query com o filtro por categoria
    $locations = Event::all()->unique('location');
    $events = DB::table('events')
        ->join('categories', 'categories.id', '=', 'events.category_id')
        ->leftJoin('participants', 'participants.events_id', '=', 'events.id')
        ->join('ticketsessions', 'ticketsessions.events_id', '=', 'events.id')
        ->where('categories.id', $categoryId)
        ->select(
            'events.*',
            'categories.category_title',
            DB::raw('COUNT(participants.id) as total_participants'),
            'ticketsessions.session_title',
            'ticketsessions.realized_at',
            'ticketsessions.start_at',
            'ticketsessions.end_at'
        )
        ->groupBy(
            'events.id',
            'categories.category_title',
            'ticketsessions.session_title',
            'ticketsessions.realized_at',
            'ticketsessions.start_at',
            'ticketsessions.end_at'
        )
        ->get();

        return view('search.search', ['events' => $events, 'locations' => $locations]);
}

public function searchByEventType($eventTypeId)
{
    // Construir a query com o filtro por tipo de evento
    $locations = Event::all()->unique('location');

    if($eventTypeId == 'all'){
        $events = DB::table('events')
        ->join('categories', 'categories.id', '=', 'events.category_id')
        ->leftJoin('participants', 'participants.events_id', '=', 'events.id')
        ->join('ticketsessions', 'ticketsessions.events_id', '=', 'events.id')
        ->select(
            'events.*',
            'categories.category_title',
            DB::raw('COUNT(participants.id) as total_participants'),
            'ticketsessions.session_title',
            'ticketsessions.realized_at',
            'ticketsessions.start_at',
            'ticketsessions.end_at'
        )
        ->groupBy(
            'events.id',
            'categories.category_title',
            'ticketsessions.session_title',
            'ticketsessions.realized_at',
            'ticketsessions.start_at',
            'ticketsessions.end_at'
        )
        ->get();



        return view('search.search', ['events' => $events, 'locations' => $locations]);
    }else{
        $events = DB::table('events')
        ->join('categories', 'categories.id', '=', 'events.category_id')
        ->leftJoin('participants', 'participants.events_id', '=', 'events.id')
        ->join('ticketsessions', 'ticketsessions.events_id', '=', 'events.id')
        ->where('events.event_type', $eventTypeId)
        ->select(
            'events.*',
            'categories.category_title',
            DB::raw('COUNT(participants.id) as total_participants'),
            'ticketsessions.session_title',
            'ticketsessions.realized_at',
            'ticketsessions.start_at',
            'ticketsessions.end_at'
        )
        ->groupBy(
            'events.id',
            'categories.category_title',
            'ticketsessions.session_title',
            'ticketsessions.realized_at',
            'ticketsessions.start_at',
            'ticketsessions.end_at'
        )
        ->get();



        return view('search.search', ['events' => $events, 'locations' => $locations]);

    }

}
}
