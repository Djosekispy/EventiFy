@extends('includes.body')
@section('title', 'Criar Evento - Revisar')
@section('content')

<h1 class="text-xl font-serif font-bold" style="padding-left: 50px; padding-top: 20px; font-weight: bold;">{{$event['event_theme']}}</h1>
<h2 class="text-lg font-serif font-bold" style="padding-left: 50px; font-weight: 500;">{{$event['location']}}</h2>
<h3 class="text-lg font-serif font-bold" style="padding-left: 50px; font-weight: 500;">{{$event['session_date'][0]}}</h3>

<div style="width: 70%; margin: 2rem auto; text-align: center; padding: 20px;">
    <img src="{{asset('storage/progress3.png')}}" alt="Progresso" style="width: 100%; height: auto; object-fit: scale-down;" />
</div>

<div style="padding: 20px; margin: 12px;">
    <div style="margin: 12px; border: 1px solid #2B293D; border-radius: 20px; overflow: hidden;">
        <div style="width: 100%; height: 500px; padding: 0; overflow: hidden;">
            <img src="{{url('storage/'.$event['event_banner'])}}" alt="Evento" style="width: 100%; height: 100%; object-fit: scale-down;">
        </div>

        <div style="display: flex; flex-direction: row; justify-content: space-between; padding: 20px; align-items: flex-start;">
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <h1 style="font-weight: bold; font-size: 2rem;">{{$event['event_theme']}}</h1>
                <p><i>Sessões</i></p>
                <ol>
                @foreach ($event['session_date'] as $index => $e )
                {{$index + 1}}ª .
                    <li>
                        <p style="gap: 4px;"><b>Dia:</b> <i>{{$e}}</i></p>
                        <p style="gap: 4px;"><b>Início:</b> <i>{{$event['session_start_time'][$index]}}</i></p>
                        <p style="gap: 4px;"><b>Fim:</b> <i>{{$event['session_end_time'][$index]}}</i></p>
                    </li>
                @endforeach
                </ol>
            <p style="gap: 4px;"><b >Localização:</b> <i>{{$event['location']}}</i></p>
            <p style="gap: 4px;"><b >Vagas Disponíveis:</b> <i>{{$event['vacancies']}}</i></p>
                <h2 style="font-weight: bold; font-size: 1.5rem;">Informações de Acesso</h2>
                <p><i>{{$event['payment_info']}}</i></p>

                <h2 style="font-weight: bold; font-size: 1.5rem;">Ingressos</h2>
                @if (isset($event['ticket_name']))
                <ul>
                    @foreach ($event['ticket_name'] as $index => $ticket )
                    @if(!empty($ticket))
                    <li>
                        <p style="gap: 4px;"><b > {{$ticket}}  - </b> <i>{{$event['ticket_price'][$index]}} kz</i></p>
                    </li>
                    @endif
                    @endforeach
                </ul>
                @endif

            </div>
            <div style="text-align: center;">
                <button
                    style="
                        background-color: #FFE047;
                        border-radius: 10px;
                        width: 200px;
                        color: #2B293D;
                        font-size: 18px;
                        font-weight: bold;
                        padding: 10px;
                        cursor: pointer;
                    "
                >
                    <span>-</span>
                </button>
            </div>
        </div>
        <div style="padding: 20px;">
            <h2 style="font-weight: bold; font-size: 1.5rem;">Descrição</h2>
            <p style="text-align: justify; padding: 8px 0; line-height: 1.6; color: #333;">
              {{$event['additional_info']}}
            </p>

            <div style="margin-top: 12px;">
                <i style="
                    background-color: #F8F7FA;
                    border-radius: 12px;
                    padding: 6px 12px;
                    display: inline-block;
                    font-size: 0.9rem;
                    color: #555;
                ">
                    Categoria: {{$event['category']}}
                </i>
            </div>
        </div>
    </div>

    <div style="display: flex; flex-direction: row; gap: 16px; justify-content: flex-end; margin-top: 20px;">
        <form action="/event/save" method="POST">
            @csrf
            <input type="hidden" name="event_theme" value="{{$event['event_theme']}}">
            @foreach ($event['session_date'] as $index => $e )
            <input type="hidden" name="session_date[]" value="{{$e}}">
            <input type="hidden" name="session_start_time[]" value="{{$event['session_start_time'][$index]}}">
            <input type="hidden" name="session_end_time[]" value="{{$event['session_end_time'][$index]}}">
            @endforeach
            <input type="hidden" name="event_type" value="{{$event['event_type']}}">
            <input type="hidden" name="category" value="{{$event['category']}}">
            <input type="hidden" name="payment_info" value="{{$event['payment_info']}}">
            <input type="hidden" name="location" value="{{$event['location']}}">
            <input type="hidden" name="additional_info" value="{{$event['additional_info']}}">
            <input type="hidden" name="event_banner" value="{{$event['event_banner']}}">

            @foreach ($event['ticket_name'] as $index => $ticket )
            @if(!empty($ticket))
                    <input type="hidden" value="{{$ticket}}" name="ticket_name[]">
                    <input type="hidden" name="ticket_price[]" value="{{$event['ticket_price'][$index]}}">
                @endif
            @endforeach



            <input type="hidden" value="{{$event['vacancies']}}" name="vacancies">

            <button
                type="submit"
                name="action"
                value="save_later"
                style="
                    padding: 10px 20px;
                    background-color: #FFE047;
                    color: #2B293D;
                    border: none;
                    border-radius: 8px;
                    font-size: 1rem;
                    cursor: pointer;
                    font-weight: 600;
                "
            >
                Publicar mais tarde
            </button>

            <button
                type="submit"
                name="action"
                value="publish"
                style="
                    padding: 10px 20px;
                    background-color: #2B293D;
                    color: white;
                    border: none;
                    border-radius: 8px;
                    font-size: 1rem;
                    cursor: pointer;
                "
            >
                Publicar
            </button>
        </form>

    </div>
</div>

@endsection
