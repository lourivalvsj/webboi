<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Relatório Financeiro' }}</title>
    @if(isset($printable) && $printable)
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
    @endif
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #333; font-size: 24px; }
        .stats { display: flex; justify-content: space-around; margin-bottom: 20px; background-color: #f8f9fa; padding: 15px; }
        .stat-item { text-align: center; }
        .stat-number { font-size: 18px; font-weight: bold; color: #007bff; }
        .stat-label { font-size: 10px; color: #666; margin-top: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 10px; }
        table th, table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        table th { background-color: #667eea; color: white; font-weight: bold; }
        table tr:nth-child(even) { background-color: #f2f2f2; }
        .text-success { color: #28a745; font-weight: bold; }
        .text-danger { color: #dc3545; font-weight: bold; }
        .section { margin-bottom: 30px; }
        .section h3 { color: #333; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>💰 Relatório Financeiro</h1>
        <p>Sistema WebBoi - Gestão Pecuária</p>
        <p>Período: {{ \Carbon\Carbon::parse($period['start'])->format('d/m/Y') }} até {{ \Carbon\Carbon::parse($period['end'])->format('d/m/Y') }}</p>
        <p>Gerado em: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
    
    <div class="stats">
        <div class="stat-item">
            <div class="stat-number text-success">R$ {{ number_format($revenue['total'], 2, ',', '.') }}</div>
            <div class="stat-label">Total de Receitas</div>
        </div>
        <div class="stat-item">
            <div class="stat-number text-danger">R$ {{ number_format($expenses['total'], 2, ',', '.') }}</div>
            <div class="stat-label">Total de Despesas</div>
        </div>
        <div class="stat-item">
            <div class="stat-number" style="color: {{ $profit_loss >= 0 ? '#28a745' : '#dc3545' }}">
                {{ $profit_loss >= 0 ? 'R$ ' : '-R$ ' }}{{ number_format(abs($profit_loss), 2, ',', '.') }}
            </div>
            <div class="stat-label">{{ $profit_loss >= 0 ? 'Lucro' : 'Prejuízo' }}</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ number_format($profit_margin, 1) }}%</div>
            <div class="stat-label">Margem de Lucro</div>
        </div>
    </div>
    
    <div class="section">
        <h3>Receitas - Vendas</h3>
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Animal</th>
                    <th>Comprador</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                @forelse($revenue['sales']->take(20) as $sale)
                <tr>
                    <td>{{ $sale->sale_date->format('d/m/Y') }}</td>
                    <td>#{{ $sale->animal->id ?? '-' }}</td>
                    <td>{{ $sale->buyer->name ?? '-' }}</td>
                    <td class="text-success">R$ {{ number_format($sale->value, 2, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align: center;">Nenhuma venda no período</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="section">
        <h3>Breakdown de Despesas</h3>
        <table>
            <thead>
                <tr>
                    <th>Categoria</th>
                    <th>Valor</th>
                    <th>Percentual</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Compras de Animais</td>
                    <td class="text-danger">R$ {{ number_format($expenses['purchases']['total'], 2, ',', '.') }}</td>
                    <td>{{ $expenses['total'] > 0 ? number_format(($expenses['purchases']['total'] / $expenses['total']) * 100, 1) : 0 }}%</td>
                </tr>
                <tr>
                    <td>Suprimentos</td>
                    <td class="text-danger">R$ {{ number_format($expenses['supplies']['total'], 2, ',', '.') }}</td>
                    <td>{{ $expenses['total'] > 0 ? number_format(($expenses['supplies']['total'] / $expenses['total']) * 100, 1) : 0 }}%</td>
                </tr>
                <tr>
                    <td>Despesas Operacionais</td>
                    <td class="text-danger">R$ {{ number_format($expenses['operational']['total'], 2, ',', '.') }}</td>
                    <td>{{ $expenses['total'] > 0 ? number_format(($expenses['operational']['total'] / $expenses['total']) * 100, 1) : 0 }}%</td>
                </tr>
                <tr>
                    <td>Fretes</td>
                    <td class="text-danger">R$ {{ number_format($expenses['freights']['total'], 2, ',', '.') }}</td>
                    <td>{{ $expenses['total'] > 0 ? number_format(($expenses['freights']['total'] / $expenses['total']) * 100, 1) : 0 }}%</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>