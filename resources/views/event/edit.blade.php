@extends('includes.body')
@section('title', 'Criar Evento')
@section('content')
<h1 class="text-2xl font-serif font-bold text-center" style="padding: 20px;">Criar Novo Evento</h1>

<div style="width: 70%; margin: 0 auto; padding: 20px; display: flex; justify-content: center;">
    <img src="{{asset('storage/progress.png')}}" alt="Progresso" style="width: 100%; max-width: 800px; object-fit: cover;">
</div>

<div style="padding: 20px; margin: 12px;">
    <form action="/event/banner" method="post" style="display: flex; flex-direction: column; gap: 16px; max-width: 800px; margin: 0 auto;">
        @csrf
        <h4 style="font-weight: bold; font-size: 1.5rem; margin-bottom: 12px; text-align: center; color: #333;">Detalhes do Evento</h4>

        <!-- Tema do Evento -->
        <div style="display: flex; flex-direction: column; gap: 8px;">
            <label for="event-theme" style="font-weight: 500; font-size: 1rem;">Tema do Evento</label>
            <input type="text" required id="event-theme" name="event_theme" placeholder="Digite o tema do evento" style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;">
        </div>

        <!-- Categoria -->
        <div style="display: flex; flex-direction: row; gap: 8px;">
            <div style="flex: 3;">
            <label for="category" style="font-weight: 500; font-size: 1rem;">Categoria</label>
            <select id="category" name="category" required style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;">
                <option value="" disabled selected>Selecione</option>
                @foreach ($categories as $index => $category )
                <option value="{{$category->id}}">{{$category->category_title}}</option>
                @endforeach
            </select>
        </div>
            <div>
                <label>Total de Vagas</label>
                <input type="number" required required name="vacancies" style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;">
            </div>
        </div>

        <!-- Tipo de Evento -->
        <div style="display: flex; flex-direction: column; gap: 8px;">
            <label style="font-weight: 500; font-size: 1rem;">Tipo de Evento</label>
            <div style="display: flex; gap: 12px;">
                <label style="display: flex; align-items: center; gap: 8px;">
                    <input type="radio" name="event_type" value="presencial">
                    Presencial
                </label>
                <label style="display: flex; align-items: center; gap: 8px;">
                    <input type="radio"  name="event_type" value="online">
                    Online
                </label>
            </div>
        </div>

        <!-- Sessões -->
        <div style="display: flex; flex-direction: column; gap: 8px;">
            <label style="font-weight: 500; font-size: 1rem;">Sessões</label>
            <div id="session-container" style="display: flex; flex-direction: column; gap: 16px;">
                <!-- Template de Sessão -->
                <div class="session" style="display: flex; gap: 12px; align-items: flex-end;">
                    <div style="flex: 1;">
                        <label>Data de Início</label>
                        <input type="date" required name="session_date[]" style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;">
                    </div>
                    <div style="flex: 1;">
                        <label>Hora de Início</label>
                        <input type="time" required name="session_start_time[]" style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;">
                    </div>
                    <div style="flex: 1;">
                        <label>Hora de Fim</label>
                        <input type="time" required name="session_end_time[]" style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;">
                    </div>
                    <button type="button" class="remove-session" style="padding: 10px; background-color: red; color: white; border: none; border-radius: 4px; cursor: pointer;">
                        Remover
                    </button>
                </div>
            </div>
            <button type="button" id="add-session" style="padding: 10px; background-color: green; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Adicionar Sessão
            </button>
        </div>

        <!-- Localização -->
        <div style="display: flex; flex-direction: column; gap: 8px;">
            <label style="font-weight: 500; font-size: 1rem;">Localização</label>
            <input type="text" required name="location" placeholder="Digite o local do evento" style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;">
        </div>

        <!-- Informação Adicional -->
        <div style="display: flex; flex-direction: column; gap: 8px;">
            <label style="font-weight: 500; font-size: 1rem;">Descrição</label>
            <textarea name="additional_info" required placeholder="Digite informações adicionais" style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;"></textarea>
        </div>

        <!-- Botão de Salvar -->
        <button type="submit" style="padding: 10px 20px; background-color: #2B293D; color: white; border: none; border-radius: 4px; font-size: 1rem; cursor: pointer;">
            Continuar
        </button>
    </form>
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
            button.parentElement.remove();
        });
    });
</script>
@endsection
