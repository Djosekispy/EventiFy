@extends('includes.body')
@section('title', 'Lista de Participantes')
@section('content')

<div class="container">
    <h1>Participantes do Evento</h1>
    @if (session('error'))
        <div class="alert alert-danger text-center mb-4">
            {{ session('error') }}
        </div>
    @endif
    <a href="{{ route('event.exportParticipantsToPdf', $eventId) }}" class="btn btn-primary mb-3">Exportar para PDF</a>
    <table class="table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Data de Inscrição</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($participants as $participant)
                <tr>
                    <td>{{ $participant->name }}</td>
                    <td>{{ $participant->email }}</td>
                    <td>{{ $participant->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

    @endsection