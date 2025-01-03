@extends('includes.body')
@section('title', 'Editar sessão do Evento')
@section('content')


<h1 class="text-2xl font-serif font-bold text-center" style="padding: 20px;">Editar sessões do Evento</h1>

<h1 class="text-xl font-serif font-bold" style="padding-left: 50px; padding-top: 20px; font-weight: bold;">{{ $event->title }}</h1>
<h2 class="text-lg font-serif font-bold" style="padding-left: 50px; font-weight: 500;">{{ $event->location }}</h2>

@if (session('success'))
    <div style="color: green; padding: 10px; border: 1px solid green; margin-bottom: 10px; max-width: 600px; margin: 0 auto;">
        {{ session('success') }}
    </div>
@endif


@if (session('error'))
    <div style="color: red; padding: 10px; border: 1px solid red; margin-bottom: 10px; max-width: 600px; margin: 0 auto;">
        {{ session('error') }}
    </div>
@endif
<div style="padding: 20px; margin: 12px;">
    <form action="/event/sessions/{{$event->id}}" method="post" style="display: flex; flex-direction: column; gap: 16px; max-width: 800px; margin: 0 auto;">
        @csrf

        <div style="display: flex; flex-direction: column; gap: 8px;">
            <label style="font-weight: 500; font-size: 1rem;">Sessões</label>
            <div id="session-container" style="display: flex; flex-direction: column; gap: 16px;">


                @foreach($sessions as $session)
                <input type="hidden" name="session_id[]" value="{{ $session->id }}">
                <input type="hidden" name="removed_sessions[]" value="{{ $session->id }}">

                <div class="session" style="display: flex; gap: 12px; align-items: flex-end;">
                    <div style="flex: 1;">
                        <label>Data de Início</label>
                        <input type="date" required name="session_date[]" value="{{ \Carbon\Carbon::parse($session->realized_at)->format('Y-m-d') }}" style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;">
                    </div>
                    <div style="flex: 1;">
                        <label>Hora de Início</label>
                        <input type="time" required name="session_start_time[]" value="{{ $session->start_at }}" style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;">
                    </div>
                    <div style="flex: 1;">
                        <label>Hora de Fim</label>
                        <input type="time" required name="session_end_time[]" value="{{ $session->end_at }}" style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;">
                    </div>
                    <button type="button" class="remove-session" style="padding: 10px; background-color: red; color: white; border: none; border-radius: 4px; cursor: pointer;">
                        Remover
                    </button>
                </div>
            @endforeach

            </div>
            <button type="button" id="add-session" style="padding: 10px; background-color: green; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Adicionar Sessão
            </button>
        </div>

        <div style="display: flex; flex-direction: row; gap: 12px; justify-content: flex-end;">
            <button
            type="button"
            style="
                padding: 10px 20px;
                color: #2B293D;
                border: 1px solid #ccc;
                border-radius: 4px;
                font-size: 1rem;
                cursor: pointer;
                font-weight: 600;
            "
             onclick="history.back()"
        >
            Voltar
        </button>
        <button type="submit" style="padding: 10px 20px; background-color: #2B293D; color: white; border: none; border-radius: 4px; font-size: 1rem; cursor: pointer;">
            Continuar
        </button>
        </div>
    </form>
</div>

<script>
    document.querySelectorAll('.remove-session').forEach(button => {
    button.addEventListener('click', function () {
        const sessionId = button.parentElement.querySelector('input[name="session_id[]"]').value;
        if (sessionId) {
            const removedSessions = document.querySelector('input[name="removed_sessions"]');
            removedSessions.value += sessionId + ',';
        }
        button.parentElement.remove();
    });
});

    document.getElementById('add-session').addEventListener('click', function () {
        const sessionContainer = document.getElementById('session-container');
        const newSession = document.querySelector('.session').cloneNode(true);
        newSession.querySelectorAll('input').forEach(input => input.value = '');
        newSession.querySelector('.remove-session').addEventListener('click', function () {
            newSession.remove();
        });
        sessionContainer.appendChild(newSession);
    });

    document.querySelector('form').addEventListener('submit', function(event) {
    const sessionEndTimes = document.querySelectorAll('input[name="session_end_time[]"]');
    sessionEndTimes.forEach(function(input) {
        let value = input.value;
        if (!/^\d{2}:\d{2}$/.test(value)) {
            event.preventDefault();
            alert('Por favor, insira a hora de término no formato correto HH:MM.');
            return false;
        }
    });
});


</script>
@endsection
