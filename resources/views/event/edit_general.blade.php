@extends('includes.body')

@section('title', 'Editar Evento')

@section('content')
<div class="container">
    <h1 class="text-center my-4 display-4">Atualizar Informações do Evento</h1>

    <!-- Mensagens de Sucesso/Erro -->
    @if (session('success'))
        <div class="alert alert-success text-center mx-auto col-md-8">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger text-center mx-auto col-md-8">
            {{ session('error') }}
        </div>
    @endif

    <!-- Formulário de Edição -->
    <div class="card shadow-lg mx-auto col-md-8">
        <div class="card-body">
            <form action="/event/update/{{$event->id}}" method="post">
                @csrf
                <h4 class="card-title text-center mb-4">Detalhes do Evento</h4>

                <!-- Tema do Evento -->
                <div class="mb-3">
                    <label for="event-theme" class="form-label">Tema do Evento</label>
                    <input
                        type="text"
                        id="event-theme"
                        name="event_theme"
                        value="{{$event->title}}"
                        placeholder="Digite o tema do evento"
                        class="form-control"
                    />
                </div>

                <!-- Categoria e Vagas -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="category" class="form-label">Categoria</label>
                        <select
                            id="category"
                            name="category"
                            required
                            class="form-select"
                        >
                            <option value="" disabled selected>Selecione</option>
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}" {{ $event->category_id == $category->id ? 'selected' : '' }}>
                                    {{$category->category_title}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="vacancies" class="form-label">Total de Vagas</label>
                        <input
                            type="number"
                            id="vacancies"
                            name="vacancies"
                            value="{{$event->vacancies}}"
                            required
                            class="form-control"
                        />
                    </div>
                </div>

                <!-- Tipo de Evento -->
                <div class="mb-3">
                    <label class="form-label">Tipo de Evento</label>
                    <div class="d-flex gap-3">
                        <div class="form-check">
                            <input
                                type="radio"
                                name="event_type"
                                value="presencial"
                                {{ $event->event_type == 'presencial' ? 'checked' : '' }}
                                class="form-check-input"
                            />
                            <label class="form-check-label">Presencial</label>
                        </div>
                        <div class="form-check">
                            <input
                                type="radio"
                                name="event_type"
                                value="online"
                                {{ $event->event_type == 'online' ? 'checked' : '' }}
                                class="form-check-input"
                            />
                            <label class="form-check-label">Online</label>
                        </div>
                    </div>
                </div>

                <!-- Localização -->
                <div class="mb-3">
                    <label for="location" class="form-label">Localização</label>
                    <input
                        type="text"
                        id="location"
                        name="location"
                        value="{{$event->location}}"
                        required
                        placeholder="Digite o local do evento"
                        class="form-control"
                    />
                </div>

                <!-- Descrição -->
                <div class="mb-4">
                    <label for="additional_info" class="form-label">Descrição</label>
                    <textarea
                        id="additional_info"
                        name="description"
                        required
                        placeholder="Digite informações adicionais"
                        class="form-control"
                        rows="4"
                    >{{$event->description}}</textarea>
                </div>

                <!-- Botões -->
                <div class="d-flex justify-content-end gap-2">
                    <button
                        type="button"
                        onclick="history.back()"
                        class="btn btn-secondary"
                    >
                        Voltar
                    </button>
                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Atualizar Evento
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection