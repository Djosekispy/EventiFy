<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            text-align: center;
            background: #0044cc;
            color: #ffffff;
            padding: 20px 10px;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-banner {
            width: 100%;
            height: auto;
        }
        .email-body {
            padding: 20px;
            color: #333333;
        }
        .email-body h2 {
            color: #0044cc;
            font-size: 20px;
            margin-bottom: 10px;
        }
        .email-details {
            margin-top: 20px;
            padding: 15px;
            background: #f9f9f9;
            border-left: 4px solid #0044cc;
        }
        .email-details p {
            margin: 5px 0;
            font-size: 16px;
        }
        .email-footer {
            text-align: center;
            padding: 10px 20px;
            background: #f1f1f1;
            font-size: 14px;
            color: #777777;
        }
        .email-footer a {
            color: #0044cc;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>Convite para o Evento</h1>
        </div>
        
        <!-- Banner -->
        <img src="{{url('storage/'.$details['event_banner']) }}" alt="Banner do Evento" class="email-banner">

        <!-- Body -->
        <div class="email-body">
            <h2>Olá! {{ $details['name'] ? 'Sou ' . $details['name'] : '' }}</h2>
            <p>{{ $details['message'] }}</p>
            <div class="email-details">
                <p><strong>Evento:</strong> {{ $details['event_name'] }}</p>
                <p><strong>Local:</strong> {{ $details['event_location'] }}</p>
            </div>
            <p>Esperamos por você! Prepare-se para uma experiência incrível.</p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
        <p><a href="http://localhost:8000/deteils/{{$details['event_id']}}">Veja todos os detalhes do evento</a></p>
            <p>Para mais informações, entre em contato pelo e-mail: <a href="mailto:{{ $details['contact_email'] ?? 'contato@evento.com' }}">{{ $details['contact_email'] ?? 'contato@evento.com' }}</a>.</p>
            <p>Obrigado,</p>
            <p>{{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>
