@extends('includes.body')

@section('title', 'Detalhes de Evento')
<style>
    .event-container {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        padding: 20px;
        align-items: flex-start;
        font-family: Arial, sans-serif;
    }

    .event-details {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .event-title {
        font-weight: bold;
        font-size: 2rem;
        margin: 0;
    }

    .section-title {
        font-weight: bold;
        font-size: 1.5rem;
        margin-top: 20px;
    }

    .sessions-container {
        display: flex;
        flex-direction: row;
        gap: 20px;
        flex-wrap: wrap;
    }

    .session-item {
        border: 1px solid #ddd;
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .session-item p {
        margin: 4px 0;
    }

    .info-text {
        font-size: 1rem;
        margin: 0;
    }

    .ticket-list {
        list-style: none;
        padding: 0;
    }

    .ticket-item {
        margin-bottom: 8px;
    }

    .highlight {
        font-weight: bold;
    }

    .cta-button {
        background-color: #FFE047;
        border-radius: 10px;
        width: 200px;
        color: #2B293D;
        font-size: 18px;
        font-weight: bold;
        padding: 10px;
        cursor: pointer;
        border: none;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        transition: background-color 0.3s ease;
    }

    .cta-button:hover {
        background-color: #FFC720;
    }
</style>
@section('content')

<div style="width: 100%; height: 500px; padding: 20px; overflow: hidden; position: relative;">
    <img 
        id="event-image" 
        src="{{ url('storage/'.$event['event'][0]->banner_image) }}" 
        alt="Banner do Evento" 
        style="width: 100%; height: 100%; object-fit: cover; cursor: pointer;"
    >
</div>

<div 
    id="image-modal" 
    style="
        display: none; 
        position: fixed; 
        top: 0; 
        left: 0; 
        width: 100%; 
        height: 100%; 
        background: rgba(0, 0, 0, 0.8); 
        justify-content: center; 
        align-items: center; 
        z-index: 1000;
    "
>
    <img 
        id="modal-image" 
        src="{{ url('storage/'.$event['event'][0]->banner_image) }}" 
        alt="Imagem Ampliada" 
        style="
            max-width: 90%; 
            max-height: 90%; 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        "
    >
    <button 
        id="close-modal" 
        style="
            position: absolute; 
            top: 20px; 
            right: 20px; 
            background: #fff; 
            border: none; 
            padding: 10px 20px; 
            font-size: 1rem; 
            cursor: pointer; 
            border-radius: 5px;
        "
    >
        Fechar
    </button>
</div>


<div class="event-container">
    <div class="event-details">
        <h1 class="event-title">{{$event['event'][0]->title}}</h1>
         @if (session('status'))
        <div style="color: green; text-align: center; margin-bottom: 10px;">
            {{ session('status') }}
        </div>
@endif
         @if (session('error'))
        <div style="color: red; text-align: center; margin-bottom: 10px;">
            {{ session('status') }}
        </div>
    @endif
        <p class="info-text"><i>Sessões</i></p>
        <div class="sessions-container">
            @foreach ($event['sessions'] as $index => $e)
                <div class="session-item">
                    <p class="info-text"><span class="highlight">{{$index + 1}}ª</span></p>
                    <p class="info-text"><b>Dia:</b> <i>{{$e->realized_at}}</i></p>
                    <p class="info-text"><b>Início:</b> <i>{{$e->start_at}}</i></p>
                    <p class="info-text"><b>Fim:</b> <i>{{$e->end_at}}</i></p>
                </div>
            @endforeach
        </div>
        <p class="info-text"><b>Localização:</b> <i>{{$event['event'][0]->location}}</i></p>
        <p class="info-text"><b>Vagas Disponíveis:</b> <i>{{$event['event'][0]->vacancies}}</i></p>
        <p class="info-text"><b>Interessados:</b> <i>{{ $participante->count() }}</i></p>


        <h2 class="section-title">Informações de Pagamento</h2>
        <p class="info-text"><i>{{$event['event'][0]->payment_info}}</i></p>

        <h2 class="section-title">Ingressos</h2>
        @if (isset($event['tickets']))
            <ul class="ticket-list">
                @foreach ($event['tickets'] as $index => $ticket)
                    <li class="ticket-item">
                        <p class="info-text"><b>{{$ticket->ticket_title}} -</b> <i>{{$ticket->price}} kz</i></p>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
    <div style="text-align: center;">
        @if($event['event'][0]->deleted_at === NULL)
       @if(!$isParticipant && $event['event'][0]->user_id !== auth()->id())
    <a class="cta-button" href="{{ route('participate', ['id' => $event['event'][0]->id]) }}">
        <span>Participar</span>
    </a>
       @endif
       @if($event['event'][0]->user_id == auth()->id())
       <a class="cta-button" href="javascript:void(0)" onclick="toggleMenu()"
       style="padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; cursor: pointer;">
       <span>{{$event['event'][0]->status}}</span>
   </a>

   <div id="floating-menu"
       style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 350px; padding: 20px; background-color: #f8f9fa; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3); border-radius: 10px; z-index: 1000; display: none; font-family: Arial, sans-serif;">
       <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
           <h3 style="margin: 0; font-size: 1.5rem; color: #343a40;">Atualizar estado do evento</h3>
           <button onclick="toggleMenu()"
               style="background: none; border: none; font-size: 1.2rem; color: #dc3545; cursor: pointer;">&times;</button>
       </div>
       <form action="{{ route('update.status', ['id' => $event['event'][0]->id]) }}" method="POST">
           @csrf
           <div style="margin-bottom: 15px;">
               <label for="status" style="display: block; font-size: 1rem; margin-bottom: 5px; color: #495057;">Estado:</label>
               <select name="status" id="status"
                   style="width: 100%; padding: 10px; border: 1px solid #ced4da; border-radius: 5px; font-size: 1rem; color: #495057;">
                   <option value="Publicado" {{$event['event'][0]->status == 'Publicado' ? 'selected' : ''}}>Publicado</option>
                   <option value="Pendente" {{$event['event'][0]->status == 'Pendente' ? 'selected' : ''}}>Pendente</option>
                   <option value="Cancelado" {{$event['event'][0]->status == 'Cancelado' ? 'selected' : ''}}>Cancelado</option>
                   <option value="Realizado" {{$event['event'][0]->status == 'Realizado' ? 'selected' : ''}}>Realizado</option>
               </select>
           </div>
           <button type="submit"
               style="width: 100%; padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; font-size: 1rem; font-weight: bold; cursor: pointer;">Submeter</button>
       </form>
   </div>


       <button
       href="javascript:void(0)" onclick="toggleMenuEdit()"
       style="color: #007bff;padding: 10px 20px; border: none; border-radius: 20px; cursor: pointer; transition: background-color 0.2s ease;" onclick="editarEvento()">
        <i class="fas fa-edit"></i>
    </button>
    <div id="floating-menuEdit"
    style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 350px; padding: 20px; background-color: #f8f9fa; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3); border-radius: 10px; z-index: 1000; display: none; font-family: Arial, sans-serif;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h3 style="margin: 0; font-size: 1.5rem; color: #343a40;">O que deseja alterar?</h3>
        <button onclick="toggleMenuEdit()"
            style="background: none; border: none; font-size: 1.2rem; color: #dc3545; cursor: pointer;">&times;</button>
    </div>
    <ul style="list-style: none; padding: 0; margin: 0;">
        <li style="margin-bottom: 10px;">
            <a href="{{ route('edit.general', ['id' => $event['event'][0]->id]) }}"
                style="display: block; padding: 10px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; text-align: center; font-size: 1rem; font-weight: bold; cursor: pointer;">
                Informações gerais do evento
            </a>
        </li>
        <li style="margin-bottom: 10px;">
            <a href="{{ route('edit.cover', ['id' => $event['event'][0]->id]) }}"
                style="display: block; padding: 10px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px; text-align: center; font-size: 1rem; font-weight: bold; cursor: pointer;">
                Imagem de capa
            </a>
        </li>
        <li style="margin-bottom: 10px;">
            <a href="{{ route('edit.session', ['id' => $event['event'][0]->id]) }}"
                style="display: block; padding: 10px; background-color: #ffc107; color: white; text-decoration: none; border-radius: 5px; text-align: center; font-size: 1rem; font-weight: bold; cursor: pointer;">
                Sessão
            </a>
        </li>
        <li>
            <a href="{{ route('edit.ticket', ['id' => $event['event'][0]->id]) }}"
                style="display: block; padding: 10px; background-color: #dc3545; color: white; text-decoration: none; border-radius: 5px; text-align: center; font-size: 1rem; font-weight: bold; cursor: pointer;">
                Ingresso
            </a>
        </li>
    </ul>
</div>




    <button style="color: #dc3545; padding: 10px 20px; border: none; border-radius: 20px; cursor: pointer; transition: background-color 0.2s ease;" onclick="deletarEvento(event, '{{ route('delete', ['id' => $event['event'][0]->id]) }}')">
        <i class="fas fa-trash"></i>
    </button>

<div id="confirmDialog" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #fff; border-radius: 10px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); padding: 20px; z-index: 1000; text-align: center; width: 300px;">
    <p style="font-size: 16px; margin-bottom: 20px;">Tem certeza que deseja deletar?</p>
    <div style="display: flex; justify-content: space-around;">
        <button onclick="confirmDelete()" style="background-color: #dc3545; color: #fff; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Sim</button>
        <button onclick="cancelDelete()" style="background-color: #6c757d; color: #fff; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Não</button>
    </div>
</div>
<div id="overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 999;"></div>


       @endif
       <div style="display: flex; flex-direction: row; margin-top: 10px; gap: 10; justify-content: center,; justify-items: center;">
        <button style="color: #007bff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.2s ease;" onclick="abrirFormularioConvite()">
            <i class="fa-duotone fa-solid fa-envelope"></i>
        </button>
        <button style="color: #dc3545; padding: 10px 20px; border: none; border-radius: 20px; cursor: pointer; transition: background-color 0.2s ease;" onclick="copiarUrl()">
            <span><i class="fas fa-share-alt"></i></span>
        </button>
       </div>
       @endif
    </div>


</div>
<div id="popup" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);">
  Link copiado com sucesso!
</div>

<div id="invite-participants-form" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);">
  <button id="close-invite-form" style="position: absolute; top: 10px; right: 10px; color: #dc3545; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer;" onclick="fecharFormularioConvite()"><i class="fas fa-times"></i></button>
  <h2 style="font-weight: bold; font-size: 1.2rem;"><i class="fas fa-envelope"></i> Convidar Participantes</h2>
  <form action="/invite" method="POST" id="invite-participants" style="margin-top: 20px;">
    @csrf
    <div style="margin-bottom: 10px;">
      <label for="email" style="font-weight: bold;">E-mail:</label>
      <input type="email" id="email" name="email" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
    </div>
    <div style="margin-bottom: 10px;">
      <label for="message" style="font-weight: bold;">Mensagem:</label>
      <textarea id="message" name="message" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;"></textarea>
    </div>
    <input type="hidden" name='event_id' value="{{$event['event'][0]->id}}">
    <button type="submit" style="background-color: #007bff; color: #ffffff; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Enviar Convite</button>
  </form>
