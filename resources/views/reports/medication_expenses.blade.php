@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-danger text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0"><i class="fas fa-pills me-2"></i>Relatório de Gastos com Medicamentos</h4>
                            <small class="opacity-90">
                                Período: {{ \Carbon\Carbon::parse($stats['period']['start'])->format('d/m/Y') }} até {{ \Carbon\Carbon::parse($stats['period']['end'])->format('d/m/Y') }}
                                @if(request('animal_id'))
                                    <br>Animal: {{ $animals->firstWhere('id', request('animal_id'))->tag ?? 'N/A' }}
                                @endif
                            </small>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-light btn-sm" onclick="window.print()">
                                <i class="fas fa-print me-1"></i>Imprimir
                            </button>
                            <form action="{{ route('reports.medication_expenses') }}" method="GET" class="d-inline">
                                @foreach(request()->except('export') as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                                <input type="hidden" name="export" value="pdf">
                                <button type="submit" class="btn btn-light btn-sm">
                                    <i class="fas fa-file-pdf me-1"></i>PDF
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Filtros -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <form action="{{ route('reports.medication_expenses') }}" method="GET" class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label"><i class="fas fa-calendar me-1"></i>Data Inicial</label>
                                    <input type="date" name="start_date" class="form-control" 
                                           value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label"><i class="fas fa-calendar me-1"></i>Data Final</label>
                                    <input type="date" name="end_date" class="form-control" 
                                           value="{{ request('end_date', now()->format('Y-m-d')) }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label"><i class="fas fa-cow me-1"></i>Animal</label>
                                    <select name="animal_id" class="form-select">
                                        <option value="">Todos os Animais</option>
                                        @foreach($animals as $animal)
                                            <option value="{{ $animal->id }}" {{ request('animal_id') == $animal->id ? 'selected' : '' }}>
                                                {{ $animal->tag }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary me-2">
                                        <i class="fas fa-filter me-1"></i>Filtrar
                                    </button>
                                    <a href="{{ route('reports.medication_expenses') }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-undo me-1"></i>Limpar
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Estatísticas -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-danger text-white border-0">
                                <div class="card-body text-center">
                                    <h3 class="mb-1">R$ {{ number_format($stats['total_value'], 2, ',', '.') }}</h3>
                                    <small>Valor Total Gasto</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white border-0">
                                <div class="card-body text-center">
                                    <h3 class="mb-1">{{ number_format($stats['total_quantity'], 2, ',', '.') }}</h3>
                                    <small>Quantidade Total Comprada</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white border-0">
                                <div class="card-body text-center">
                                    <h3 class="mb-1">{{ $stats['total_records'] }}</h3>
                                    <small>Total de Medicações</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-secondary text-white border-0">
                                <div class="card-body text-center">
                                    <h3 class="mb-1">R$ {{ number_format($stats['average_cost_per_record'], 2, ',', '.') }}</h3>
                                    <small>Custo Médio por Medicação</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gastos por Animal -->
                    @if(isset($medicationByAnimal) && $medicationByAnimal->count() > 0)
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="mb-3"><i class="fas fa-cow me-2"></i>Gastos Reais por Animal</h5>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-danger">
                                        <tr>
                                            <th>Animal (Brinco)</th>
                                            <th class="text-end">Custo Real</th>
                                            <th class="text-end">Dose Total Usada</th>
                                            <th class="text-end">Medicações</th>
                                            <th class="text-end">Média por Medicação</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($medicationByAnimal as $animalData)
                                        <tr>
                                            <td><strong>{{ $animalData['animal']->tag }}</strong></td>
                                            <td class="text-end"><strong class="text-danger">R$ {{ number_format($animalData['real_cost'], 2, ',', '.') }}</strong></td>
                                            <td class="text-end">{{ number_format($animalData['total_dose'], 2, ',', '.') }}</td>
                                            <td class="text-end">{{ $animalData['records_count'] }}</td>
                                            <td class="text-end">{{ number_format($animalData['average_per_medication'], 2, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Resumo por Tipo de Medicamento -->
                    @if($medicationByType->count() > 0)
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="mb-3"><i class="fas fa-chart-pie me-2"></i>Gastos por Tipo de Medicamento</h5>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-danger">
                                        <tr>
                                            <th>Tipo de Medicamento</th>
                                            <th class="text-end">Valor Total</th>
                                            <th class="text-end">Quantidade</th>
                                            <th class="text-end">Compras</th>
                                            <th class="text-end">Valor Médio</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($medicationByType as $type)
                                        <tr>
                                            <td><strong>{{ $type['name'] }}</strong></td>
                                            <td class="text-end">R$ {{ number_format($type['total_value'], 2, ',', '.') }}</td>
                                            <td class="text-end">{{ number_format($type['total_quantity'], 2, ',', '.') }}</td>
                                            <td class="text-end">{{ $type['records_count'] }}</td>
                                            <td class="text-end">R$ {{ number_format($type['average_value'], 2, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Detalhes das Compras -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="mb-3"><i class="fas fa-shopping-cart me-2"></i>Detalhes das Compras de Medicamentos</h5>
                            @if($medicationSupplies->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-danger">
                                        <tr>
                                            <th>Data</th>
                                            <th>Medicamento</th>
                                            <th>Animal</th>
                                            <th>Descrição</th>
                                            <th class="text-end">Quantidade</th>
                                            <th class="text-end">Valor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($medicationSupplies as $supply)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($supply->purchase_date)->format('d/m/Y') }}</td>
                                            <td><strong>{{ $supply->name }}</strong></td>
                                            <td>
                                                @if($supply->animal)
                                                    <strong>{{ $supply->animal->tag }}</strong>
                                                @else
                                                    <span class="text-muted">Compra Geral</span>
                                                @endif
                                            </td>
                                            <td>{{ $supply->description ?? '-' }}</td>
                                            <td class="text-end">
                                                {{ number_format($supply->quantity, 2, ',', '.') }} {{ $supply->unit_of_measure }}
                                            </td>
                                            <td class="text-end">
                                                <strong class="text-danger">R$ {{ number_format($supply->value, 2, ',', '.') }}</strong>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                @if(request('animal_id'))
                                    Nenhuma compra de medicamento encontrada para o animal <strong>{{ $animals->firstWhere('id', request('animal_id'))->tag ?? 'selecionado' }}</strong> no período.
                                @else
                                    Nenhuma compra de medicamento encontrada no período selecionado.
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Registros de Medicação -->
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mb-3"><i class="fas fa-syringe me-2"></i>Registros de Medicação do Período</h5>
                            @if($medicationRecords->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-info">
                                        <tr>
                                            <th>Data</th>
                                            <th>Animal</th>
                                            <th>Medicamento</th>
                                            <th class="text-end">Dose</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($medicationRecords as $medication)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($medication->administration_date)->format('d/m/Y') }}</td>
                                            <td>
                                                <strong>{{ $medication->animal->tag }}</strong>
                                            </td>
                                            <td>{{ $medication->medication_name }}</td>
                                            <td class="text-end">
                                                {{ number_format($medication->dose, 2, ',', '.') }} {{ $medication->unit_of_measure }}
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                @if(request('animal_id'))
                                    Nenhum registro de medicação encontrado para o animal <strong>{{ $animals->firstWhere('id', request('animal_id'))->tag ?? 'selecionado' }}</strong> no período.
                                @else
                                    Nenhum registro de medicação encontrado no período selecionado.
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
@media print {
    .btn, .card-header .d-flex > div:last-child {
        display: none !important;
    }
    
    .card {
        border: none !important;
        box-shadow: none !important;
    }
    
    .card-header {
        background: #dc3545 !important;
        -webkit-print-color-adjust: exact;
    }
    
    body {
        background: white !important;
    }
}
</style>
@endpush