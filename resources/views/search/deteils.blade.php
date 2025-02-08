@extends('includes.body')

@section('title', 'Detalhes de Evento')
@section('og_title', $event['event'][0]->title)
@section('og_description', $event['event'][0]->description)
@section('og_image', url('storage/' . $event['event'][0]->banner_image))
@section('og_url', 'https://www.lipsum.com/')

@section('content')

<div class="container my-5" id="usecase">
    <div class="position-relative">
        <img src="{{ url('storage/'.$event['event'][0]->banner_image) }}" class="img-fluid rounded" alt="Banner do Evento">
        <div class="position-absolute top-50 end-0 translate-middle-y bg-white p-4 rounded shadow" style="width: 700px; margin-right: -20px;">
            @if (session('status'))
                <div class="alert alert-success text-center mb-3">
                    {{ session('status') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger text-center mb-3">
                    {{ session('error') }}
                </div>
            @endif
            <div class="d-flex align-items-center mb-3">
                <i class="fas fa-wrench fa-2x me-2 text-primary"></i>
                <span class="fw-bold fs-5 text-primary">{{$event['event'][0]->category_title}}</span>
            </div>
            <h3 class="fw-bold">{{$event['event'][0]->title}}</h3>
            <p class="text-muted">Cada componente é escolhido para otimizar a potência e a eficiência do seu veículo, garantindo que você aproveite ao máximo cada curva.</p>
            <p class="mb-1"><b>Localização:</b> <i>{{$event['event'][0]->location}}</i></p>
            <p class="mb-1"><b>Vagas Disponíveis:</b> <i>{{$event['event'][0]->vacancies}}</i></p>
            <p class="mb-3"><b>Interessados:</b> <i>{{ $participante->count() }}</i></p>

            <h4 class="fw-bold mt-4">Informações de Pagamento</h4>
            <p class="text-muted">{{$event['event'][0]->payment_info}}</p>

            <div class="text-center mt-4">
                @if($event['event'][0]->deleted_at === NULL)
                    @if(!$isParticipant && $event['event'][0]->user_id !== auth()->id())
                        <a class="btn btn-primary btn-lg" href="{{ route('participate', ['id' => $event['event'][0]->id]) }}">
                            Participar
                        </a>
                    @endif
                    @if ($isParticipant)
                    <form action="{{ route('participants.destroy', ['participant' => auth()->id()]) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-warning btn-lg">Cancelar participação</button>
                    </form>
                    @endif
                    @if($event['event'][0]->user_id == auth()->id())
                        <button class="btn btn-success btn-lg" onclick="toggleMenu()">
                            {{$event['event'][0]->status}}
                        </button>
                        <div id="floating-menu" class="position-fixed top-50 start-50 translate-middle bg-light p-4 rounded shadow" style="display: none; width: 350px;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h3 class="mb-0">Atualizar estado do evento</h3>
                                <button class="btn btn-close" onclick="toggleMenu()"></button>
                            </div>
                            <form action="{{ route('update.status', ['id' => $event['event'][0]->id]) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="status" class="form-label">Estado:</label>
                                    <select name="status" id="status" class="form-select">
                                        <option value="Publicado" {{$event['event'][0]->status == 'Publicado' ? 'selected' : ''}}>Publicado</option>
                                        <option value="Pendente" {{$event['event'][0]->status == 'Pendente' ? 'selected' : ''}}>Pendente</option>
                                        <option value="Cancelado" {{$event['event'][0]->status == 'Cancelado' ? 'selected' : ''}}>Cancelado</option>
                                        <option value="Realizado" {{$event['event'][0]->status == 'Realizado' ? 'selected' : ''}}>Realizado</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Submeter</button>
                            </form>
                        </div>
                        <button class="btn btn-primary btn-lg" onclick="toggleMenuEdit()">
                            <i class="fas fa-edit"></i>
                        </button>
                        <div id="floating-menuEdit" class="position-fixed top-50 start-50 translate-middle bg-light p-4 rounded shadow" style="display: none; width: 350px;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h3 class="mb-0">O que deseja alterar?</h3>
                                <button class="btn btn-close" onclick="toggleMenuEdit()"></button>
                            </div>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <a href="{{ route('edit.general', ['id' => $event['event'][0]->id]) }}" class="btn btn-primary w-100">
                                        Informações gerais do evento
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="{{ route('edit.cover', ['id' => $event['event'][0]->id]) }}" class="btn btn-success w-100">
                                        Imagem de capa
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a href="{{ route('edit.session', ['id' => $event['event'][0]->id]) }}" class="btn btn-warning w-100">
                                        Sessão
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('edit.ticket', ['id' => $event['event'][0]->id]) }}" class="btn btn-danger w-100">
                                        Ingresso
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <button class="btn btn-danger btn-lg" data-bs-toggle="modal" data-bs-target="#confirmDialog">
                            <i class="fas fa-trash"></i>
                        </button>

                       

                        <div id="overlay" class="position-fixed top-0 start-0 w-100 h-100 bg-dark opacity-50" style="display: none;"></div>
                    @endif
                    <div class="d-flex justify-content-center gap-2 mt-3">
                        <button class="btn btn-primary" onclick="abrirFormularioConvite()">
                            <i class="fas fa-envelope"></i>
                        </button>
                        <button class="btn btn-secondary" onclick="abrirMenuCompartilhamento()">
                            <i class="fas fa-share-alt"></i>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Menu de Compartilhamento -->
