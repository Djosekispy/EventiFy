@extends('includes.body')
@section('title', 'Meus Eventos')
@section('content')

<div class="max-w-7xl mx-auto px-4 mt-8">
    <!-- Título -->
    <h1 class="text-2xl font-bold font-serif text-gray-900 mb-6" style="font-weight: bold;">Meus Eventos</h1>
  </div>
  @if(session()->has('success'))
    <div class="alert alert-success bg-green-500 text-white py-2 px-4 rounded">
      {{ session('success') }}
    </div>
  @endif
  <!-- Eventos Populares -->
  <div class="flex justify-center items-center px-4 py-6 bg-white flex-wrap">
    <!-- Card -->
    @foreach ($events as $index => $value )
    <div style="margin: 1.2rem 2rem;" class="flex flex-col items-center">
      <!-- Imagem com rótulos -->
      <div class="relative rounded-md overflow-hidden" style="width: 20rem; height: 12rem ;">
        <span style="position: absolute; top: 2px; right: 2px; background-color: rgb(98, 86, 86);" class="bg-black text-white text-xs font-semibold px-2 py-1 rounded-full p-2">★</span>
        <img src="{{url('storage/'.$value->banner_image)}}" alt="Evento" class="w-full h-full object-cover">
        <span style="position: absolute; bottom: 2px; left: 2px; background-color: #FFE047;" class="text-black text-xs font-semibold px-2 py-1 rounded">{{$value->status}}</span>
      </div>

      <!-- Informações do Evento -->
      <div class="flex flex-row items-start mt-4 gap-4">
        <!-- Data -->
        <div class="text-center bg-gray-100 text-gray-900 font-bold py-2 px-3 rounded-md shadow">
          <div class="text-xl">{{ \Carbon\Carbon::parse($value->realized_at)->format('M') }}</div>
          <div class="text-lg">{{ \Carbon\Carbon::parse($value->realized_at)->format('d') }}</div>
        </div>
        <!-- Detalhes -->
        <div class="flex flex-col">
          <!-- Título -->
          <a href="/deteils/{{$value->id}}">
          <span style="font-size: 16px;"  class="text-lg font-bold leading-tight text-gray-800">
           {{$value->title}}
          </span>
          </a>
          <!-- Tipo -->
          <span style="font-size: 14px;" class="text-sm text-gray-600">{{$value->event_type}}</span>
          <!-- Horários -->
          <span style="font-size: 14px;" class="text-sm text-gray-600">{{$value->start_at}} - {{$value->end_at}}</span>
          <!-- Vagas e Interessados -->
          <div class="flex gap-4">
            <span style="font-size: 14px;" class="text-sm text-gray-600">Vagas {{$value->vacancies}}</span>
            <span style="font-size: 14px;" class="text-sm text-gray-600"> ★ {{$value->total_participants}} Interessados</span>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <div class="max-w-7xl mx-auto px-4 mt-8">
    <!-- Título -->
    <h1 class="text-2xl font-bold font-serif text-gray-900 mb-6" style="font-weight: bold;">Histórico de Participação</h1>
  </div>
  <!-- Eventos Populares -->
  <div class="flex justify-center items-center px-4 py-6 bg-white flex-wrap">
    <!-- Card -->
    @foreach ($participantingEvent as $index => $value )
    <div style="margin: 1.2rem 2rem;" class="flex flex-col items-center">
      <!-- Imagem com rótulos -->
      <div class="relative rounded-md overflow-hidden" style="width: 20rem; height: 12rem ;">
        <span style="position: absolute; top: 2px; right: 2px; background-color: rgb(98, 86, 86);" class="bg-black text-white text-xs font-semibold px-2 py-1 rounded-full p-2">★</span>
        <img src="{{url('storage/'.$value->banner_image)}}" alt="Evento" class="w-full h-full object-cover">
        <span style="position: absolute; bottom: 2px; left: 2px; background-color: #FFE047;" class="text-black text-xs font-semibold px-2 py-1 rounded">{{$value->status}}</span>
      </div>

      <!-- Informações do Evento -->
      <div class="flex flex-row items-start mt-4 gap-4">
        <!-- Data -->
        <div class="text-center bg-gray-100 text-gray-900 font-bold py-2 px-3 rounded-md shadow">
          <div class="text-xl">{{ \Carbon\Carbon::parse($value->realized_at)->format('M') }}</div>
          <div class="text-lg">{{ \Carbon\Carbon::parse($value->realized_at)->format('d') }}</div>
        </div>
        <!-- Detalhes -->
        <div class="flex flex-col">
          <!-- Título -->
          <a href="/deteils/{{$value->id}}">
          <span style="font-size: 16px;"  class="text-lg font-bold leading-tight text-gray-800">
           {{$value->title}}
          </span>
          </a>
          <!-- Tipo -->
          <span style="font-size: 14px;" class="text-sm text-gray-600">{{$value->event_type}}</span>
          <!-- Horários -->
          <span style="font-size: 14px;" class="text-sm text-gray-600">{{$value->start_at}} - {{$value->end_at}}</span>
          <!-- Vagas e Interessados -->
          <div class="flex gap-4">
            <span style="font-size: 14px;" class="text-sm text-gray-600">Vagas {{$value->vacancies}}</span>
            <span style="font-size: 14px;" class="text-sm text-gray-600"> ★ {{$value->total_participants}} Interessados</span>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
@endsection
