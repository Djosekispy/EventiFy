<!DOCTYPE html>
<html>
<head>
    <title>Participantes do Evento</title>
</head>
<body style="font-family: 'Arial', sans-serif; background-color: #f9f9f9; margin: 0; padding: 20px;">
    <div style="max-width: 800px; margin: 0 auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); padding: 20px;">
        <h1 style="color: #2c3e50; font-size: 24px; text-align: center; margin-bottom: 20px; border-bottom: 2px solid #3498db; padding-bottom: 10px;">
            Participantes do Evento: {{ $event->title }}
        </h1>

        <!-- Tabela de Participantes -->
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr style="background-color: #3498db; color: #ffffff;">
                    <th style="padding: 12px; text-align: left; border-radius: 4px 0 0 4px;">Nome</th>
                    <th style="padding: 12px; text-align: left;">Email</th>
                    <th style="padding: 12px; text-align: left; border-radius: 0 4px 4px 0;">Data de Inscrição</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($participants as $participant)
                    <tr style="border-bottom: 1px solid #e0e0e0;">
                        <td style="padding: 12px; color: #2c3e50;">{{ $participant->name }}</td>
                        <td style="padding: 12px; color: #2c3e50;">{{ $participant->email }}</td>
                        <td style="padding: 12px; color: #2c3e50;">{{ $participant->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="text-align: center; margin-top: 30px;">
            <h6 style="color: #2c3e50; font-size: 14px; margin-bottom: 15px;">Escaneie o QR Code para detalhes do evento</h6>
            <img src="{{ $qrCodeImage }}" alt="QR Code do Evento" style="width: 150px; height: 150px; border: 1px solid #e0e0e0; border-radius: 8px;">
        </div>
        <div style="text-align: center; margin-top: 30px; color: #7f8c8d; font-size: 14px;">
            Gerado em {{ now()->format('d/m/Y H:i') }}
        </div>
    </div>
</body>
</html>