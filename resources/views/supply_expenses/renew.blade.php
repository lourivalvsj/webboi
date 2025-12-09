@extends('layouts.app')
@section('title', 'Renovar Estoque')
@section('content')
    <div class="container">
        <div class="page-header-modern">
            <h2><i class="fas fa-plus-circle me-2"></i>Renovar Estoque - {{ $supplyExpense->name }}</h2>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="modern-form-container">
                    <div class="alert alert-info mb-4">
                        <h6><i class="fas fa-info-circle me-2"></i>Informações do Produto Atual</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Produto:</strong> {{ $supplyExpense->name }}<br>
                                <strong>Categoria:</strong> {{ $supplyExpense->category_label }}<br>
                                <strong>Quantidade Atual:</strong> {{ number_format($supplyExpense->quantity, 3, ',', '.') }} {{ $supplyExpense->unit_of_measure }}
                            </div>
                            <div class="col-md-6">
                                <strong>Valor Atual:</strong> R$ {{ number_format($supplyExpense->value, 2, ',', '.') }}<br>
                                <strong>Quantidade Restante:</strong> 
                                <span class="{{ $supplyExpense->remaining_quantity <= 0 ? 'text-danger' : ($supplyExpense->is_low_stock ? 'text-warning' : 'text-success') }}">
                                    {{ number_format($supplyExpense->remaining_quantity, 3, ',', '.') }} {{ $supplyExpense->unit_of_measure }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('supply-expenses.process-renewal', $supplyExpense) }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="modern-form-group">
                                    <label class="modern-form-label">Quantidade a Adicionar *</label>
                                    <div class="input-group">
                                        <input type="number" name="added_quantity" step="0.001" 
                                               class="modern-form-control @error('added_quantity') is-invalid @enderror" 
                                               value="{{ old('added_quantity') }}" required>
                                        <span class="input-group-text">{{ $supplyExpense->unit_of_measure ?: 'unid' }}</span>
                                    </div>
                                    @error('added_quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Quantidade que será somada ao estoque atual
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="modern-form-group">
                                    <label class="modern-form-label">Novo Valor Unitário *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">R$</span>
                                        <input type="number" name="new_value" step="0.01" 
                                               class="modern-form-control @error('new_value') is-invalid @enderror" 
                                               value="{{ old('new_value', $supplyExpense->value) }}" required>
                                    </div>
                                    @error('new_value')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Valor unitário após a renovação (pode ser diferente do atual)
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="modern-form-group">
                                    <label class="modern-form-label">Custo da Renovação *</label>
                                    <div class="input-group">
                                        <span class="input-group-text">R$</span>
                                        <input type="number" name="renewal_cost" step="0.01" 
                                               class="modern-form-control @error('renewal_cost') is-invalid @enderror" 
                                               value="{{ old('renewal_cost') }}" required>
                                    </div>
                                    @error('renewal_cost')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Valor total gasto para adicionar o novo estoque
                                    </small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="modern-form-group">
                                    <label class="modern-form-label">Data da Renovação *</label>
                                    <input type="date" name="renewal_date" 
                                           class="modern-form-control @error('renewal_date') is-invalid @enderror" 
                                           value="{{ old('renewal_date', date('Y-m-d')) }}" required>
                                    @error('renewal_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="modern-form-group">
                            <label class="modern-form-label">Observações</label>
                            <textarea name="notes" class="modern-form-control @error('notes') is-invalid @enderror" 
                                      rows="3" placeholder="Observações sobre a renovação (opcional)">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="modern-form-actions">
                            <button type="submit" class="modern-btn modern-btn-success">
                                <i class="fas fa-plus-circle"></i>
                                Renovar Estoque
                            </button>
                            <a href="{{ route('supply-expenses.index') }}" class="modern-btn modern-btn-secondary">
                                <i class="fas fa-times"></i>
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-calculator me-2"></i>Cálculos Automáticos</h6>
                    </div>
                    <div class="card-body">
                        <div id="calculations">
                            <p class="text-muted">Preencha os campos para ver os cálculos</p>
                        </div>
                    </div>
                </div>

                @if($supplyExpense->renewals->count() > 0)
                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-history me-2"></i>Últimas Renovações</h6>
                        </div>
                        <div class="card-body">
                            @foreach($supplyExpense->renewals->take(3) as $renewal)
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        <small class="text-muted">{{ $renewal->renewal_date->format('d/m/Y') }}</small><br>
                                        <strong>+{{ number_format($renewal->added_quantity, 3, ',', '.') }}</strong>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-success">R$ {{ number_format($renewal->renewal_cost, 2, ',', '.') }}</small>
                                    </div>
                                </div>
                            @endforeach
                            <a href="{{ route('supply-expenses.renewal-history', $supplyExpense) }}" class="btn btn-sm btn-outline-primary w-100">
                                Ver Histórico Completo
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function updateCalculations() {
            const currentQuantity = {{ $supplyExpense->quantity }};
            const addedQuantity = parseFloat(document.querySelector('input[name="added_quantity"]').value) || 0;
            const renewalCost = parseFloat(document.querySelector('input[name="renewal_cost"]').value) || 0;
            const newValue = parseFloat(document.querySelector('input[name="new_value"]').value) || 0;
            
            const calculationsDiv = document.getElementById('calculations');
            
            if (addedQuantity > 0) {
                const newTotalQuantity = currentQuantity + addedQuantity;
                const costPerUnit = renewalCost > 0 && addedQuantity > 0 ? renewalCost / addedQuantity : 0;
                
                calculationsDiv.innerHTML = `
                    <div class="mb-2">
                        <strong>Nova Quantidade Total:</strong><br>
                        <span class="text-primary">${newTotalQuantity.toLocaleString('pt-BR', {minimumFractionDigits: 3})} {{ $supplyExpense->unit_of_measure ?: 'unid' }}</span>
                    </div>
                    <div class="mb-2">
                        <strong>Custo por Unidade Adicionada:</strong><br>
                        <span class="text-info">R$ ${costPerUnit.toLocaleString('pt-BR', {minimumFractionDigits: 2})}</span>
                    </div>
                    <div>
                        <strong>Valor Total do Novo Estoque:</strong><br>
                        <span class="text-success">R$ ${(newTotalQuantity * newValue).toLocaleString('pt-BR', {minimumFractionDigits: 2})}</span>
                    </div>
                `;
            } else {
                calculationsDiv.innerHTML = '<p class="text-muted">Preencha os campos para ver os cálculos</p>';
            }
        }

        // Atualizar cálculos quando os campos mudarem
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = ['added_quantity', 'renewal_cost', 'new_value'];
            inputs.forEach(input => {
                document.querySelector(`input[name="${input}"]`).addEventListener('input', updateCalculations);
            });
        });
    </script>
@endsection