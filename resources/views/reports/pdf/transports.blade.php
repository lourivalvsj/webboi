<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Relatório de Transportes' }}</title>
    @if(isset($printable) && $printable)
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
    @endif
    <style>
        body { font-family: Arial, sans-serif; font-size: 10px; margin: 15px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #333; font-size: 20px; }
        table { width: 100%; border-collapse: collapse; font-size: 9px; }
        table th, table td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        table th { background-color: #667eea; color: white; font-weight: bold; }
        .text-danger { color: #dc3545; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🚛 Relatório de Transportes</h1>
        <p>Gerado em: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Partida</th>
                <th>Chegada</th>
                <th>Caminhoneiro</th>
                <th>Destino</th>
                <th>Qtd. Animais</th>
                <th>Valor Frete</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transports as $transport)
            <tr>
                <td>{{ $transport->departure_date ? $transport->departure_date->format('d/m/Y') : '-' }}</td>
                <td>{{ $transport->arrival_date ? $transport->arrival_date->format('d/m/Y') : '-' }}</td>
                <td>{{ $transport->truckDriver->name ?? 'N/A' }}</td>
                <td>{{ $transport->local->name ?? 'N/A' }}</td>
                <td>{{ $transport->quantity_animals }}</td>
                <td class="text-danger">R$ {{ number_format($transport->value, 2, ',', '.') }}</td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align: center;">Nenhum transporte encontrado.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>