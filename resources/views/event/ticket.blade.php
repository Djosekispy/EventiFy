@extends('includes.body')
@section('title', 'Criar Evento - Adicionar imagem')
@section('content')


<h1 class="text-xl font-serif font-bold" style="padding-left: 50px; padding-top: 20px; font-weight: bold;">{{$event['event_theme']}}</h1>
<h2 class="text-lg font-serif font-bold" style="padding-left: 50px; font-weight: 500;">{{$event['location']}}</h2>
<h3 class="text-lg font-serif font-bold" style="padding-left: 50px; font-weight: 500;">{{$event['session_date'][0]}}</h3>

<!-- Centralizar a imagem -->
<div style="width: 70%; margin: 2rem auto; text-align: center;">
    <img src="{{ asset('storage/progress2.png') }}" alt="" style="width: 100%; height: auto; object-fit: cover;" />
</div>

<div style="padding: 20px; margin: 12px;">
    <form action="/event/review" method="post" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 16px; max-width: 800px; margin: auto;">
       @csrf
        <h4 style="font-weight: bold; font-size: 1.5rem; margin-bottom: 12px; text-align: center; color: #333;">
            Qual tipo de acesso está disponível?
        </h4>

        <input type="hidden" name="event_theme" value="{{$event['event_theme']}}">
        @foreach ($event['session_date'] as $index => $e )
        <input type="hidden" name="session_date[]" value="{{$e}}">
        <input type="hidden" name="session_start_time[]" value="{{$event['session_start_time'][$index]}}">
        <input type="hidden" name="session_end_time[]" value="{{$event['session_end_time'][$index]}}">
        @endforeach

        <input type="hidden" name="category" value="{{$event['category']}}">
        <input type="hidden" name="location" value="{{$event['location']}}">
        <input type="hidden" name="additional_info" value="{{$event['additional_info']}}">
        <input type="hidden" name="event_banner" value="{{$event['event_banner']}}">
        <input type="hidden" name="event_type" value="{{$event['event_type']}}">
        <input type="hidden" required value="{{$event['vacancies']}}" name="vacancies">

        <!-- Tipo de ingresso -->
        <div style="display: flex; flex-direction: row; gap: 8px;">
            <div id="ticket-paid" class="ticket-option" style="border: 2px solid #2B293D; border-radius: 20px; padding: 16px 20px; text-align: center; cursor: pointer;">
                <img src="{{ asset('storage/vector.png') }}" alt="" style="width: 50px; height: 50px; margin-bottom: 8px;" />
                <span>Cash</span>
                <span>Exige pagamento de entrada</span>
            </div>

            <div id="ticket-free" class="ticket-option" style="border: 2px solid #2B293D; border-radius: 20px; padding: 16px 20px; text-align: center; cursor: pointer;">
                <img src="{{ asset('storage/free.png') }}" alt="" style="width: 50px; height: 50px; margin-bottom: 8px;" />
                <span>Livre</span>
                <span>Não exige pagamento de entrada</span>
            </div>
        </div>

        <!-- Formulário de ingressos (inicia escondido) -->
        <div id="ticket-form" style="display: none; flex-direction: column; gap: 16px;">
            <label for="category" style="font-weight: 500; font-size: 1rem;">Tipo de ingressos</label>
            <div id="ticket-fields">
                <div style="display: flex; flex-direction: row; gap: 12px; align-items: center;">
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <label for="ticket-name">Nome do Ingresso</label>
                        <input
                            type="text"
                            required
                            name="ticket_name[]"
                            placeholder="Digite o nome do ingresso"
                            style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;"
                        />
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <label for="ticket-price">Preço</label>
                        <input
                            type="number"
                            required
                            name="ticket_price[]"
                            placeholder="Digite o preço"
                            style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;"
                        />
                    </div>
                    <button type="button" class="remove-ticket" style="padding: 6px 12px; background-color: red; color: white; border: none; border-radius: 4px; font-size: 0.9rem; cursor: pointer; display: none;">
                        Remover
                    </button>
                </div>
            </div>
            <button type="button" id="add-ticket" style="padding: 10px; background-color: green; color: white; border: none; border-radius: 4px; cursor: pointer;">
                Adicionar ingresso
            </button>
        </div>

        <div style="display: none; flex-direction: column; gap: 8px;"
        id='payment_info'>
            <label for="payment_info">Informação de Pagamento</label>
        <input
        type="text"
        name="payment_info"
        placeholder="Digite as informações de Pagamento"
        style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;"
    />
        </div>
        <!-- Botões -->
        <div style="display: flex; flex-direction: row; gap: 12px; justify-content: flex-end;">
            <button
              onclick="history.back()"
                type="button"
                style="padding: 10px 20px; color: #2B293D; border: none; border-radius: 4px; font-size: 1rem; font-weight: 600; cursor: pointer;">
                Voltar
            </button>

            <button
                type="submit"
                style="padding: 10px 20px; background-color: #2B293D; color: white; border: none; border-radius: 4px; font-size: 1rem; cursor: pointer;">
               Continuar
            </button>
        </div>
    </form>
</div>

<!-- JavaScript -->
<script>
    const ticketPaid = document.getElementById('ticket-paid');
    const ticketFree = document.getElementById('ticket-free');
    const ticketForm = document.getElementById('ticket-form');
    const addTicketButton = document.getElementById('add-ticket');
    const ticketFields = document.getElementById('ticket-fields');
    const payment_info = document.getElementById('payment_info');

    // Troca de seleção e exibição do formulário
    ticketPaid.addEventListener('click', function () {
        ticketPaid.style.backgroundColor = '#d3d3d3'; // Cor de fundo selecionada
        ticketFree.style.backgroundColor = ''; // Reset
        ticketForm.style.display = 'flex';
        payment_info.style.display = 'flex';
    });

    ticketFree.addEventListener('click', function () {
        ticketFree.style.backgroundColor = '#d3d3d3'; // Cor de fundo selecionada
        ticketPaid.style.backgroundColor = ''; // Reset
        ticketForm.style.display = 'none'; // Oculta o formulário
        payment_info.style.display = 'none';
    });

    // Adiciona um novo campo de ingresso
    addTicketButton.addEventListener('click', function () {
        const newField = document.createElement('div');
        newField.style.display = 'flex';
        newField.style.flexDirection = 'row';
        newField.style.gap = '12px';
        newField.style.alignItems = 'center';
        newField.innerHTML = `
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <label for="ticket-name">Nome do Ingresso</label>
                <input
                    type="text"
                    name="ticket_name[]"
                    placeholder="Digite o nome do ingresso"
                    style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;"
                />
            </div>
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <label for="ticket-price">Preço</label>
                <input
                    type="number"
                    name="ticket_price[]"
                    placeholder="Digite o preço"
                    style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 1rem;"
                />
            </div>
            <button type="button" class="remove-ticket" style="padding: 6px 12px; background-color: red; color: white; border: none; border-radius: 4px; font-size: 0.9rem; cursor: pointer;">
                Remover
            </button>
        `;
        ticketFields.appendChild(newField);

        // Adicionar funcionalidade de remover
        const removeButtons = ticketFields.querySelectorAll('.remove-ticket');
        removeButtons.forEach(button => {
            button.style.display = 'inline-block'; // Mostra botão
            button.addEventListener('click', function () {
                this.parentElement.remove();
            });
        });
    });
</script>

@endsection
