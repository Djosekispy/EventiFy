<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('storage/ticket.png') }}" type="image/png">
    <title>@yield('title')</title>
    <meta property="og:title" content="@yield('og_title')" />
    <meta property="og:description" content="@yield('og_description')" />
    <meta property="og:image" content="@yield('og_image')" />
    <meta property="og:url" content="@yield('og_url', url()->current())" />
    <meta property="og:type" content="website" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .navbar-brand img {
            transition: transform 0.3s ease;
        }
        .navbar-brand:hover img {
            transform: rotate(360deg);
        }
        .footer-link {
            transition: color 0.3s ease;
        }
        .footer-link:hover {
            color: #ffc107 !important;
        }
        .social-icon {
            transition: transform 0.3s ease, color 0.3s ease;
        }
        .social-icon:hover {
            transform: translateY(-5px);
            color: #ffc107 !important;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <img src="{{ asset('storage/ticket.png') }}" alt="Logo" width="30" height="30" class="me-2">
                <span class="fw-bold text-warning">Eventify</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link text-white" href="/">Início</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="/galery">Galeria</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="/about">Sobre nós</a></li>
                    @guest
                    <li class="nav-item"><a class="btn btn-light text-black ms-2" href="/login">Entrar</a></li>
                    <li class="nav-item"><a class="btn btn-secondary text-white ms-2" href="/register">Cadastrar</a></li>
                    @endguest
                    @auth
                    <li class="nav-item"><a class="nav-link text-white" href="{{ route('your.event') }}">Eventos</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="/profile">Perfil</a></li>
                    <li class="nav-item"><a class="nav-link text-white ms-2" href="/event/form">Criar Evento</a></li>
                    <li class="nav-item"><a class="nav-link text-white ms-2" href="/logout">Terminar sessão</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-5">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 mb-4 mb-md-0">
                    <h5 class="fw-bold text-uppercase">Sobre a Empresa</h5>
                    <ul class="list-unstyled">
                        <li><a class="text-white text-decoration-none footer-link" href="#">Quem somos</a></li>
                        <li><a class="text-white text-decoration-none footer-link" href="#">Missão e valores</a></li>
                        <li><a class="text-white text-decoration-none footer-link" href="#">Carreiras</a></li>
                        <li><a class="text-white text-decoration-none footer-link" href="#">Contato</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4 mb-md-0">
                    <h5 class="fw-bold text-uppercase">Categorias</h5>
                    <ul class="list-unstyled">
                        <li><a class="text-white text-decoration-none footer-link" href="#">Festas</a></li>
                        <li><a class="text-white text-decoration-none footer-link" href="#">Conferências</a></li>
                        <li><a class="text-white text-decoration-none footer-link" href="#">Workshops</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4 mb-md-0">
                    <h5 class="fw-bold text-uppercase">Links Importantes</h5>
                    <ul class="list-unstyled">
                        <li><a class="text-white text-decoration-none footer-link" href="#">Política de Privacidade</a></li>
                        <li><a class="text-white text-decoration-none footer-link" href="#">Termos de Serviço</a></li>
                        <li><a class="text-white text-decoration-none footer-link" href="#">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4 mb-md-0">
                    <h5 class="fw-bold text-uppercase">Siga-nos</h5>
                    <div class="d-flex justify-content-start">
                        <a href="#" class="text-white me-3 social-icon" aria-label="Facebook">
                            <i class="fab fa-facebook fa-lg"></i>
                        </a>
                        <a href="#" class="text-white me-3 social-icon" aria-label="Instagram">
                            <i class="fab fa-instagram fa-lg"></i>
                        </a>
                        <a href="#" class="text-white me-3 social-icon" aria-label="Twitter">
                            <i class="fab fa-twitter fa-lg"></i>
                        </a>
                    </div>
                </div>
            </div>
            <hr class="bg-light my-4">
            <div class="row">
                <div class="col-12 text-center text-md-start">
                    <p class="mb-0 small">&copy; 2025 Eventify. Todos os direitos reservados.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>