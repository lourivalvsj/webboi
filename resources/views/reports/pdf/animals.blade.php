<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Relatório de Animais' }}</title>
    @if(isset($printable) && $printable)
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
    @endif
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        
        .header h1 {
            margin: 0;
            color: #333;
            font-size: 24px;
        }
        
        .header p {
            margin: 5px 0;
            color: #666;
            font-size: 14px;
        }
        
        .stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 18px;
            font-weight: bold;
            color: #007bff;
        }
        
        .stat-label {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 10px;
        }
        
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        table th {
            background-color: #667eea;
            color: white;
            font-weight: bold;
        }
        
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            color: white;
            font-size: 9px;
            font-weight: bold;
        }
        
        .badge-success { background-color: #28a745; }
        .badge-info { background-color: #17a2b8; }
        .badge-secondary { background-color: #6c757d; }
        .badge-primary { background-color: #007bff; }
        .badge-warning { background-color: #ffc107; color: #212529; }
        
        .text-success { color: #28a745; font-weight: bold; }
        .text-primary { color: #007bff; font-weight: bold; }
        .text-muted { color: #6c757d; }
        
        .footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🐄 Relatório de Animais</h1>
        <p>Sistema WebBoi - Gestão Pecuária</p>
        <p>Gerado em: {{ now()->format('d/m/Y H:i:s') }}</p>
        @if(request('start_date') || request('end_date'))
            <p>Período: 
                {{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->format('d/m/Y') : 'Início' }} 
                até 
                {{ request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->format('d/m/Y') : 'Fim' }}
            </p>
        @endif
    </div>
    
    <!-- Estatísticas -->
    <div class="stats">
        <div class="stat-item">
            <div class="stat-number">{{ $stats['total_animals'] }}</div>
            <div class="stat-label">Total de Animais</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $stats['active_animals'] }}</div>
            <div class="stat-label">Animais Ativos</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ $stats['sold_animals'] }}</div>
            <div class="stat-label">Animais Vendidos</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ number_format($stats['average_weight'] ?? 0, 1) }}kg</div>
            <div class="stat-label">Peso Médio</div>
        </div>
        <div class="stat-item">
            <div class="stat-number">{{ number_format($stats['total_weight'] ?? 0, 0) }}kg</div>
            <div class="stat-label">Peso Total</div>
        </div>
    </div>
    
    <!-- Tabela de Animais -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Categoria</th>
                <th>Status</th>
                <th>Cadastrado</th>
                <th>Último Peso</th>
                <th>Medicações</th>
                <th>Alimentações</th>
                <th>Valor Investido</th>
                <th>Valor Vendido</th>
            </tr>
        </thead>
        <tbody>
            @forelse($animals as $animal)
            <tr>
                <td>#{{ $animal->id }}</td>
                <td>
                    <span class="badge badge-secondary">{{ $animal->category->name ?? 'Sem categoria' }}</span>
                </td>
                <td>
                    @if($animal->sale)
                        <span class="badge badge-info">Vendido</span>
                    @else
                        <span class="badge badge-success">Ativo</span>
                    @endif
                </td>
                <td>{{ $animal->created_at->format('d/m/Y') }}</td>
                <td>
                    @if($animal->weights->count() > 0)
                        {{ number_format($animal->weights->last()->weight, 1) }}kg
                        @if($animal->weights->last()->recorded_at)
                            <br><small>({{ $animal->weights->last()->recorded_at->format('d/m/Y') }})</small>
                        @endif
                    @else
                        <span class="text-muted">Sem pesagem</span>
                    @endif
                </td>
                <td>
                    <span class="badge badge-primary">{{ $animal->medications->count() }}</span>
                </td>
                <td>
                    <span class="badge badge-warning">{{ $animal->feedings->count() }}</span>
                </td>
                <td>
                    @if($animal->purchase)
                        <span class="text-success">R$ {{ number_format($animal->purchase->value, 2, ',', '.') }}</span>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
                <td>
                    @if($animal->sale)
                        <span class="text-primary">R$ {{ number_format($animal->sale->value, 2, ',', '.') }}</span>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align: center; color: #666; padding: 20px;">
                    Nenhum animal encontrado com os filtros aplicados.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        <p>WebBoi - Sistema de Gestão Pecuária | Página {PAGE_NUM} de {PAGE_COUNT}</p>
    </div>
</body>
</html>