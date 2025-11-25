<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Relatório de Compras' }}</title>
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
        <h1>🛒 Relatório de Compras</h1>
        <p>Gerado em: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Animal</th>
                <th>Categoria</th>
                <th>Vendedor</th>
                <th>Peso</th>
                <th>Valor</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($purchases as $purchase)
            <tr>
                <td>{{ $purchase->purchase_date->format('d/m/Y') }}</td>
                <td>#{{ $purchase->animal->id ?? '-' }}</td>
                <td>{{ $purchase->animal->category->name ?? 'N/A' }}</td>
                <td>{{ $purchase->vendor->name ?? 'N/A' }}</td>
                <td>{{ number_format($purchase->weight, 1) }}kg</td>
                <td class="text-danger">R$ {{ number_format($purchase->value, 2, ',', '.') }}</td>
                <td>{{ $purchase->animal && !$purchase->animal->sale ? 'Ativo' : 'Vendido' }}</td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align: center;">Nenhuma compra encontrada.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>