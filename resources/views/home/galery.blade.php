@extends('includes.body')
@section('title', 'Galeria de Eventos')
@section('content')

<style>
    .image-container {
        position: relative;
        overflow: hidden;
    }

    .image-container img {
        transition: transform 0.3s ease, opacity 0.3s ease;
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

    .image-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .image-overlay img {
        max-width: 90%;
        max-height: 90%;
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
    }

    .image-overlay.active {
        display: flex;
    }

    .background-dimmed img:not(.active-image) {
        opacity: 0.3;
    }
    .image-overlay-content {
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 20px;
        max-width: 90%;
        text-align: center;
        z-index: 2000;
    }

    .image-overlay img {
        max-width: 60%;
        max-height: 80%;
        box-shadow: 0 0 20px rgba(255, 255, 255, 0.5);
    }

    .description-container {
        max-width: 60%;
        color: #fff;
        text-align: justify;
        background: rgba(0, 0, 0, 0.8);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(255, 255, 255, 0.3);
    }

    .description-container h2 {
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .description-container p {
        font-size: 14px;
        line-height: 1.5;
    }

</style>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 p-2">
    @foreach($events as $event)
        <div class="image-container">
            <img
                src="{{ url('storage/' . $event->banner_image) }}"
                alt="Imagem do evento"
                class="cursor-pointer"
                onclick="toggleImage(this)"
            >

        </div>
    @endforeach
</div>

<div id="image-overlay" class="image-overlay flex items-center justify-center" onclick="toggleImage()">
    <div class="image-overlay-content">
        <img id="image-large" src="" alt="Imagem ampliada">
        <div id="description-container" class="description-container">
            <p id="image-description">{{$event->description}}</p>
        </div>
    </div>
</div>

<script>
    let activeImage = null;

    function toggleImage(img = null) {
        const overlay = document.getElementById('image-overlay');
        const largeImage = document.getElementById('image-large');
        const allImages = document.querySelectorAll('.image-container img');

        if (img) {
            if (activeImage === img) {
                overlay.classList.remove('active');
                allImages.forEach(image => image.classList.remove('active-image'));
                activeImage = null;
            } else {
                largeImage.src = img.src;
                overlay.classList.add('active');
                allImages.forEach(image => image.classList.add('background-dimmed'));
                img.classList.add('active-image');
                activeImage = img;
            }
        } else {
            overlay.classList.remove('active');
            allImages.forEach(image => image.classList.remove('background-dimmed', 'active-image'));
            activeImage = null;
        }
    }
</script>

@endsection
