@extends('includes.body')
@section('title', 'Editar Evento')
@section('content')
<h1 class="text-2xl font-serif font-bold text-center" style="padding: 20px;">Atualizar Informações do Evento</h1>
@if (session('success'))
    <div style="color: green; padding: 10px; border: 1px solid green; margin-bottom: 10px; max-width: 600px; margin: 0 auto;">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div style="color: red; padding: 10px; border: 1px solid red; margin-bottom: 10px; max-width: 600px; margin: 0 auto;">
        {{ session('error') }}
    </div>
@endif

<div style="padding: 20px; margin: 12px;">
    <form action="/event/update/{{$event->id}}" method="post" style="display: flex; flex-direction: column; gap: 16px; max-width: 800px; margin: 0 auto;">
        @csrf
        <h4 style="font-weight: bold; font-size: 1.5rem; margin-bottom: 12px; text-align: center; color: #333;">Detalhes do Evento</h4>
        <div style="display: flex; flex-direction: column; gap: 8px;">
            <label for="event-theme" style="font-weight: 500; font-size: 1rem;">Tema do Evento</label>
            <input type="text" value="{{$event->title}}" id="event-theme" name="event_theme" placeholder="Digite o tema do evento" style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;">
        </div>
        <div style="display: flex; flex-direction: row; gap: 8px;">
            <div style="flex: 3;">
                <label for="category" style="font-weight: 500; font-size: 1rem;">Categoria</label>
                <select id="category" name="category" required style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;">
                    <option value="" disabled selected>Selecione</option>
                    @foreach ($categories as $index => $category)
                        <option value="{{$category->id}}" {{ $event->category_id == $category->id ? 'selected' : '' }}>{{$category->category_title}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="vacancies" style="font-weight: 500; font-size: 1rem;">Total de Vagas</label>
                <input type="number" id="vacancies" name="vacancies" value="{{$event->vacancies}}" required style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;">
            </div>
        </div>
        <div style="display: flex; flex-direction: column; gap: 8px;">
            <label style="font-weight: 500; font-size: 1rem;">Tipo de Evento</label>
            <div style="display: flex; gap: 12px;">
                <label style="display: flex; align-items: center; gap: 8px;">
                    <input type="radio" name="event_type" value="presencial" {{ $event->event_type == 'presencial' ? 'checked' : '' }}>
                    Presencial
                </label>
                <label style="display: flex; align-items: center; gap: 8px;">
                    <input type="radio" name="event_type" value="online" {{ $event->event_type == 'online' ? 'checked' : '' }}>
                    Online
                </label>
            </div>
        </div>
        <div style="display: flex; flex-direction: column; gap: 8px;">
            <label for="location" style="font-weight: 500; font-size: 1rem;">Localização</label>
            <input type="text" id="location" name="location" value="{{$event->location}}" required placeholder="Digite o local do evento" style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;">
        </div>
        <div style="display: flex; flex-direction: column; gap: 8px;">
            <label for="additional_info" style="font-weight: 500; font-size: 1rem;">Descrição</label>
            <textarea id="additional_info" name="description" required placeholder="Digite informações adicionais" style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;">{{$event->description}}</textarea>
        </div>

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
        <button type="submit" style="padding: 12px 20px; background-color: #28a745; color: white; border: none; border-radius: 4px; font-size: 1rem; cursor: pointer; transition: background-color 0.2s;">
            Atualizar Evento
        </button>
    </form>
</div>
@endsection
