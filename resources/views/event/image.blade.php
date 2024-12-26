@extends('includes.body')
@section('title', 'Criar Evento - Adicionar imagem')
@section('content')


<h1 class="text-xl font-serif font-bold" style="padding-left: 50px; padding-top: 20px; font-weight: bold;">{{$event['event_theme']}}</h1>
<h2 class="text-lg font-serif font-bold" style="padding-left: 50px; font-weight: 500;">{{$event['location']}}</h2>
<h3 class="text-lg font-serif font-bold" style="padding-left: 50px; font-weight: 500;">{{$event['session_date'][0]}}</h3>

<div style="width: 70%; margin: 2rem auto; padding: 20px; text-align: center;">
    <img src="{{asset('storage/progress1.png')}}" alt="Progress" style="width: 100%; height: auto; object-fit: cover;" />
</div>

<div style="padding: 20px; margin: 12px;">
    <form action="/event/ticket" enctype="multipart/form-data" method="POST" style="display: flex; flex-direction: column; gap: 16px; max-width: 800px; margin: 2px auto;">
       @csrf
        <h4 style="font-weight: bold; font-size: 1.5rem; margin-bottom: 12px; text-align: center; color: #333;">Banner de Publicidade</h4>
        <input type="hidden" name="event_theme" value="{{$event['event_theme']}}">

        @foreach ($event['session_date'] as $index => $e )
        <input type="hidden" name="session_date[]" value="{{$e}}">
        <input type="hidden" name="session_start_time[]" value="{{$event['session_start_time'][$index]}}">
        <input type="hidden" name="session_end_time[]" value="{{$event['session_end_time'][$index]}}">
        @endforeach

        <input type="hidden" name="category" value="{{$event['category']}}">
        <input type="hidden" name="event_type" value="{{$event['event_type']}}">
        <input type="hidden" name="location" value="{{$event['location']}}">
        <input type="hidden" name="additional_info" value="{{$event['additional_info']}}">
        <input type="hidden" required value="{{$event['vacancies']}}" name="vacancies">


        <div style="display: flex; flex-direction: column; gap: 8px;">
            <label for="event-theme" style="font-weight: 500; font-size: 1rem;">Carregar Imagem</label>
            <input
                type="file"
                required
                id="event-theme"
                name="event_banner"
                style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;"
            />
            <label for="event-theme" style="font-size: 0.85rem; color: #555; margin-top: 4px;">
                <em>* Apenas formatos PNG e JPG são permitidos.</em>
            </label>
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
                Voltar a editar evento
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
                Continuar
            </button>
        </div>
    </form>
</div>

@endsection
