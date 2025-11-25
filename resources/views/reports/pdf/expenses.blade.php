<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Relatório de Despesas' }}</title>
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
        .stat-number { font-size: 18px; font-weight: bold; color: #dc3545; }
        .stat-label { font-size: 10px; color: #666; margin-top: 5px; }
        .section { margin-bottom: 30px; }
        .section h3 { color: #333; border-bottom: 1px solid #ddd; padding-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; font-size: 10px; }
        table th, table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        table th { background-color: #667eea; color: white; font-weight: bold; }
        .text-danger { color: #dc3545; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h1>📊 Relatório de Despesas</h1>
        <p>Sistema WebBoi - Gestão Pecuária</p>
        <p>Período: {{ \Carbon\Carbon::parse($period['start'])->format('d/m/Y') }} até {{ \Carbon\Carbon::parse($period['end'])->format('d/m/Y') }}</p>
        <p>Gerado em: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
    
    <div class="stats">
        <div class="stat-item">
            <div class="stat-number">R$ {{ number_format($expenses_by_category['supply']['medicamento'] + $expenses_by_category['supply']['alimentacao'], 2, ',', '.') }}</div>
            <div class="stat-label">Suprimentos</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">R$ {{ number_format($expenses_by_category['operational'], 2, ',', '.') }}</div>
            <div class="stat-label">Operacionais</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">R$ {{ number_format($expenses_by_category['freight'], 2, ',', '.') }}</div>
            <div class="stat-label">Fretes</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">R$ {{ number_format($total_expenses, 2, ',', '.') }}</div>
            <div class="stat-label">Total Geral</div>
        </div>
    </div>
    
    <div class="section">
        <h3>Suprimentos</h3>
        <table>
            <thead>
                <tr><th>Data</th><th>Item</th><th>Categoria</th><th>Animal</th><th>Valor</th></tr>
            </thead>
            <tbody>
                @forelse($supply_expenses->take(15) as $expense)
                <tr>
                    <td>{{ $expense->purchase_date->format('d/m/Y') }}</td>
                    <td>{{ $expense->name }}</td>
                    <td>{{ $expense->category_label }}</td>
                    <td>#{{ $expense->animal->id ?? 'N/A' }}</td>
                    <td class="text-danger">R$ {{ number_format($expense->value, 2, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" style="text-align: center;">Nenhum gasto com suprimentos</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="section">
        <h3>Despesas Operacionais</h3>
        <table>
            <thead>
                <tr><th>Data</th><th>Descrição</th><th>Local</th><th>Valor</th></tr>
            </thead>
            <tbody>
                @forelse($operational_expenses->take(15) as $expense)
                <tr>
                    <td>{{ $expense->date->format('d/m/Y') }}</td>
                    <td>{{ $expense->name }}</td>
                    <td>{{ $expense->local->name ?? 'N/A' }}</td>
                    <td class="text-danger">R$ {{ number_format($expense->value, 2, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" style="text-align: center;">Nenhuma despesa operacional</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>