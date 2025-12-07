<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Relatório de Gastos com Alimentação' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            background: white;
        }

        .header {
            background: #28a745;
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .header .period {
            font-size: 14px;
            opacity: 0.9;
        }

        .stats {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            gap: 10px;
        }

        .stat-card {
            flex: 1;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 15px;
            text-align: center;
            border-radius: 5px;
        }

        .stat-card h3 {
            font-size: 18px;
            color: #28a745;
            margin-bottom: 5px;
        }

        .stat-card small {
            color: #666;
            font-size: 11px;
        }

        .section {
            margin-bottom: 30px;
        }

        .section-title {
            background: #f8f9fa;
            padding: 10px;
            border-left: 4px solid #28a745;
            margin-bottom: 15px;
            font-weight: bold;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
            font-size: 11px;
        }

        table th {
            background-color: #28a745;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .text-end {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .badge {
            background: #007bff;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
        }

        .text-success {
            color: #28a745 !important;
            font-weight: bold;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .no-data {
            text-align: center;
            color: #6c757d;
            font-style: italic;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 5px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 50px;
            background: #f8f9fa;
            border-top: 1px solid #dee2e6;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            font-size: 10px;
            color: #666;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .footer {
                position: fixed;
                bottom: 0;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📊 Relatório de Gastos com Alimentação</h1>
        <div class="period">
            Período: {{ \Carbon\Carbon::parse($stats['period']['start'])->format('d/m/Y') }} até {{ \Carbon\Carbon::parse($stats['period']['end'])->format('d/m/Y') }}
        </div>
    </div>

    <!-- Estatísticas -->
    <div class="stats">
        <div class="stat-card">
            <h3>R$ {{ number_format($stats['total_value'], 2, ',', '.') }}</h3>
            <small>Valor Total Gasto</small>
        </div>
        <div class="stat-card">
            <h3>{{ number_format($stats['total_quantity'], 2, ',', '.') }}</h3>
            <small>Quantidade Total</small>
        </div>
        <div class="stat-card">
            <h3>{{ $stats['total_records'] }}</h3>
            <small>Total de Alimentações</small>
        </div>
        <div class="stat-card">
            <h3>R$ {{ number_format($stats['average_cost_per_record'], 2, ',', '.') }}</h3>
            <small>Custo Médio</small>
        </div>
    </div>

    <!-- Gastos por Animal -->
    @if(isset($feedingByAnimal) && $feedingByAnimal->count() > 0)
    <div class="section">
        <div class="section-title">🐄 Gastos Estimados por Animal</div>
        <table>
            <thead>
                <tr>
                    <th>Animal (Brinco)</th>
                    <th>Custo Estimado</th>
                    <th>Quantidade</th>
                    <th>Alimentações</th>
                    <th>Média</th>
                </tr>
            </thead>
            <tbody>
                @foreach($feedingByAnimal as $animalData)
                <tr>
                    <td><span class="badge">{{ $animalData['animal']->tag }}</span></td>
                    <td class="text-end text-success">R$ {{ number_format($animalData['estimated_cost'], 2, ',', '.') }}</td>
                    <td class="text-end">{{ number_format($animalData['total_quantity'], 2, ',', '.') }}</td>
                    <td class="text-center">{{ $animalData['records_count'] }}</td>
                    <td class="text-end">{{ number_format($animalData['average_per_feeding'], 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Resumo por Tipo -->
    @if($feedingByType->count() > 0)
    <div class="section">
        <div class="section-title">🥗 Gastos por Tipo de Alimento</div>
        <table>
            <thead>
                <tr>
                    <th>Tipo de Alimento</th>
                    <th>Valor Total</th>
                    <th>Quantidade</th>
                    <th>Compras</th>
                    <th>Valor Médio</th>
                </tr>
            </thead>
            <tbody>
                @foreach($feedingByType as $type)
                <tr>
                    <td><strong>{{ $type['name'] }}</strong></td>
                    <td class="text-end">R$ {{ number_format($type['total_value'], 2, ',', '.') }}</td>
                    <td class="text-end">{{ number_format($type['total_quantity'], 2, ',', '.') }}</td>
                    <td class="text-center">{{ $type['records_count'] }}</td>
                    <td class="text-end">R$ {{ number_format($type['average_value'], 2, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Detalhes das Compras -->
    <div class="section">
        <div class="section-title">🛒 Detalhes das Compras de Alimentação</div>
        @if($feedingSupplies->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Alimento</th>
                    <th>Animal</th>
                    <th>Quantidade</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                @foreach($feedingSupplies as $supply)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($supply->purchase_date)->format('d/m/Y') }}</td>
                    <td><strong>{{ $supply->name }}</strong></td>
                    <td>
                        @if($supply->animal)
                            <span class="badge">{{ $supply->animal->tag }}</span>
                        @else
                            <span class="text-muted">Compra Geral</span>
                        @endif
                    </td>
                    <td class="text-end">
                        {{ number_format($supply->quantity, 2, ',', '.') }} {{ $supply->unit_of_measure }}
                    </td>
                    <td class="text-end text-success">
                        R$ {{ number_format($supply->value, 2, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="no-data">
            Nenhuma compra de alimentação encontrada no período selecionado.
        </div>
        @endif
    </div>

    <!-- Registros de Alimentação -->
    <div class="section">
        <div class="section-title">🍽️ Registros de Alimentação do Período</div>
        @if($feedingRecords->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Animal</th>
                    <th>Tipo de Ração</th>
                    <th>Quantidade</th>
                </tr>
            </thead>
            <tbody>
                @foreach($feedingRecords->take(50) as $feeding)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($feeding->feeding_date)->format('d/m/Y') }}</td>
                    <td><span class="badge">{{ $feeding->animal->tag }}</span></td>
                    <td>{{ $feeding->feed_type }}</td>
                    <td class="text-end">
                        {{ number_format($feeding->quantity, 2, ',', '.') }} {{ $feeding->unit_of_measure }}
                    </td>
                </tr>
                @endforeach
                @if($feedingRecords->count() > 50)
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        ... e mais {{ $feedingRecords->count() - 50 }} registros
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
        @else
        <div class="no-data">
            Nenhum registro de alimentação encontrado no período selecionado.
        </div>
        @endif
    </div>

    <div class="footer">
        <div>Sistema WebBoi - Gestão Pecuária</div>
        <div>Relatório gerado em {{ now()->format('d/m/Y H:i') }}</div>
    </div>

    <script>
        // Auto print when loaded for PDF export
        if (window.location.href.includes('export=pdf')) {
            window.onload = function() {
                window.print();
            }
        }
    </script>
</body>
</html>