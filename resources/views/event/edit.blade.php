@extends('includes.body')
@section('title', 'Criar Evento')
@section('content')

<div class="container my-5">
    <h1 class="text-center display-4 fw-bold mb-4">Criar Novo Evento</h1>

    <!-- Progress Bar -->
    <div class="d-flex justify-content-center mb-5">
        <img src="{{ asset('storage/progress.png') }}" alt="Progresso" class="img-fluid" style="max-width: 800px;">
    </div>

    <!-- Formulário de Criação de Evento -->
    <div class="card shadow-sm p-4 mx-auto" style="max-width: 800px;">
        <form action="/event/banner" method="post">
            @csrf
            <h4 class="text-center fw-bold mb-4">Detalhes do Evento</h4>

            <!-- Tema do Evento -->
            <div class="mb-3">
                <label for="event-theme" class="form-label fw-bold">Tema do Evento</label>
                <input type="text" class="form-control" id="event-theme" name="event_theme" placeholder="Digite o tema do evento" required>
            </div>

            <!-- Categoria e Vagas -->
            <div class="row mb-3">
                <div class="col-md-8">
                    <label for="category" class="form-label fw-bold">Categoria</label>
                    <select class="form-select" id="category" name="category" required>
                        <option value="" disabled selected>Selecione</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="vacancies" class="form-label fw-bold">Total de Vagas</label>
                    <input type="number" class="form-control" id="vacancies" name="vacancies" required>
                </div>
            </div>

            <!-- Tipo de Evento -->
            <div class="mb-3">
                <label class="form-label fw-bold">Tipo de Evento</label>
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="event_type" id="presencial" value="presencial" required>
                        <label class="form-check-label" for="presencial">Presencial</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="event_type" id="online" value="online" required>
                        <label class="form-check-label" for="online">Online</label>
                    </div>
                </div>
            </div>

            <!-- Sessões -->
            <div class="mb-3">
                <label class="form-label fw-bold">Sessões</label>
                <div id="session-container">
                    <!-- Template de Sessão -->
                    <div class="session mb-3">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label>Data de Início</label>
                                <input type="date" class="form-control" name="session_date[]" required>
                            </div>
                            <div class="col-md-4">
                                <label>Hora de Início</label>
                                <input type="time" class="form-control" name="session_start_time[]" required>
                            </div>
                            <div class="col-md-4">
                                <label>Hora de Fim</label>
                                <input type="time" class="form-control" name="session_end_time[]" required>
                            </div>
                        </div>
                        <button type="button" class="btn btn-danger btn-sm mt-2 remove-session">Remover</button>
                    </div>
                </div>
                <button type="button" id="add-session" class="btn btn-success btn-sm">Adicionar Sessão</button>
            </div>

            <!-- Localização -->
            <div class="mb-3">
                <label for="location" class="form-label fw-bold">Localização</label>
                <input type="text" class="form-control" id="location" name="location" placeholder="Digite o local do evento" required>
            </div>

            <!-- Descrição -->
            <div class="mb-4">
                <label for="additional_info" class="form-label fw-bold">Descrição</label>
                <textarea class="form-control" id="additional_info" name="additional_info" rows="4" placeholder="Digite informações adicionais" required></textarea>
            </div>

            <!-- Botão de Continuar -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">Continuar</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('add-session').addEventListener('click', function () {
        const sessionContainer = document.getElementById('session-container');
        const newSession = document.querySelector('.session').cloneNode(true);
        newSession.querySelectorAll('input').forEach(input => input.value = '');
        newSession.querySelector('.remove-session').addEventListener('click', function () {
            newSession.remove();
        });
        sessionContainer.appendChild(newSession);
    });

    document.querySelectorAll('.remove-session').forEach(button => {
        button.addEventListener('click', function () {
            button.closest('.session').remove();
        });
    });
</script>

@endsection