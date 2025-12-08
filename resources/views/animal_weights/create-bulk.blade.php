@extends('layouts.app')

@section('title', 'Adicionar Múltiplas Pesagens')
@section('content')
<div class="container-fluid fade-in-up">
    <div class="page-header-modern">
        <div class="d-flex justify-content-between align-items-center">
            <h2><i class="fas fa-weight me-2"></i>Adicionar Múltiplas Pesagens</h2>
            <div>
                <a href="{{ route('animal-weights.create') }}" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-plus-circle"></i> Pesagem Única
                </a>
                <a href="{{ route('animal-weights.index') }}" class="modern-btn modern-btn-outline">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </div>

    <div class="modern-form-container">
        <form action="{{ route('animal-weights.store-bulk') }}" method="POST" id="bulkWeightForm">
            @csrf
            
            <div class="mb-4">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-2">
                            <label class="form-label mb-0">Quantidade de pesagens:</label>
                            <input type="number" id="weightQuantity" class="form-control" style="width: 80px;" min="1" max="50" value="1">
                            <button type="button" class="modern-btn modern-btn-info" onclick="setWeightQuantity()">
                                <i class="fas fa-list"></i> Definir
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex gap-2">
                            <button type="button" class="modern-btn modern-btn-success" onclick="addWeightRow()">
                                <i class="fas fa-plus"></i> Adicionar
                            </button>
                            <button type="button" class="modern-btn modern-btn-warning" onclick="removeLastRow()">
                                <i class="fas fa-minus"></i> Remover
                            </button>
                            <span class="ms-3 text-muted">Total: <span id="weightCount">1</span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 40%">Animal <span class="text-danger">*</span></th>
                            <th style="width: 25%">Peso (kg) <span class="text-danger">*</span></th>
                            <th style="width: 25%">Data da Pesagem <span class="text-danger">*</span></th>
                            <th style="width: 10%">Ação</th>
                        </tr>
                    </thead>
                    <tbody id="weightRows">
                        <tr class="weight-row">
                            <td>
                                <select name="weights[0][animal_id]" class="form-select form-select-sm" required>
                                    <option value="">Selecione um animal...</option>
                                    @foreach($animals as $animal)
                                        <option value="{{ $animal->id }}">{{ $animal->tag }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" step="0.01" name="weights[0][weight]" class="form-control form-control-sm" placeholder="0.00" required>
                            </td>
                            <td>
                                <input type="date" name="weights[0][recorded_at]" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" required>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="modern-form-actions">
                <button type="submit" class="modern-btn modern-btn-success">
                    <i class="fas fa-save"></i> Salvar Todas as Pesagens
                </button>
                <a href="{{ route('animal-weights.index') }}" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
                <div class="ms-auto">
                    <small class="text-muted">* Campos obrigatórios</small>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    let weightRowCount = 1;

    function addWeightRow() {
        const tbody = document.getElementById('weightRows');
        const newRow = document.createElement('tr');
        newRow.className = 'weight-row';
        
        newRow.innerHTML = `
            <td>
                <select name="weights[${weightRowCount}][animal_id]" class="form-select form-select-sm" required>
                    <option value="">Selecione um animal...</option>
                    @foreach($animals as $animal)
                        <option value="{{ $animal->id }}">{{ $animal->tag }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" step="0.01" name="weights[${weightRowCount}][weight]" class="form-control form-control-sm" placeholder="0.00" required>
            </td>
            <td>
                <input type="date" name="weights[${weightRowCount}][recorded_at]" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" required>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        
        tbody.appendChild(newRow);
        weightRowCount++;
        updateWeightCount();
    }

    function removeRow(button) {
        const rows = document.querySelectorAll('.weight-row');
        if (rows.length > 1) {
            button.closest('tr').remove();
            updateWeightCount();
            reindexRows();
        } else {
            alert('Deve haver pelo menos uma pesagem para registrar.');
        }
    }

    function removeLastRow() {
        const rows = document.querySelectorAll('.weight-row');
        if (rows.length > 1) {
            rows[rows.length - 1].remove();
            updateWeightCount();
            reindexRows();
        } else {
            alert('Deve haver pelo menos uma pesagem para registrar.');
        }
    }

    function updateWeightCount() {
        const count = document.querySelectorAll('.weight-row').length;
        document.getElementById('weightCount').textContent = count;
    }

    function reindexRows() {
        const rows = document.querySelectorAll('.weight-row');
        rows.forEach((row, index) => {
            const inputs = row.querySelectorAll('input, select');
            inputs.forEach(input => {
                const name = input.getAttribute('name');
                if (name) {
                    const newName = name.replace(/\[\d+\]/, `[${index}]`);
                    input.setAttribute('name', newName);
                }
            });
        });
        weightRowCount = rows.length;
    }

    function setWeightQuantity() {
        const quantity = parseInt(document.getElementById('weightQuantity').value);
        const currentRows = document.querySelectorAll('.weight-row').length;
        
        if (quantity < 1 || quantity > 50) {
            alert('A quantidade deve estar entre 1 e 50 pesagens.');
            return;
        }
        
        if (quantity > currentRows) {
            // Adicionar linhas
            const toAdd = quantity - currentRows;
            for (let i = 0; i < toAdd; i++) {
                addWeightRow();
            }
        } else if (quantity < currentRows) {
            // Remover linhas
            const toRemove = currentRows - quantity;
            const rows = document.querySelectorAll('.weight-row');
            for (let i = 0; i < toRemove; i++) {
                if (rows.length > 1) {
                    rows[rows.length - 1 - i].remove();
                }
            }
            updateWeightCount();
            reindexRows();
        }
    }

    // Focar no primeiro campo ao carregar a página
    document.addEventListener('DOMContentLoaded', function() {
        const firstSelect = document.querySelector('select[name="weights[0][animal_id]"]');
        if (firstSelect) {
            firstSelect.focus();
        }
    });
</script>
@endsection