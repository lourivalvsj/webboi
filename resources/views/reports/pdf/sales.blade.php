<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Relatório de Vendas' }}</title>
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
        .text-success { color: #28a745; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>📈 Relatório de Vendas</h1>
        <p>Gerado em: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Animal</th>
                <th>Categoria</th>
                <th>Comprador</th>
                <th>Peso</th>
                <th>Valor</th>
                <th>Preço/kg</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sales as $sale)
            @php $pricePerKg = $sale->weight_at_sale > 0 ? $sale->value / $sale->weight_at_sale : 0; @endphp
            <tr>
                <td>{{ $sale->sale_date->format('d/m/Y') }}</td>
                <td>#{{ $sale->animal->id ?? '-' }}</td>
                <td>{{ $sale->animal->category->name ?? 'N/A' }}</td>
                <td>{{ $sale->buyer->name ?? 'N/A' }}</td>
                <td>{{ number_format($sale->weight_at_sale, 1) }}kg</td>
                <td class="text-success">R$ {{ number_format($sale->value, 2, ',', '.') }}</td>
                <td>R$ {{ number_format($pricePerKg, 2, ',', '.') }}/kg</td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align: center;">Nenhuma venda encontrada.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>