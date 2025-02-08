@extends('includes.body')
@section('title', 'Galeria de Eventos')
@section('content')

<style>
    .gallery-container {
        padding: 20px;
    }
    .image-container {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .image-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
    .image-container img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .image-container:hover img {
        transform: scale(1.1);
    }
    .hover-description {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        color: #fff;
        text-align: center;
        padding: 10px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .image-container:hover .hover-description {
        opacity: 1;
    }
    .modal-content img {
        max-width: 100%;
        max-height: 80vh;
        margin: auto;
        border-radius: 10px;
    }
    .description-container {
        padding: 20px;
        text-align: center;
    }
    .description-container h5 {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .description-container p {
        font-size: 1rem;
        color: #555;
    }
</style>

<div class="gallery-container">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-primary">Galeria de Eventos</h1>
        <p class="lead text-muted">Explore nossa coleção de eventos e descubra as melhores experiências.</p>
    </div>

    <div class="row">
        @foreach($events as $event)
            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="image-container">
                    <img
                        src="{{ url('storage/' . $event->banner_image) }}"
                        alt="Imagem do evento"
                        class="img-fluid cursor-pointer"
                        data-bs-toggle="modal" data-bs-target="#imageModal{{ $event->id }}"
                    >
                    <div class="hover-description">
                        <p class="m-0">{{ $event->title }}</p>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="imageModal{{ $event->id }}" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-body p-0 m-auto py-2">
                                <img src="{{ url('storage/' . $event->banner_image) }}" alt="Imagem do evento">
                            </div>
                            <div class="description-container">
                                <h5>{{ $event->title }}</h5>
                                <p>{{ $event->description }}</p>
                                <p class="text-muted"><small>Local: {{ $event->location }}</small></p>
                                <p class="text-muted"><small>Data: {{ \Carbon\Carbon::parse($event->realized_at)->format('d/m/Y') }}</small></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection