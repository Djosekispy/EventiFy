
@extends('includes.body')

@section('title', 'Página Inicial')

@section('content')


<div class="position-relative bg-dark text-white" style="height: 420px; background: url('{{ asset('storage/party.jpg') }}') center/cover no-repeat;">
    <div class="container d-flex flex-column justify-content-center text-start" style="padding: 6% 16% 2% 16%;">
        <h2 class="fw-bold">Não Fique de Fora!</h2>
        <h2 class="fw-bold">Explore os <span class="text-warning">eventos vibrantes</span> que estão acontecendo</h2>
    </div>
    
    <div class="container mt-5">
        <form action="/search" method="POST" class="d-flex flex-wrap justify-content-center gap-3 p-4 rounded-4 shadow-lg bg-light">
            @csrf
            @method('POST')
            <input type="text" name="query" class="form-control form-control-md w-50 border-0 shadow-sm rounded-3" placeholder="Pesquisar eventos..." value="{{ request()->query('query') }}">
            <select name="location" class="form-select form-select-md w-25 border-0 shadow-sm rounded-3">
                <option value="">Selecione a Localização</option>
                @foreach ($events as $value)
                    <option value="{{ $value->location }}" {{ request()->query('location') == $value->location ? 'selected' : '' }}>{{ $value->location }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary btn-md w-20 rounded-3 shadow-sm">Buscar</button>
        </form>
    </div>
    
    
</div>

<main>
    @include('home.categories')
</main>

<div class="container-fluid py-4">

    <div class="container d-flex flex-wrap justify-content-center gap-4">
        @foreach ($events as $value)
            @include('components.event-card', ['event' => $value])
        @endforeach
    </div>

    <div class="text-center my-4">
        <a href="/search/event-type/all" class="btn btn-outline-dark">Ver Mais</a>
    </div>
</div>

<div class="container-fluid">
    <div class="row justify-content-center align-items-start">
        <div class="col-md-2 col-2 mb-4">
            @include('components.carrosel')
        </div>
        @if(count($events_online) > 0)
        <div class="col-md-6 col-12 bg-light p-4 rounded shadow-lg">
            <div class="d-flex  gap-3">
                @foreach ($events_online as $value)
                    @include('components.event-card', ['event' => $value])
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>




<!-- Newsletter Section -->
<div class="container-fluid bg-dark text-white py-5">
    <div class="container text-center">
        <h2 class="fw-bold mb-3">Inscreva-se na Nossa Newsletter</h2>
        <p class="lead mb-4">Fique por dentro dos próximos eventos e ofertas exclusivas!</p>
        <form action="/subscribe" method="POST" class="d-flex flex-wrap justify-content-center gap-3">
            @csrf
            <input type="email" name="email" class="form-control form-control-lg w-50" placeholder="Digite seu e-mail" required>
            <button type="submit" class="btn btn-warning btn-lg">Inscrever-se</button>
        </form>
    </div>
</div>

<!-- Advertise Section -->
<div class="container-fluid bg-light py-5">
    <div class="container text-center">
        <h2 class="fw-bold mb-3">Anuncie Conosco</h2>
        <p class="lead mb-4">Quer divulgar seu evento para milhares de pessoas? Entre em contato conosco!</p>
        <a href="/advertise" class="btn btn-dark btn-lg text-warning fw-bold">
            Saiba Mais <i class="fas fa-bullhorn"></i>
        </a>
    </div>
</div>
@endsection
