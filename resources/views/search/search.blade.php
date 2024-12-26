@extends('includes.body')

@section('title', 'Buscar Eventos')

@section('content')
<style>
    /* Estilo para o formulário */
    form {
        display: flex;
        align-items: center;
    }

    /* Estilo para o input de busca */
    .form-input {
        width: 80%; /* Define a largura do input de busca */
        padding: 0.5rem; /* Espaçamento interno do input */
        border: 1px solid #ccc; /* Borda clara */
        border-radius: 4px; /* Bordas arredondadas */
        font-size: 1rem; /* Tamanho da fonte */
    }

    /* Estilo do botão de busca */
    button {
        padding: 0.5rem 1rem; /* Espaçamento interno */
        background-color: #4F46E5; /* Cor de fundo do botão */
        color: white; /* Cor do texto */
        border-radius: 4px; /* Bordas arredondadas */
        border: none; /* Sem borda */
        cursor: pointer; /* Mostra o cursor de clique */
    }

    button:hover {
        background-color: #4338CA; /* Cor do botão quando hover */
    }

    button:focus {
        outline: none; /* Remove o contorno ao focar */
        box-shadow: 0 0 0 3px rgba(75, 85, 99, 0.4); /* Adiciona sombra ao foco */
    }
</style>

<div class="bg-cover bg-center" style="height: 420px; background-image: url({{asset('storage/party.jpg')}});">
    <div style="padding-top: 8rem; margin-bottom: 2rem; padding-left: 16%" class="flex flex-col justify-start text-justify items-start">
        <span class="text-white font-bold font-serif" style="font-weight: bold; font-size: 2rem;">
            Explore um mundo de <span style="color: #FFE047;"> eventos. </span> Encontre o seu favorito !
        </span>
    </div>
    <form action="/search" class="mt-8 flex justify-center items-center" style="width: 70%; margin: 2px auto;" method="GET">
        <input type="text" name="query" class="form-input block w-48 mt-1 p-2 border border-gray-300 rounded-md" placeholder="Pesquisar...">
        <select name="location" class="form-select mt-1 p-2 border border-gray-300 rounded-md">
            <option value="">Selecione a Localização</option>
            @foreach ($locations as $index => $loc)
            <option value="{{$loc->location}}">{{$loc->location}}</option>
            @endforeach
        </select>
        <button type="submit" style="margin-left: 12px;" class="mt-1 p-2 border border-gray-300 rounded-md bg-blue-500 text-white">
            Buscar
        </button>
    </form>
</div>

<!-- Resultados -->
<div style="padding-left: 8rem">
    <div class="flex justify-center items-center px-4 py-6 bg-white flex-wrap">
        <!-- Card -->
        @if ($events->isEmpty())
        <div style="padding: 15px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px; margin-top: 20px;">
            <strong>Atenção!</strong> Nenhum evento encontrado.
        </div>
    @else
        @foreach($events as $event)
            <div style="margin: 1.2rem 2rem;" class="flex flex-col row items-center gap-4">
                <!-- Imagem com rótulos -->
                <div class="relative rounded-md overflow-hidden" style="width: 15rem; height: 10rem;">
                    <span style="position: absolute; top: 2px; right: 2px; background-color: rgb(98, 86, 86);" class="bg-black text-white text-xs font-semibold px-2 py-1 rounded-full p-2">★</span>
                    <img src="{{ asset('storage/' . $event->banner_image) }}" alt="Evento" class="w-full h-full object-cover">
                    <span style="position: absolute; bottom: 2px; left: 2px; background-color: #FFE047;" class="text-black text-xs font-semibold px-2 py-1 rounded">{{$event->status}}</span>
                </div>

                <!-- Informações do Evento -->
                <div class="flex-col items-start  gap-4">
                    <!-- Detalhes -->
                    <div class="flex flex-col">
                        <!-- Título -->
                        <a href="/deteils/{{$event->id}}">
                        <span style="font-size: 16px;" class="text-lg font-bold leading-tight text-gray-800">
                            {{ $event->title }}
                        </span>
                        </a>
                        <!-- Tipo -->
                        <span style="font-size: 14px;" class="text-sm text-gray-600">{{ $event->realized_at }} | {{ $event->event_type }}</span>
                        <!-- Horários -->
                        <span style="font-size: 14px;" class="text-sm text-gray-600">{{ $event->start_at }} - {{ $event->end_at }}</span>
                        <!-- Vagas e Interessados -->
                        <div class="flex gap-4">
                            <span style="font-size: 14px;" class="text-sm text-gray-600">Vagas: {{ $event->vacancies }}</span>
                            <span style="font-size: 14px;" class="text-sm text-gray-600">Interessados: {{ $event->total_participants }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        @endif
    </div>
</div>

<script>
    // Filtro de eventos com JavaScript
    const filterInput = document.querySelector('input[name="query"]');

    filterInput.addEventListener('input', filterEvents);

    function filterEvents() {
        const query = filterInput.value.toLowerCase();
        const eventCards = document.querySelectorAll('.flex.flex-row');

        eventCards.forEach(card => {
            const title = card.querySelector('.text-lg').textContent.toLowerCase();

            // Filtra pelo título
            if (title.includes(query)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>

@endsection
