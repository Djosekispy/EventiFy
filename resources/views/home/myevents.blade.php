@extends('includes.body')
@section('title', 'Meus Eventos')
@section('content')

<div class="max-w-7xl mx-auto px-4 mt-8 text-center">
    <h1 class="text-4xl font-extrabold font-serif text-gray-900 mb-2">Meus Eventos</h1>
    <p class="text-lg text-gray-600 italic">Acompanhe e gerencie os eventos que você criou</p>
</div>

@if(session()->has('success'))
    <div class="alert alert-success bg-green-500 text-white py-2 px-4 rounded shadow-md mb-4 text-center">
        {{ session('success') }}
    </div>
@endif

@if(count($events) > 0)
    <div class="container d-flex flex-wrap justify-content-center gap-4 mt-6" id="event-list">
        @foreach ($events as $value)
            @include('components.event-card', ['event' => $value])
           
        @endforeach
    </div>
@else
    <div class="text-center text-gray-500 mt-8">
        <h3 class="text-2xl font-semibold">Nenhum evento criado ainda</h3>
        <p class="text-gray-400">Crie seu primeiro evento agora mesmo e comece a compartilhar!</p>
        <a href="/event/form" class="btn btn-primary mt-3">Criar Evento</a>
    </div>
@endif

@if(count($participantingEvent) > 0)
    <div class="max-w-7xl mx-auto px-4 mt-12 text-center">
        <h1 class="text-4xl font-extrabold font-serif text-gray-900 mb-2">Histórico de Participação</h1>
        <p class="text-lg text-gray-600 italic">Reviva os eventos dos quais você participou</p>
    </div>
    <div class="container d-flex flex-wrap justify-content-center gap-4 mt-6" id="event-list">
        @foreach ($participantingEvent as $value)
            @include('components.event-card', ['event' => $value])
        @endforeach
    </div>
@else
    <div class="text-center text-gray-500 mt-8">
        <h3 class="text-2xl font-semibold">Você ainda não participou de nenhum evento</h3>
        <p class="text-gray-400">Explore eventos disponíveis e participe!</p>
        <a href="/" class="btn btn-outline-primary mt-3">Explorar Eventos</a>
    </div>
@endif

@endsection
