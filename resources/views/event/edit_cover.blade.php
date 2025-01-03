@extends('includes.body')
@section('title', 'Editar Imagem do Evento')
@section('content')

<h1 class="text-xl font-serif font-bold" style="padding-left: 50px; padding-top: 20px; font-weight: bold;">{{ $event->title }}</h1>
<h2 class="text-lg font-serif font-bold" style="padding-left: 50px; font-weight: 500;">{{ $event->location }}</h2>

<div style="padding: 20px; margin: 12px; max-width: 800px; margin: 0 auto;">
    <div style="text-align: center; margin-bottom: 20px;">
        <img
            src="{{url('storage/'.$event->banner_image)}}"
            alt="Imagem Atual"
            style="width: 100%; max-width: 400px; border-radius: 8px; border: 1px solid #ccc;"
        >
    </div>
    @if(session('success'))
        <div style="margin-bottom: 20px; padding: 10px; border: 1px solid transparent; border-radius: 4px; color: #155724; background-color: #d4edda; border-color: #c3e6cb; text-align: center;">
            {{ session('success') }}
        </div>
    @endif



    <form
        action="/event/banner/{{ $event->id }}"
        enctype="multipart/form-data"
        method="POST"
        style="display: flex; flex-direction: column; gap: 16px;"
    >
        @csrf
        @method('PUT')

        <h4 style="font-weight: bold; font-size: 1.5rem; margin-bottom: 12px; text-align: center; color: #333;">Atualizar Imagem</h4>

        <div style="display: flex; flex-direction: column; gap: 8px;">
            <label for="event-banner" style="font-weight: 500; font-size: 1rem;">Nova Imagem</label>
            <input
                type="file"
                id="event-banner"
                name="event_banner"
                accept="image/png, image/jpeg"
                onchange="previewImage(event)"
                style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;"
                required
            />
            <label style="font-size: 0.85rem; color: #555; margin-top: 4px;">
                <em>* Apenas formatos PNG e JPG são permitidos.</em>
            </label>
        </div>
        <div id="image-preview" style="text-align: center; display: none; margin-top: 20px;">
            <h5 style="font-weight: 500; font-size: 1.2rem; color: #333; margin-bottom: 8px;">Pré-visualização</h5>
            <img id="preview-img" alt="Pré-visualização" style="width: 100%; max-width: 400px; border-radius: 8px; border: 1px solid #ccc;">
        </div>
        <div style="display: flex; flex-direction: row; gap: 12px; justify-content: flex-end;">
            <button
            type="button"
            style="
                padding: 10px 20px;
                color: #2B293D;
                border: 1px solid #ccc;
                border-radius: 4px;
                font-size: 1rem;
                cursor: pointer;
                font-weight: 600;
            "
             onclick="history.back()"
        >
            Voltar
        </button>
            <button
                type="submit"
                style="
                    padding: 10px 20px;
                    background-color: #2B293D;
                    color: white;
                    border: none;
                    border-radius: 4px;
                    font-size: 1rem;
                    cursor: pointer;
                "
            >
                Submeter
            </button>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const previewDiv = document.getElementById('image-preview');
        const previewImg = document.getElementById('preview-img');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewImg.src = e.target.result;
                previewDiv.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            previewDiv.style.display = 'none';
        }
    }
</script>

@endsection
