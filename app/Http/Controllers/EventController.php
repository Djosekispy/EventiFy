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

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Publicado,Pendente,Cancelado,Realizado',
        ]);

        $event = Event::findOrFail($id);
        $event->status = $request->input('status');
        $event->save();

        return redirect()->back()->with('status', 'Estado do evento atualizado com sucesso!');
    }
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
        ->orderBy('events.id', 'desc') 
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
    public function create()
    {
        try {
            $categories = Category::all();
                return view('event.edit',['categories' => $categories,]);

           } catch (\Throwable $th) {
            return "Algo Inesperado".$th;
           }
    }
    public function store(Request $request)
{
    if ($request->action === 'save_later') {
        return $this->storeLater($request);
    }

    if ($request->action === 'publish') {
        return $this->publishNow($request);
    }

    return redirect()->back()->withErrors('Ação inválida.');
}
    public function publishNow(Request $request)
    {
        try {
            $categoria = Category::where('category_title', $request->category)->first();
            $data = $request->all();

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
            foreach ($data['ticket_name'] as $key => $value) {
                $ticket = new Ticket();
                $ticket->ticket_title = $value;
                $ticket->price = $data['ticket_price'][$key];
                $ticket->events_id = $eventId;
                $ticket->save();
            }
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
    public function storeLater(Request $request)
    {
        try {
            $categoria = Category::where('category_title', $request->category)->first();
            $data = $request->all();

            $event = new Event();
            $event->title = $data['event_theme'];
            $event->event_type = $data['event_type'];
            $event->location = $data['location'];
            $event->description = $data['additional_info'];
            $event->payment_info = $data['payment_info'];
            $event->banner_image = $data['event_banner'];
            $event->vacancies = $data['vacancies'];
            $event->category_id = $categoria->id;
            $event->status = 'Pendente';
            $event->user_id = auth()->id();
            $event->save();
            $eventId = $event->id;

            foreach ($data['ticket_name'] as $key => $value) {
                $ticket = new Ticket();
                $ticket->ticket_title = $value;
                $ticket->price = $data['ticket_price'][$key];
                $ticket->events_id = $eventId;
                $ticket->save();
            }

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
    public function edit(string $id)
    {
        try {
            $event = Event::findOrFail($id);
            $categories = Category::all();
            return view('event.edit', compact('event', 'categories'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Algo Inesperado: ' . $th->getMessage());
        }
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'event_theme' => 'required|string|max:255',
            'category' => 'required|exists:categories,id',
            'vacancies' => 'required|integer|min:1',
            'event_type' => 'required|in:presencial,online',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        try {
            $event = Event::findOrFail($id);

            $event->title = $validatedData['event_theme'];
            $event->category_id = $validatedData['category'];
            $event->vacancies = $validatedData['vacancies'];
            $event->event_type = $validatedData['event_type'];
            $event->location = $validatedData['location'];
            $event->description = $validatedData['description'];

            $event->save();
            return redirect()->to('/deteils/'.$id)->with('status', 'Evento atualizado com sucesso!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocorreu um erro ao atualizar o evento.');
        }
    }
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
                    ->withInput()
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
    $name = $request->input('query');
    $location = $request->input('location');
    $category = $request->input('category');
    $date = $request->input('date');
    $type = $request->input('type');

    $locations = DB::table('events')->distinct()->pluck('location');
    $categories = DB::table('categories')->distinct()->pluck('category_title');
    $eventTypes = ['online', 'presencial']; 

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
        ->when($category, function ($query, $category) {
            return $query->where('categories.category_title', 'like', '%' . $category . '%');
        })
        ->when($date, function ($query, $date) {
            return $query->whereDate('ticketsessions.realized_at', '=', $date);
        })
        ->when($type, function ($query, $type) {
            return $query->where('events.event_type', '=', $type);
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
    return view('search.search', [
        'events' => $events,
        'locations' => $locations,
        'categories' => $categories,
        'eventTypes' => $eventTypes
    ]);
}

public function searchByCategory($categoryId)
{
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

    public function editGeneral($id)
    {
        try {
            $event = Event::findOrFail($id);
            $categories = Category::all();
            return view('event.edit_general',  compact('event', 'categories'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Algo Inesperado: ' . $th->getMessage());
        }
    }

    public function editCover($id)
    {
        try {
            $event = Event::findOrFail($id);
            return view('event.edit_cover', compact('event'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Algo Inesperado: ' . $th->getMessage());
        }
    }

    public function updateBanner(Request $request, $id)
        {
            $request->validate([
                'event_banner' => 'required|image|mimes:jpeg,png|max:2048',
            ]);

            $event = Event::findOrFail($id);
            if ($event->banner_path && Storage::exists($event->banner_path)) {
                Storage::delete($event->banner_path);
            }
            $filePath = $request->file('event_banner')->store('uploads', 'public');
            $event->banner_image = $filePath;
            $event->save();
            return redirect()
                ->back()
                ->with('success', 'Imagem do evento atualizada com sucesso!');
        }


    public function editSession($id)
    {
        try {
            $event = Event::findOrFail($id);
            $sessions = Ticketsession::where('events_id', $id)->get();
            return view('event.edit_session', compact('event', 'sessions'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Algo Inesperado: ' . $th->getMessage());
        }
    }

    public function updateSessions(Request $request, $id)
    {
        try {
            $request->validate([
                'session_id.*' => 'nullable|integer|exists:ticketsessions,id',
                'session_date.*' => 'required|date',
                'session_start_time.*' => 'required|date_format:H:i',
                'session_end_time.*' => 'required|date_format:H:i|after:session_start_time.*',
            ]);

            $event = Event::findOrFail($id);
            if ($request->has('removed_sessions')) {
                TicketSession::whereIn('id', $request->removed_sessions)->delete();
            }

            foreach ($request->session_end_time as $index => $endTime) {
                if (!preg_match('/^\d{2}:\d{2}$/', $endTime)) {
                    return redirect()->back()->with('error', 'Hora de término inválida no formato HH:MM');
                }
            }
            

            foreach ($request->session_date as $index => $date) {
                $sessionId = $request->session_id[$index] ?? null;

                $sessionData = [
                    'realized_at' => $date,
                    'start_at' => $request->session_start_time[$index],
                    'end_at' => $request->session_end_time[$index],
                ];
                if ($sessionId) {
                    $session = TicketSession::find($sessionId);
                    if ($session) {
                        $session->update($sessionData);
                    }
                } else {
                    TicketSession::create([
                        'events_id' => $event->id,
                        ...$sessionData,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }

            return redirect()
                ->back()
                ->with('success',  'Sessões atualizadas com sucesso!');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Algo Inesperado: ' . $th->getMessage());
        }
    }

    public function editTicket($id)
    {
        try {
            $event = Event::findOrFail($id);
            $tickets = Ticket::where('events_id', $id)->get();
            return view('event.edit_ticket', compact('event', 'tickets'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Algo Inesperado: ' . $th->getMessage());
        }
    }
}
