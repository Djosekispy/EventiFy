<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Inscrição no Evento</title>
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
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .email-header {
            background-color: #2B293D;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }
        .email-body {
            padding: 20px;
            color: #333333;
        }
        .email-body h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }
        .email-body p {
            font-size: 16px;
            line-height: 1.5;
        }
        .email-body ul {
            list-style-type: none;
            padding: 0;
        }
        .email-body ul li {
            background-color: #f9f9f9;
            margin: 10px 0;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #e0e0e0;
        }
        .email-footer {
            background-color: #f4f4f4;
            padding: 10px;
            text-align: center;
            font-size: 14px;
            color: #777777;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Cabeçalho -->
        <div class="email-header">
            <h1>Cancelamento de Inscrição no Evento</h1>
        </div>

        <!-- Corpo do E-mail -->
        <div class="email-body">
            <h2>Olá, {{ $user->name }}!</h2>
            <p>Um  usuário cancelou sua inscrição no seu evento <strong>{{ $event->title }}</strong>.</p>
        </div>

        <!-- Rodapé -->
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} Eventify. Todos os direitos reservados.</p>
        </div>
    </div>
</body>
</html>