<div id="menu-compartilhamento" class="position-fixed top-50 start-50 translate-middle bg-white p-4 rounded shadow" style="display: none; width: 400px;">
    <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
        <h3 class="mb-0">{{$event['event'][0]->title}}</h3>
        <button class="btn btn-close" onclick="fecharMenuCompartilhamento()"></button>
    </div>
    
    <div class="opcoes-compartilhamento mb-2">
        <button class="btn btn-outline-primary btn-copiar-link" onclick="copiarLink()">
            <i class="fas fa-copy"></i> Copiar link
        </button>
        <button class="btn btn-outline-secondary" onclick="compartilharPorEmail()">
            <i class="fas fa-envelope"></i> Compartilhar por e-mail
        </button>
    </div>
    <div class="d-flex justify-content-around">
        <button class="btn btn-primary" onclick="compartilharFacebook()">
            <i class="fab fa-facebook"></i> Facebook
        </button>
        <button class="btn btn-info" onclick="compartilharTwitter()">
            <i class="fab fa-twitter"></i> Twitter
        </button>
        <button class="btn btn-secondary" onclick="compartilharLinkedIn()">
            <i class="fab fa-linkedin"></i> LinkedIn
        </button>
    </div>
</div>

<div class="container mt-5">
    <h4 class="fw-bold">Sessões</h4>
    <div class="row">
        @foreach ($event['sessions'] as $index => $e)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{$index + 1}}ª Sessão</h5>
                        <p class="card-text"><b>Dia:</b> {{$e->realized_at}}</p>
                        <p class="card-text"><b>Início:</b> {{$e->start_at}}</p>
                        <p class="card-text"><b>Fim:</b> {{$e->end_at}}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <h4 class="fw-bold mt-4">Ingressos</h4>
    @if (isset($event['tickets']))
        <ul class="list-group">
            @foreach ($event['tickets'] as $ticket)
                <li class="list-group-item">
                    <b>{{$ticket->ticket_title}}</b> - {{$ticket->price}} kz
                </li>
            @endforeach
        </ul>
    @endif
</div>

 <!-- Modal de Confirmação de Exclusão -->
 <div class="modal fade" id="confirmDialog" tabindex="-1" aria-labelledby="confirmDialogLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDialogLabel">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja deletar este evento?</p>
            </div>
            <div class="modal-footer">
                <form action="/delete/{{$event['event'][0]->id}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Sim</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
            </div>
        </div>
    </div>
</div>

<div class="container mt-5">
    <h4 class="fw-bold">Descrição</h4>
    <p class="text-muted">{{$event['event'][0]->description}}</p>
    <div class="mt-3">
        <span class="badge bg-secondary">{{$event['event'][0]->category_title}}</span>
    </div>
</div>

<div class="container mt-5">
    <h4 class="fw-bold">Também pode gostar</h4>
    <div class="position-relative">
        <button id="prev" class="position-absolute top-50 start-0 translate-middle-y btn btn-dark rounded-circle">
            &larr;
        </button>
        <button id="next" class="position-absolute top-50 end-0 translate-middle-y btn btn-dark rounded-circle">
            &rarr;
        </button>
        <div id="carousel" class="d-flex overflow-hidden gap-3">
            @foreach ($more as $value)
                <div class="card flex-shrink-0" style="width: 18rem; height: 18rem;">
                    <a href="/deteils/{{$value->id}}">
                    <img src="{{ url('storage/'.$value->banner_image) }}" class="card-img-top" alt="Evento">
                </a>
                    <div class="card-body">
                        <h5 class="card-title">{{ substr($value->title, 0, 25) }}...</h5>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div id="popup" class="position-fixed top-50 start-50 translate-middle bg-white p-3 rounded shadow" style="display: none;">
    Link copiado com sucesso!
</div>

<div id="invite-participants-form" class="position-fixed top-50 start-50 translate-middle bg-white p-4 rounded shadow" style="display: none; width: 400px;">
    <button class="position-absolute top-0 end-0 btn btn-close m-2" onclick="fecharFormularioConvite()"></button>
    <h4 class="fw-bold mb-3"><i class="fas fa-envelope"></i> Convidar Participantes</h4>
    <form action="/invite" method="POST">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Mensagem:</label>
            <textarea id="message" name="message" class="form-control" required></textarea>
        </div>
        <input type="hidden" name="event_id" value="{{$event['event'][0]->id}}">
        <button type="submit" class="btn btn-primary w-100">Enviar Convite</button>
    </form>
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

    function copiarLink() {
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            alert('Link copiado com sucesso!');
        }).catch((error) => {
            console.error('Erro ao copiar o link: ', error);
        });
    }

    function compartilharPorEmail() {
        const url = encodeURIComponent(window.location.href);
        const subject = encodeURIComponent("Confira este conteúdo!");
        const body = encodeURIComponent("Olá, achei este conteúdo interessante e quero compartilhar com você: " + window.location.href);
        window.location.href = `mailto:?subject=${subject}&body=${body}`;
    }
    function abrirMenuCompartilhamento() {
        document.getElementById('menu-compartilhamento').style.display = 'block';
    }

    function fecharMenuCompartilhamento() {
        document.getElementById('menu-compartilhamento').style.display = 'none';
    }

    function compartilharFacebook() {
        const url = encodeURIComponent(window.location.href);
        window.open(`https://www.facebook.com/sharer/sharer.php?u=https://www.lipsum.com/`, '_blank');
    }

    function compartilharTwitter() {
        const url = encodeURIComponent(window.location.href);
        const text = encodeURIComponent("Confira este evento incrível!");
        window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank');
    }

    function compartilharLinkedIn() {
        const url = encodeURIComponent(window.location.href);
        window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, '_blank');
    }
  </script>

@endsection