</div>

<div style="padding: 20px;">
    <h2 style="font-weight: bold; font-size: 1.5rem;">Descrição</h2>
    <p style="text-align: justify; padding: 8px 0; line-height: 1.6; color: #333;">
      {{$event['event'][0]->description}}
    </p>

    <div style="margin-top: 12px;">
        <i style="
            background-color: #F8F7FA;
            border-radius: 12px;
            padding: 6px 12px;
            display: inline-block;
            font-size: 0.9rem;
            color: #555;
        ">
            Categoria: {{$event['event'][0]->category_title}}
        </i>
    </div>
</div>
</div>
</div>



<div style="padding: 20px">
    <h1 class="text-xl font-bold font-serif text-gray-900 mb-6" style="font-weight: bold;">Também podes gostar</h1>
  </div>

  <div class="relative mx-auto mb-8 bg-white overflow-hidden" style="position: relative; margin-bottom: 20px;">

    <button id="prev"  style="z-index: 1; position: absolute; top: 50%; left:12px;" class="bg-gray-800 text-white px-3 py-2 rounded-full shadow hover:bg-gray-700">
      &larr;
    </button>
    <button id="next"  style=" z-index: 1; position: absolute; top: 50%; right:12px;" class="bg-gray-800 text-white px-3 py-2 rounded-full shadow hover:bg-gray-700">
      &rarr;
    </button>

    <div id="carousel" class="flex gap-6 transition-transform duration-500">
        @foreach ($more as $index => $value )
      <div class="flex-none w-80">
        <div class="flex flex-col items-center">
          <div class="relative rounded-md overflow-hidden" style="width: 20rem; height: 12rem;">
            <span style="position: absolute; top: 2px; right: 2px; background-color: rgb(98, 86, 86);" class="bg-black text-white text-xs font-semibold px-2 py-1 rounded-full p-2">★</span>
            <img src="{{url('storage/'.$value->banner_image)}}" alt="Evento" class="w-full h-full object-cover">
            <span style="position: absolute; bottom: 2px; left: 2px; background-color: #FFE047;" class="text-black text-xs font-semibold px-2 py-1 rounded">{{$value->status}}</span>
          </div>

          <div class="flex flex-row items-start mt-4 gap-4">
            <div class="text-center bg-gray-100 text-gray-900 font-bold py-2 px-3 rounded-md shadow">
                <div class="text-xl">{{ \Carbon\Carbon::parse($value->realized_at)->format('M') }}</div>
                <div class="text-lg">{{ \Carbon\Carbon::parse($value->realized_at)->format('d') }}</div>
            </div>

            <div class="flex flex-col">

              <a href="/deteils/{{$value->id}}">
              <span style="font-size: 16px;"  class="text-lg font-bold leading-tight text-gray-800">
                {{$value->title}}
               </span>
              </a>

              <span style="font-size: 14px;" class="text-sm text-gray-600">{{$value->event_type}}</span>

              <span style="font-size: 14px;" class="text-sm text-gray-600">{{$value->start_at}} - {{$value->end_at}}</span>

              <div class="flex gap-4">
                <span style="font-size: 14px;" class="text-sm text-gray-600">Vagas {{$value->vacancies}}</span>
                <span style="font-size: 14px;" class="text-sm text-gray-600"> ★ {{$value->total_participants}} Interessados</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>


  <script>
    const carousel = document.getElementById("carousel");
    const prev = document.getElementById("prev");
    const next = document.getElementById("next");

    let scrollAmount = 0;
    const scrollStep = 320;
    const maxScroll = carousel.scrollWidth - carousel.offsetWidth;

    next.addEventListener("click", () => {
      if (scrollAmount < maxScroll) {
        scrollAmount += scrollStep;
        carousel.style.transform = `translateX(-${scrollAmount}px)`;
      }
    });

    prev.addEventListener("click", () => {
      if (scrollAmount > 0) {
        scrollAmount -= scrollStep;
        carousel.style.transform = `translateX(-${scrollAmount}px)`;
      }
    });

    function copiarUrl() {
      const url = window.location.href;
      navigator.clipboard.writeText(url).then(() => {
        document.getElementById('popup').style.display = 'block';
        setTimeout(function(){ document.getElementById('popup').style.display = 'none'; }, 3000);
      }).catch((error) => {
        console.error('Erro ao copiar a URL: ', error);
      });
    }

  function abrirFormularioConvite() {
    document.getElementById('invite-participants-form').style.display = 'block';
  }

  function fecharFormularioConvite() {
    document.getElementById('invite-participants-form').style.display = 'none';
  }

  function enviarConvite() {
    const form = document.getElementById('invite-participants');
    form.submit();
  }

  let deleteUrl = '';

function deletarEvento(event, url) {
    event.preventDefault();
    deleteUrl = url;
    document.getElementById('confirmDialog').style.display = 'block';
    document.getElementById('overlay').style.display = 'block';
}

function confirmDelete() {
    window.location.href = deleteUrl;
}

function cancelDelete() {
    document.getElementById('confirmDialog').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
    deleteUrl = '';
}

function toggleMenu() {
    const menu = document.getElementById('floating-menu');
    menu.style.display = menu.style.display === 'none' || menu.style.display === '' ? 'block' : 'none';
}

function toggleMenuEdit() {
    const menu = document.getElementById('floating-menuEdit');
    menu.style.display = menu.style.display === 'none' || menu.style.display === '' ? 'block' : 'none';
}

const eventImage = document.getElementById('event-image');
    const imageModal = document.getElementById('image-modal');
    const closeModal = document.getElementById('close-modal');
    eventImage.addEventListener('click', () => {
        imageModal.style.display = 'flex';
    });
    closeModal.addEventListener('click', () => {
        imageModal.style.display = 'none';
    });
    imageModal.addEventListener('click', (e) => {
        if (e.target === imageModal) {
            imageModal.style.display = 'none';
        }
    });
  </script>



@endsection
