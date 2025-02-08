@extends('includes.body')

@section('title', 'Sobre Nós')
@section('content')

<div class="container my-5">
    <!-- Cabeçalho -->
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-primary">Sobre Nós</h1>
        <p class="lead text-muted">
            Transformando a maneira como você cria, gerencia e promove eventos. Conheça nossa missão, visão e valores.
        </p>
    </div>

    <!-- Missão, Visão e Valores -->
    <div class="row g-4 mb-5">
        <!-- Missão -->
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <img src="{{ asset('images/missao.png') }}" class="img-fluid rounded-circle mb-3" alt="Missão" style="width: 150px; height: 150px;">
                    <h3 class="card-title fw-bold text-primary">Missão</h3>
                    <p class="card-text text-muted">
                        Facilitar a criação e gestão de eventos, oferecendo uma plataforma intuitiva e poderosa que conecta organizadores e participantes de forma eficiente.
                    </p>
                </div>
            </div>
        </div>

        <!-- Visão -->
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <img src="{{ asset('images/visao.png') }}" class="img-fluid rounded-circle mb-3" alt="Visão" style="width: 150px; height: 150px;">
                    <h3 class="card-title fw-bold text-primary">Visão</h3>
                    <p class="card-text text-muted">
                        Ser a principal referência em plataformas de eventos, reconhecida pela inovação, confiabilidade e impacto positivo na experiência dos usuários.
                    </p>
                </div>
            </div>
        </div>

        <!-- Valores -->
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <img src="{{ asset('images/valores.png') }}" class="img-fluid rounded-circle mb-3" alt="Valores" style="width: 150px; height: 150px;">
                    <h3 class="card-title fw-bold text-primary">Valores</h3>
                    <ul class="list-unstyled text-muted">
                        <li class="mb-2">Inovação</li>
                        <li class="mb-2">Transparência</li>
                        <li class="mb-2">Colaboração</li>
                        <li class="mb-2">Sustentabilidade</li>
                        <li>Foco no Usuário</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- História da Plataforma -->
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <img src="{{ asset('storage/historia.png') }}" class="img-fluid rounded shadow" alt="História da Plataforma">
        </div>
        <div class="col-md-6">
            <h2 class="fw-bold text-primary">Nossa História</h2>
            <p class="text-muted">
                A plataforma foi criada em 2020 com o objetivo de simplificar a organização de eventos, desde pequenos encontros até grandes conferências. Percebemos que muitos organizadores enfrentavam dificuldades para gerenciar inscrições, divulgar eventos e interagir com os participantes.
            </p>
            <p class="text-muted">
                Hoje, somos uma solução completa para quem deseja criar, editar e promover eventos de forma eficiente, com ferramentas que facilitam a vida dos organizadores e enriquecem a experiência dos participantes.
            </p>
        </div>
    </div>

    <!-- Benefícios da Plataforma -->
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">Por Que Escolher Nossa Plataforma?</h2>
        <p class="text-muted">Descubra os benefícios de usar nossa plataforma para seus eventos.</p>
    </div>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <i class="fas fa-calendar-alt fa-3x text-primary mb-3"></i>
                    <h5 class="card-title fw-bold">Criação de Eventos</h5>
                    <p class="card-text text-muted">
                        Crie eventos de forma rápida e intuitiva, com ferramentas que facilitam a personalização e o gerenciamento.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <i class="fas fa-ticket-alt fa-3x text-primary mb-3"></i>
                    <h5 class="card-title fw-bold">Venda de Ingressos</h5>
                    <p class="card-text text-muted">
                        Ofereça ingressos online com segurança e facilidade, integrado a métodos de pagamento confiáveis.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                    <h5 class="card-title fw-bold">Engajamento</h5>
                    <p class="card-text text-muted">
                        Conecte-se com seus participantes através de ferramentas de comunicação e interação.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Como Funciona a Plataforma -->
    <div class="text-center my-5">
        <h2 class="fw-bold text-primary">Como Funciona a Plataforma?</h2>
        <p class="text-muted">Descubra como você pode criar, gerenciar e promover eventos de forma simples e eficiente.</p>
    </div>
    <div class="row g-4">
        <!-- Passo 1: Criação de Eventos -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <span class="badge bg-primary rounded-circle p-3 mb-3">1</span>
                    <h5 class="card-title fw-bold">Crie Seu Evento</h5>
                    <p class="card-text text-muted">
                        Cadastre seu evento em poucos minutos. Adicione detalhes como data, local, descrição e imagem de capa.
                    </p>
                </div>
            </div>
        </div>
        <!-- Passo 2: Personalização -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <span class="badge bg-primary rounded-circle p-3 mb-3">2</span>
                    <h5 class="card-title fw-bold">Personalize</h5>
                    <p class="card-text text-muted">
                        Escolha entre diferentes modelos de ingressos, defina preços e adicione sessões ou atividades.
                    </p>
                </div>
            </div>
        </div>
        <!-- Passo 3: Divulgação -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <span class="badge bg-primary rounded-circle p-3 mb-3">3</span>
                    <h5 class="card-title fw-bold">Divulgue</h5>
                    <p class="card-text text-muted">
                        Compartilhe seu evento nas redes sociais, envie convites por e-mail e acompanhe o engajamento em tempo real.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection