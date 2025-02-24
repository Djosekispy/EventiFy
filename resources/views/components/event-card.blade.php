<div class="card shadow-sm" style="width: 20rem; height: 100%;">
    <div class="position-relative">
        <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal{{ $event->id }}">
            <img src="{{ url('storage/'.$event->banner_image) }}" class="card-img-top object-fit-cover" style="height: 200px; width: 100%; object-fit: cover;" alt="Evento">
        </a>
        @if ($event->total_participants > 0)
        <span class="position-absolute top-0 end-0 bg-dark text-white p-1 rounded">★ {{ $event->total_participants }}</span>
        @endif
    </div>
    <div class="card-body d-flex flex-column">
        <div class="d-flex align-items-center gap-3 mb-2">
            <div class="d-flex flex-column align-items-center justify-content-center bg-light text-dark fw-bold py-2 px-3 rounded shadow" style="width: 60px; height: 60px;">
                <div class="fs-5">{{ \Carbon\Carbon::parse($value->realized_at)->format('M') }}</div>
                <div class="fs-6">{{ \Carbon\Carbon::parse($value->realized_at)->format('d') }}</div>
            </div>
            <div>
                <a href="/deteils/{{$event->id}}" class="fw-bold text-dark text-decoration-none d-block">
                    {{ substr($event->title, 0, 20) }} ...
                </a>
                 <small class="text-muted d-block">{{ $event->event_type }}</small>
                <small class="text-muted d-block">{{ $event->start_at }} - {{ $event->end_at }}</small>
                <small class="text-muted d-block"><i class="fa fa-users"></i> {{ $event->vacancies }}</small>
            </div>
        </div>
    </div>
    @if ($event->user_id == Auth::id())
    <div class="container text-center mb-2">
        <a href="{{ route('event.listParticipants', $event->id) }}" class="btn btn-primary btn-sm me-3">
            <i class="fas fa-users me-2"></i> Lista de participantes
        </a>
    </div>
    @endif
    

</div>

<x-event-modal :title="$event->title" :id="$event->id" :image="$event->banner_image" />
