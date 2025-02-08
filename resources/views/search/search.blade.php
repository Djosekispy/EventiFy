@extends('includes.body')

@section('title', 'Buscar Eventos')

@section('content')

<div class="bg-dark text-white text-center py-5" style="background-image: url('{{ asset('storage/party.jpg') }}'); background-size: cover; background-position: center;">
    <div class="container">
        <h1 class="fw-bold">Explore um mundo de <span class="text-warning">eventos</span>. Encontre o seu favorito!</h1>
    </div>
</div>

<div class="container my-4">
    <form action="/search" method="POST" class="row g-3 p-4 rounded-3 bg-white shadow-sm" id="filter-form">
        @csrf
        @method('POST')
        <div class="col-md-4">
            <input type="text" name="query" class="form-control form-control-md border-light shadow-sm" placeholder="Pesquisar eventos..." value="{{ request()->query('query') }}">
        </div>
        <div class="col-md-2">
            <select name="category" class="form-select form-select-md border-light shadow-sm">
                <option value="">Selecione a Categoria</option>
                @foreach ($events as $category)
                    <option value="{{ $category->category_title }}" {{ request()->query('category') == $category->category_title ? 'selected' : '' }}>{{ $category->category_title }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <input type="date" name="date" class="form-control form-control-md border-light shadow-sm" value="{{ request()->query('date') }}">
        </div>
        <div class="col-md-2">
            <select name="type" class="form-select form-select-md border-light shadow-sm">
                <option value="">Selecione o Tipo</option>
                <option value="online" {{ request()->query('type') == 'online' ? 'selected' : '' }}>Online</option>
                <option value="offline" {{ request()->query('type') == 'offline' ? 'selected' : '' }}>Offline</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary btn-md w-100 shadow-sm">Buscar</button>
        </div>
    </form>
</div>


<div class="container">
    @if ($events->isEmpty())
        <div class="alert alert-danger text-center">Nenhum evento encontrado.</div>
    @else
    <div class="container d-flex flex-wrap justify-content-center gap-4" id="event-list">
        @foreach ($events as $value)
            @include('components.event-card', ['event' => $value])
        @endforeach
    </div>
    @endif
</div>

@endsection

@section('scripts')
<script>
    document.getElementById('filter-form').addEventListener('submit', function(e) {
        e.preventDefault(); 

        const query = document.querySelector('[name="query"]').value;
        const category = document.getElementById('category-filter').value;
        const date = document.getElementById('date-filter').value;
        const type = document.getElementById('type-filter').value;

        let url = `/search?query=${query}&category=${category}&date=${date}&type=${type}`;
        fetch(url)
            .then(response => response.json())
            .then(data => {
                const eventList = document.getElementById('event-list');
                eventList.innerHTML = ''; 

                if (data.events.length === 0) {
                    eventList.innerHTML = '<div class="alert alert-danger text-center">Nenhum evento encontrado.</div>';
                } else {
                    data.events.forEach(event => {
                        const eventCard = `
                            <div class="col-md-4">
                                <div class="card">
                                    <img src="${event.image}" class="card-img-top" alt="${event.title}">
                                    <div class="card-body">
                                        <h5 class="card-title">${event.title}</h5>
                                        <p class="card-text">${event.description}</p>
                                        <a href="/events.details/${event.id}" class="btn btn-primary">Ver Detalhes</a>
                                    </div>
                                </div>
                            </div>
                        `;
                        eventList.innerHTML += eventCard;
                    });
                }
            })
            .catch(error => console.error('Erro:', error));
    });
</script>
@endsection
