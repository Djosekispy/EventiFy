@extends('includes.body')
@section('title', 'Editar Sessão do Evento')
@section('content')

<div class="container my-5">
    <h1 class="text-center display-4 fw-bold mb-4">Editar Sessões do Evento</h1>
    <h2 class="text-center h3 fw-bold mb-3">{{ $event->title }}</h2>
    <h3 class="text-center h5 text-muted mb-5">{{ $event->location }}</h3>

    <!-- Mensagens de Sucesso e Erro -->
    @if (session('success'))
        <div class="alert alert-success text-center mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger text-center mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Formulário de Edição de Sessões -->
    <div class="card shadow-sm p-4 mx-auto" style="max-width: 800px;">
        <form action="/event/sessions/{{ $event->id }}" method="post">
            @csrf

            <!-- Sessões -->
            <div class="mb-4">
                <label class="form-label fw-bold">Sessões</label>
                <div id="session-container">
                    @foreach($sessions as $session)
                        <input type="hidden" name="session_id[]" value="{{ $session->id }}">
                        <input type="hidden" name="removed_sessions[]" value="{{ $session->id }}">

                        <div class="session mb-3">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label>Data de Início</label>
                                    <input type="date" class="form-control" name="session_date[]" value="{{ \Carbon\Carbon::parse($session->realized_at)->format('Y-m-d') }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label>Hora de Início</label>
                                    <input type="time" class="form-control" name="session_start_time[]" value="{{ $session->start_at }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label>Hora de Fim</label>
                                    <input type="time" class="form-control" name="session_end_time[]" value="{{ $session->end_at }}" required>
                                </div>
                            </div>
                            <button type="button" class="btn btn-danger btn-sm mt-2 remove-session">Remover</button>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="add-session" class="btn btn-success btn-sm">Adicionar Sessão</button>
            </div>

            <!-- Botões de Ação -->
            <div class="d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-outline-secondary" onclick="history.back()">Voltar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Adicionar nova sessão
    document.getElementById('add-session').addEventListener('click', function () {
        const sessionContainer = document.getElementById('session-container');
        const newSession = document.querySelector('.session').cloneNode(true);
        newSession.querySelectorAll('input').forEach(input => input.value = '');
        newSession.querySelector('.remove-session').addEventListener('click', function () {
            const sessionId = newSession.querySelector('input[name="session_id[]"]').value;
            if (sessionId) {
                const removedSessions = document.querySelector('input[name="removed_sessions[]"]');
                removedSessions.value += sessionId + ',';
            }
            newSession.remove();
        });
        sessionContainer.appendChild(newSession);
    });

    // Remover sessão
    document.querySelectorAll('.remove-session').forEach(button => {
        button.addEventListener('click', function () {
            const sessionId = button.parentElement.querySelector('input[name="session_id[]"]').value;
            if (sessionId) {
                const removedSessions = document.querySelector('input[name="removed_sessions[]"]');
                removedSessions.value += sessionId + ',';
            }
            button.parentElement.remove();
        });
    });

    // Validação do formulário
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