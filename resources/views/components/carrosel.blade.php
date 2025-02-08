<div id="imageCarousel" class="carousel slide shadow-lg rounded h-100" data-bs-ride="carousel">
    <!-- Indicadores -->
    <div class="carousel-indicators">
        @foreach ($events as $index => $event)
            <button type="button" data-bs-target="#imageCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}" aria-label="Slide {{ $index + 1 }}"></button>
        @endforeach
    </div>

    <!-- Slides -->
    <div class="carousel-inner rounded">
        @foreach ($events as $index => $event)
            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                <a href="{{ url('/details/'.$event->id) }}" class="position-relative d-block">
                    <img src="{{ url('storage/'.$event->banner_image) }}" class="d-block w-100" style="object-fit: contain; height: 400px;" alt="Imagem do Carrossel">
                    <div class="carousel-caption d-none d-md-block bg-dark bg-opacity-50 rounded p-2" style="position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%); transition: opacity 0.3s;">
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <!-- Controles de Navegação -->
    <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Próximo</span>
    </button>
</div>
