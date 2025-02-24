@extends('includes.body')
@section('title', 'Criar Evento - Revisar')
@section('content')

<div class="container my-5">
    <h1 class="display-4 fw-bold text-center mb-4">{{ $event['event_theme'] }}</h1>
    <h2 class="h5 text-center text-muted mb-5">{{ $event['location'] }}</h2>
    <h3 class="h6 text-center text-muted mb-5">{{ $event['session_date'][0] }}</h3>
    <div class="text-center mb-5">
        <img src="{{ asset('storage/progress3.png') }}" alt="Progresso" class="img-fluid" style="max-width: 800px;">
    </div>
    <div class="card shadow-lg mb-5">
        <div class="card-img-top overflow-hidden" style="height: 400px;">
            <img src="{{ url('storage/' . $event['event_banner']) }}" alt="Banner do Evento" class="img-fluid w-100 h-100 object-fit-cover">
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="h2 fw-bold mb-3">{{ $event['event_theme'] }}</h1>
                    <p class="text-muted"><i>Sessões</i></p>
                    <ol class="list-unstyled">
                        @foreach ($event['session_date'] as $index => $e)
                            <li class="mb-3">
                                <p class="mb-1"><strong>{{ $index + 1 }}ª Sessão</strong></p>
                                <p class="mb-1"><b>Dia:</b> <i>{{ $e }}</i></p>
                                <p class="mb-1"><b>Início:</b> <i>{{ $event['session_start_time'][$index] }}</i></p>
                                <p class="mb-1"><b>Fim:</b> <i>{{ $event['session_end_time'][$index] }}</i></p>
                            </li>
                        @endforeach
                    </ol>
                    <p class="mb-2"><b>Localização:</b> <i>{{ $event['location'] }}</i></p>
                    <p class="mb-4"><b>Vagas Disponíveis:</b> <i>{{ $event['vacancies'] }}</i></p>

                    <h2 class="h4 fw-bold mb-3">Informações de Acesso</h2>
                    <p class="text-muted"><i>{{ $event['payment_info'] }}</i></p>

                    <h2 class="h4 fw-bold mb-3">Ingressos</h2>
                    @if (isset($event['ticket_name']))
                        <ul class="list-unstyled">
                            @foreach ($event['ticket_name'] as $index => $ticket)
                                @if (!empty($ticket))
                                    <li class="mb-2">
                                        <p><b>{{ $ticket }} -</b> <i>{{ $event['ticket_price'][$index] }} kz</i></p>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </div>
                <div class="col-md-4 text-center">
                    <button class="btn btn-warning btn-lg w-100 mb-3" style="background-color: #FFE047; color: #2B293D;">
                        <span>-</span>
                    </button>
                </div>
            </div>
            <div class="mt-4">
                <h2 class="h4 fw-bold mb-3">Descrição</h2>
                <p class="text-justify text-muted">{{ $event['additional_info'] }}</p>
                <div class="mt-3">
                    <span class="badge bg-light text-dark">{{ $event['category'] }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end gap-3">
        <form action="/event/save" method="POST">
            @csrf
            <input type="hidden" name="event_theme" value="{{ $event['event_theme'] }}">
            @foreach ($event['session_date'] as $index => $e)
                <input type="hidden" name="session_date[]" value="{{ $e }}">
                <input type="hidden" name="session_start_time[]" value="{{ $event['session_start_time'][$index] }}">
                <input type="hidden" name="session_end_time[]" value="{{ $event['session_end_time'][$index] }}">
            @endforeach
            <input type="hidden" name="event_type" value="{{ $event['event_type'] }}">
            <input type="hidden" name="category" value="{{ $event['category'] }}">
            <input type="hidden" name="payment_info" value="{{ $event['payment_info'] }}">
            <input type="hidden" name="location" value="{{ $event['location'] }}">
            <input type="hidden" name="additional_info" value="{{ $event['additional_info'] }}">
            <input type="hidden" name="event_banner" value="{{ $event['event_banner'] }}">

            @foreach ($event['ticket_name'] as $index => $ticket)
                @if (!empty($ticket))
                    <input type="hidden" name="ticket_name[]" value="{{ $ticket }}">
                    <input type="hidden" name="ticket_price[]" value="{{ $event['ticket_price'][$index] }}">
                @endif
            @endforeach

            <input type="hidden" name="vacancies" value="{{ $event['vacancies'] }}">

            <button type="submit" name="action" value="save_later" class="btn btn-warning btn-lg">
                Publicar mais tarde
            </button>
            <button type="submit" name="action" value="publish" class="btn btn-dark btn-lg">
                Publicar
            </button>
        </form>
    </div>
</div>

@endsection