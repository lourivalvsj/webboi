@extends('layouts.app')
@section('title', 'Histórico de Renovações')
@section('content')
    <div class="container">
        <div class="page-header-modern">
            <h2><i class="fas fa-history me-2"></i>Histórico de Renovações</h2>
            <p class="text-muted">{{ $supplyExpense->name }} - {{ $supplyExpense->category_label }}</p>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Informações Atuais do Produto</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Quantidade Total:</strong><br>
                                <span class="text-primary fs-5">{{ number_format($supplyExpense->quantity, 3, ',', '.') }} {{ $supplyExpense->unit_of_measure }}</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Quantidade Restante:</strong><br>
                                <span class="{{ $supplyExpense->remaining_quantity <= 0 ? 'text-danger' : ($supplyExpense->is_low_stock ? 'text-warning' : 'text-success') }} fs-5">
                                    {{ number_format($supplyExpense->remaining_quantity, 3, ',', '.') }} {{ $supplyExpense->unit_of_measure }}
                                </span>
                            </div>
                            <div class="col-md-3">
                                <strong>Valor Atual:</strong><br>
                                <span class="text-success fs-5">R$ {{ number_format($supplyExpense->value, 2, ',', '.') }}</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Total de Renovações:</strong><br>
                                <span class="text-info fs-5">{{ $renewals->total() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modern-form-container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5><i class="fas fa-list me-2"></i>Histórico de Renovações</h5>
                <a href="{{ route('supply-expenses.renew', $supplyExpense) }}" class="modern-btn modern-btn-success">
                    <i class="fas fa-plus-circle"></i>
                    Nova Renovação
                </a>
            </div>

            @if($renewals->count() > 0)
                <div class="table-responsive">
                    <table class="table modern-table">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Quantidade Anterior</th>
                                <th>Quantidade Adicionada</th>
                                <th>Nova Quantidade Total</th>
                                <th>Valor Anterior</th>
                                <th>Novo Valor</th>
                                <th>Custo da Renovação</th>
                                <th>Observações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($renewals as $renewal)
                                <tr>
                                    <td>
                                        <strong>{{ $renewal->renewal_date->format('d/m/Y') }}</strong><br>
                                        <small class="text-muted">{{ $renewal->renewal_date->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <span class="text-muted">{{ number_format($renewal->previous_quantity, 3, ',', '.') }}</span>
                                        {{ $supplyExpense->unit_of_measure }}
                                    </td>
                                    <td>
                                        <span class="text-success fw-bold">+{{ number_format($renewal->added_quantity, 3, ',', '.') }}</span>
                                        {{ $supplyExpense->unit_of_measure }}
                                    </td>
                                    <td>
                                        <span class="text-primary fw-bold">{{ number_format($renewal->new_total_quantity, 3, ',', '.') }}</span>
                                        {{ $supplyExpense->unit_of_measure }}
                                    </td>
                                    <td>
                                        <span class="text-muted">R$ {{ number_format($renewal->previous_value, 2, ',', '.') }}</span>
                                    </td>
                                    <td>
                                        <span class="text-primary">R$ {{ number_format($renewal->new_value, 2, ',', '.') }}</span>
                                    </td>
                                    <td>
                                        <span class="text-danger fw-bold">R$ {{ number_format($renewal->renewal_cost, 2, ',', '.') }}</span>
                                        <br>
                                        <small class="text-muted">
                                            @if($renewal->added_quantity > 0)
                                                R$ {{ number_format($renewal->renewal_cost / $renewal->added_quantity, 2, ',', '.') }}/{{ $supplyExpense->unit_of_measure }}
                                            @endif
                                        </small>
                                    </td>
                                    <td>
                                        @if($renewal->notes)
                                            <small class="text-muted">{{ Str::limit($renewal->notes, 100) }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $renewals->links() }}
                </div>

                <!-- Resumo estatístico -->
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Resumo das Renovações</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h6 class="text-muted mb-1">Total Adicionado</h6>
                                            <h4 class="text-success">{{ number_format($supplyExpense->renewals->sum('added_quantity'), 3, ',', '.') }}</h4>
                                            <small class="text-muted">{{ $supplyExpense->unit_of_measure }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h6 class="text-muted mb-1">Custo Total das Renovações</h6>
                                            <h4 class="text-danger">R$ {{ number_format($supplyExpense->renewals->sum('renewal_cost'), 2, ',', '.') }}</h4>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h6 class="text-muted mb-1">Custo Médio por Unidade</h6>
                                            <h4 class="text-info">
                                                @php
                                                    $totalAdded = $supplyExpense->renewals->sum('added_quantity');
                                                    $totalCost = $supplyExpense->renewals->sum('renewal_cost');
                                                    $avgCost = $totalAdded > 0 ? $totalCost / $totalAdded : 0;
                                                @endphp
                                                R$ {{ number_format($avgCost, 2, ',', '.') }}
                                            </h4>
                                            <small class="text-muted">por {{ $supplyExpense->unit_of_measure }}</small>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="text-center">
                                            <h6 class="text-muted mb-1">Frequência de Renovação</h6>
                                            <h4 class="text-primary">{{ $renewals->total() }}</h4>
                                            <small class="text-muted">renovações</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-history fa-3x text-muted mb-3"></i>
                    <h4>Nenhuma renovação encontrada</h4>
                    <p class="mb-4">Este produto ainda não teve renovações de estoque.</p>
                    <a href="{{ route('supply-expenses.renew', $supplyExpense) }}" class="modern-btn modern-btn-success">
                        <i class="fas fa-plus-circle"></i>
                        Primeira Renovação
                    </a>
                </div>
            @endif
        </div>

        <div class="modern-form-actions">
            <a href="{{ route('supply-expenses.index') }}" class="modern-btn modern-btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Voltar aos Insumos
            </a>
            <a href="{{ route('supply-expenses.renew', $supplyExpense) }}" class="modern-btn modern-btn-success">
                <i class="fas fa-plus-circle"></i>
                Nova Renovação
            </a>
        </div>
    </div>
@endsection