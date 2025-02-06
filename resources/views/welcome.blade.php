@extends('includes.body')

@section('title', 'Página Inicial')

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

/* Estilo para o select de localização */
.form-select {
  width: 25%; /* Define a largura do select */
  padding: 0.5rem; /* Espaçamento interno */
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
    <div style="padding-top: 8rem; margin-bottom: 2rem; padding-left: 16%"  class="flex flex-col justify-start text-justify items-start">
        <span class="text-white font-bold font-serif" style="font-weight: bold; font-size: 2rem;">
            Não Fique de fora!
        </span>
        <span class="text-white font-bold font-serif" style="font-weight: bold; font-size: 2rem;">
            Explore os <span style="color: #FFE047;"> eventos vibrantes </span> que estão acontecendo
        </span>
    </div>
        <form action="/search" class="mt-8 flex justify-center items-center" style="width: 70%; margin: 2px auto;" method="GET">

            <input type="text" name="query" class="form-input block w-48 mt-1 p-2 border border-gray-300 rounded-md" placeholder="Pesquisar...">

            <!-- Select para filtro de localização -->
            <select name="location" class="form-select mt-1 p-2 border border-gray-300 rounded-md">
                <option value="">Selecione a Localização</option>
                @foreach ($events as $index => $value )
                <option value="{{$value->location}}">{{$value->location}}</option>
                @endforeach
            </select>
        <button type="submit" style="margin-left: 12px ;" class="mt-1 p-2 border border-gray-300 rounded-md bg-blue-500 text-white">
            Buscar
        </button>
        </form>
</div>
<main>
        @include('home.categories')
    </main>
    <div class="max-w-7xl mx-auto pt-4  px-4">
      <!-- Título -->
      <h1 class="text-2xl font-bold font-serif text-gray-900 mb-6" style="font-weight: bold;">Todos os Eventos</h1>

    </div>

    <!-- Eventos Populares -->
    <div class="flex justify-center items-center px-4  bg-white flex-wrap">
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
            <a>
            <!-- Tipo -->
            <span style="font-size: 14px;" class="text-sm text-gray-600">{{$value->event_type}}</span>
            <!-- Horários -->
            <span style="font-size: 14px;" class="text-sm text-gray-600">{{$value->start_at}} - {{$value->end_at}}</span>
            <!-- Vagas e Interessados -->
            <div class="flex gap-4">
              <span style="font-size: 14px;" class="text-sm text-gray-600">{{$value->vacancies}} Vagas</span>
              <span style="font-size: 14px;" class="text-sm text-gray-600"> ★ {{$value->total_participants}} Interessados</span>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    <div style="width: 100%; display: flex; justify-content: center;" class="items-center">
        <button style="border-width: 2px; border-color: #2B293D; border-radius: 10px; width: 200px" class="p-2">
            <a href="/search/event-type/{{'all'}}">Ver Mais</a>
        </button>
    </div>



      <!-- Eventos Online -->
@if(count($events_online) > 0)
    <div class="max-w-7xl mx-auto px-4 mt-8">
      <!-- Título -->
      <h1 class="text-2xl font-bold font-serif text-gray-900 mb-6" style="font-weight: bold;">Descubra os melhores eventos online</h1>
    </div>

    <!-- Eventos Populares -->
    <div class="flex justify-center items-center px-4 py-6 bg-white flex-wrap">
      <!-- Card -->
      @foreach ($events_online as $index => $value )
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
              <span style="font-size: 14px;" class="text-sm text-gray-600">{{$value->vacancies}} Vagas </span>
              <span style="font-size: 14px;" class="text-sm text-gray-600"> ★ {{$value->total_participants}} Interessados</span>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    <div style="width: 100%; display: flex; justify-content: center;" class="items-center">
        <button style="border-width: 2px; border-color: #2B293D; border-radius: 10px; width: 200px" class="p-2">
            <a href="/search/event-type/{{'online'}}">Ver Mais</a>
        </button>

    </div>

    @endif

    <div style="display: flex; justify-content: center; margin: 12px; padding:12px; background-color: #C4C4C4; margin: 4rem 1.3rem;" class="items-center my-6 rounded-md">
  <div  style="border-radius: 10px; " class="flex flex-col justify-center items-center px-12 py-4">
    <div class=" p-6 mb-6">
      <h1 class="text-2xl font-bold mb-2" style="font-weight: bold; margin-bottom: 8px;">Eventos especiais para você!</h1>
      <h6>Obtenha sugestões de eventos interessantes! Não deixe seu evento favorito desaparecer</h6>
    </div>
    <div style="width: 100%; display: flex; justify-content: center;" class="items-center">
      <a href="/#" style="background-color: #2B293D; border-radius: 10px; width: 200px; color: #FFE047; font-size: 18px; font-weight: bold; display: flex; justify-content: center; align-items: center; gap: 8px;" class="p-2">
        Iniciar
        <i class="fas fa-arrow-right"></i>
      </a>
    </div>

  </div>
 </div>


      <!-- Eventos ao redor do mundo -->

      <div class="max-w-7xl mx-auto px-4 mt-8">
        <!-- Título -->
        <h1 class="text-2xl font-bold font-serif text-gray-900 mb-6" style="font-weight: bold;">Eventos Presenciais</h1>
      </div>

      <div class="flex justify-center items-center px-4 py-6 bg-white flex-wrap">
        <!-- Card -->
        @foreach ($events_presencial as $index => $value )
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
                <span style="font-size: 14px;" class="text-sm text-gray-600">{{$value->vacancies}} Vagas </span>
                <span style="font-size: 14px;" class="text-sm text-gray-600"> ★ {{$value->total_participants}} Interessados</span>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      <div style="width: 100%; display: flex; justify-content: center;" class="items-center">
        <button style="border-width: 2px; border-color: #2B293D; border-radius: 10px; width: 200px" class="p-2">
            <a href="/search/event-type/{{'presencial'}}">Ver Mais</a>
        </button>
    </div>




      <div style="display: flex; justify-content: center; margin: 12px; padding:12px; background-color: #C4C4C4; margin: 4rem 0px;" class="items-center my-6">
        <div  style="border-radius: 10px; " class="flex flex-row justify-center items-center px-12 py-4">
          <div class=" p-6 mb-6">
            <h1 class="text-2xl font-bold mb-2" style="font-weight: bold; margin-bottom: 8px;">Crie seu Evento Agora</h1>
            <h6>Tem um show, evento, atividade ou uma ótima experiência? junte-se a nós e seja listado no Eventify</h6>
          </div>
          <div style="display: flex; justify-content: center;" class="items-center">
            <button style="background-color:#FFE047; border-radius: 10px; width: 200px; color :  #2B293D; font-size: 18px; font-weight: bold;" class="p-2 flex items-center justify-center">
             <svg style="margin-right: 6px;" fill="#000000" height="30px" width="30px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 500 500" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <g> <path d="M128.956,156.136H70.384c-2.212,0-4,1.792-4,4s1.788,4,4,4h58.568c2.212,0,4.004-1.792,4.004-4 S131.168,156.136,128.956,156.136z"></path> </g> </g> <g> <g> <path d="M128.956,218.612H70.384c-2.212,0-4,1.792-4,4s1.788,4,4,4h58.568c2.212,0,4.004-1.792,4.004-4 S131.168,218.612,128.956,218.612z"></path> </g> </g> <g> <g> <path d="M128.956,281.088H70.384c-2.212,0-4,1.792-4,4s1.788,4,4,4h58.568c2.212,0,4.004-1.792,4.004-4 S131.168,281.088,128.956,281.088z"></path> </g> </g> <g> <g> <path d="M128.956,343.568H70.384c-2.212,0-4,1.792-4,4s1.788,4,4,4h58.568c2.212,0,4.004-1.792,4.004-4 S131.168,343.568,128.956,343.568z"></path> </g> </g> <g> <g> <path d="M455.46,42.9H48.28C22.564,42.9,0,64.868,0,89.912v278.076c0,24.968,22.108,46.056,48.28,46.056h80.672 c2.212,0,4-1.792,4-4s-1.788-4-4-4H48.28C26.444,406.044,8,388.616,8,367.988V89.912C8,69.132,26.824,50.9,48.28,50.9h407.18 c20.488,0,36.54,17.136,36.54,39.012v278.072c0,21.696-15.708,38.056-36.54,38.056h-80.508c-2.212,0-4,1.792-4,4s1.788,4,4,4 h80.508c24.976,0,44.54-20.228,44.54-46.052V89.912C500,63.552,480.436,42.9,455.46,42.9z"></path> </g> </g> <g> <g> <path d="M382.76,89.756H11.808c-2.212,0-4,1.792-4,4s1.788,4,4,4H382.76c2.212,0,4-1.792,4-4S384.972,89.756,382.76,89.756z"></path> </g> </g> <g> <g> <path d="M492.092,89.756H433.52c-2.212,0-4,1.792-4,4s1.788,4,4,4h58.572c2.212,0,4-1.792,4-4S494.304,89.756,492.092,89.756z"></path> </g> </g> <g> <g> <path d="M74.284,23.376c-2.212,0-4,1.792-4,4V66.42c0,2.208,1.788,4,4,4s4-1.788,4-3.996V27.376 C78.284,25.168,76.496,23.376,74.284,23.376z"></path> </g> </g> <g> <g> <path d="M132.86,23.376c-2.212,0-4,1.792-4,4V66.42c0,2.208,1.788,4,4,4c2.212,0,4-1.788,4-3.996V27.376 C136.86,25.168,135.072,23.376,132.86,23.376z"></path> </g> </g> <g> <g> <path d="M191.428,23.376c-2.212,0-4,1.792-4,4V66.42c0,2.208,1.788,4,4,4c2.212,0,4-1.788,4-3.996V27.376 C195.428,25.168,193.64,23.376,191.428,23.376z"></path> </g> </g> <g> <g> <path d="M250,23.376c-2.212,0-4,1.792-4,4V66.42c0,2.208,1.788,4,4,4c2.212,0,4-1.788,4-3.996V27.376 C254,25.168,252.212,23.376,250,23.376z"></path> </g> </g> <g> <g> <path d="M308.572,23.376c-2.212,0-4,1.792-4,4V66.42c0,2.208,1.788,4,4,4c2.208,0,4-1.788,4-3.996V27.376 C312.572,25.168,310.784,23.376,308.572,23.376z"></path> </g> </g> <g> <g> <path d="M367.144,23.376c-2.212,0-4,1.792-4,4V66.42c0,2.208,1.788,4,4,4c2.212,0,4-1.788,4-3.996V27.376 C371.144,25.168,369.356,23.376,367.144,23.376z"></path> </g> </g> <g> <g> <path d="M425.716,23.376c-2.212,0-4,1.792-4,4V66.42c0,2.208,1.788,4,4,4c2.208,0,4-1.788,4-3.996V27.376 C429.716,25.168,427.928,23.376,425.716,23.376z"></path> </g> </g> <g> <g> <path d="M226.572,156.136h-54.664c-2.212,0-4,1.792-4,4s1.788,4,4,4h54.664c2.208,0,4-1.792,4-4S228.784,156.136,226.572,156.136z "></path> </g> </g> <g> <g> <path d="M226.572,218.612h-54.664c-2.212,0-4,1.792-4,4s1.788,4,4,4h54.664c2.208,0,4-1.792,4-4S228.784,218.612,226.572,218.612z "></path> </g> </g> <g id="SVGCleanerId_0"> <g> <path d="M328.092,156.136h-54.664c-2.212,0-4,1.792-4,4s1.788,4,4,4h54.664c2.212,0,4-1.792,4-4S330.304,156.136,328.092,156.136z "></path> </g> </g> <g> <g> <path d="M328.092,218.612h-54.664c-2.212,0-4,1.792-4,4s1.788,4,4,4h54.664c2.212,0,4-1.792,4-4S330.304,218.612,328.092,218.612z "></path> </g> </g> <g> <g> <path d="M328.092,156.136h-54.664c-2.212,0-4,1.792-4,4s1.788,4,4,4h54.664c2.212,0,4-1.792,4-4S330.304,156.136,328.092,156.136z "></path> </g> </g> <g> <g> <path d="M429.616,156.136h-54.664c-2.212,0-4,1.792-4,4s1.788,4,4,4h54.664c2.212,0,4-1.792,4-4S431.828,156.136,429.616,156.136z "></path> </g> </g> <g> <g> <path d="M429.616,218.612h-54.664c-2.212,0-4,1.792-4,4s1.788,4,4,4h54.664c2.212,0,4-1.792,4-4S431.828,218.612,429.616,218.612z "></path> </g> </g> <g> <g> <path d="M429.616,281.088h-54.664c-2.212,0-4,1.792-4,4s1.788,4,4,4h54.664c2.212,0,4-1.792,4-4S431.828,281.088,429.616,281.088z "></path> </g> </g> <g> <g> <path d="M429.616,343.568h-54.664c-2.212,0-4,1.792-4,4s1.788,4,4,4h54.664c2.212,0,4-1.792,4-4S431.828,343.568,429.616,343.568z "></path> </g> </g> <g> <g> <path d="M251.984,250.256c-62.408,0-113.18,50.776-113.18,113.184s50.772,113.184,113.18,113.184 c62.412,0,113.184-50.772,113.184-113.184S314.396,250.256,251.984,250.256z M251.984,468.624 c-57.996,0-105.18-47.184-105.18-105.184s47.184-105.184,105.18-105.184c58,0,105.184,47.184,105.184,105.184 S309.984,468.624,251.984,468.624z"></path> </g> </g> <g> <g> <path d="M251.984,265.78c-53.848,0-97.656,43.808-97.656,97.656c0,53.852,43.808,97.66,97.656,97.66 c53.852,0,97.664-43.808,97.664-97.66C349.648,309.588,305.836,265.78,251.984,265.78z M251.984,453.1 c-49.436,0-89.656-40.22-89.656-89.66s40.22-89.656,89.656-89.656c49.44,0,89.664,40.216,89.664,89.656 S301.424,453.1,251.984,453.1z"></path> </g> </g> <g> <g> <path d="M302.548,351.376h-40.74v-38.58c0-8.66-5.088-11.744-9.856-11.744s-9.86,3.084-9.86,11.744v38.58h-40.828 c-6.484,0-11.752,5.3-11.752,11.812s5.272,11.808,11.752,11.808h40.828v39.088c0,8.656,5.096,11.74,9.86,11.74 c4.768,0,9.856-3.084,9.856-11.74v-39.088h40.74c6.48,0,11.748-5.296,11.748-11.808S309.024,351.376,302.548,351.376z M302.548,366.996h-44.74c-2.212,0-4,1.792-4,4v43.088c0,3.74-1.252,3.74-1.856,3.74s-1.86,0-1.86-3.74v-43.088 c0-2.208-1.788-4-4-4h-44.828c-2.032,0-3.752-1.744-3.752-3.808c0-2.104,1.684-3.812,3.752-3.812h44.828c2.212,0,4-1.792,4-4 v-42.58c0-3.744,1.256-3.744,1.86-3.744s1.856,0,1.856,3.744v42.58c0,2.208,1.788,4,4,4h44.74c2.032,0,3.748,1.744,3.748,3.812 C306.296,365.252,304.58,366.996,302.548,366.996z"></path> </g> </g> </g></svg>

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4l-4-4m5 5l-4 4M5 3a2 2 0 100 4h14l-5 5v-5zm-3 4a3 3 0 100-6 3 3 0 000 6zm-4 4a2 2 0 110-4h14a2 2 0 110 4M5 20a2 2 0 100-4h14a2 2 0 100 4m-4-4a2 2 0 110-4h14a2 2 0 110 4" />
              </svg>
              <a href="/event/form">
              <span>Criar Evento</span>
            </a>
            </button></div>
        </div>
       </div>

         <!-- Newslatter -->
       <div style="display: flex; justify-content: center; align-items: center; background-color: #FFE047; padding: 2rem;" class="newsletter-section">
        <div style="max-width: 500px; margin-right: 2rem;" class="text-section">
          <h1 class="text-2xl font-bold mb-2" style="font-weight: bold;">Inscreva-se em nossa Newsletter</h1>
          <p style="line-height: 1.5;">
            Receba nossa newsletter semanal e atualizações com novos eventos de seus organizadores e locais favoritos.
          </p>
        </div>
        <div style="display: flex; align-items: center;" class="form-section">
          <form action="/subscribe" method="post" style="display: flex; flex-direction: row; align-items: flex-start;">
            @csrf
            <input
              type="email"
              name="email"
              placeholder="Insira seu email"
              required
              style="padding: 0.5rem; border-bottom-left-radius: 10px; border-top-left-radius: 10px; border: 1px solid #ddd; margin-bottom: 1rem; width: 100%; max-width: 300px;">
              <button style="background-color:#2D2C3C; border-bottom-right-radius: 10px; border-top-right-radius: 10px; width: 200px; color : #FFE047; font-size: 18px; font-weight: bold;"
              class="p-2 flex items-center justify-center">
                Inscrever-se
            </button>
          </form>
        </div>
      </div>


 @endsection
