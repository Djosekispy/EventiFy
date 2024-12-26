@extends('includes.body')
@section('title', 'Eventos a participar')
@section('content')

<div class="max-w-7xl mx-auto px-4 mt-8">
    <!-- Título -->
    <h1 class="text-2xl font-bold font-serif text-gray-900 mb-6" style="font-weight: bold;">Eventos a participar</h1>
  </div>
  
  <!-- Eventos Populares -->
  <div class="flex justify-center items-center px-4 py-6 bg-white flex-wrap">
    <!-- Card -->
    @for($a = 0 ; $a<6 ; $a++)
    <div style="margin: 1.2rem 2rem;" class="flex flex-col items-center">
      <!-- Imagem com rótulos -->
      <div class="relative rounded-md overflow-hidden" style="width: 20rem; height: 12rem ;">
        <span style="position: absolute; top: 2px; right: 2px; background-color: rgb(98, 86, 86);" class="bg-black text-white text-xs font-semibold px-2 py-1 rounded-full p-2">★</span>
        <img src="{{asset('storage/party.jpg')}}" alt="Evento" class="w-full h-full object-cover">
        <span style="position: absolute; bottom: 2px; left: 2px; background-color: #FFE047;" class="text-black text-xs font-semibold px-2 py-1 rounded">Rótulo</span>
      </div>
  
      <!-- Informações do Evento -->
      <div class="flex flex-row items-start mt-4 gap-4">
        <!-- Data -->
        <div class="text-center bg-gray-100 text-gray-900 font-bold py-2 px-3 rounded-md shadow">
          <div class="text-xl">Nov</div>
          <div class="text-lg">22</div>
        </div>
        <!-- Detalhes -->
        <div class="flex flex-col">
          <!-- Título -->
          <span style="font-size: 16px;"  class="text-lg font-bold leading-tight text-gray-800">
            Título de duas linhas no máximo
          </span>
          <!-- Tipo -->
          <span style="font-size: 14px;" class="text-sm text-gray-600">Tipo</span>
          <!-- Horários -->
          <span style="font-size: 14px;" class="text-sm text-gray-600">Hora início - Hora fim</span>
          <!-- Vagas e Interessados -->
          <div class="flex gap-4">
            <span style="font-size: 14px;" class="text-sm text-gray-600">Vagas</span>
            <span style="font-size: 14px;" class="text-sm text-gray-600"> ★ Interessados</span>
          </div>
        </div>
      </div>
    </div>
@endfor      
  </div>

@endsection