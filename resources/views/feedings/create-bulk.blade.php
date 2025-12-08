@extends('layouts.app')

@section('title', 'Adicionar Múltiplas Alimentações')
@section('content')
<div class="container-fluid fade-in-up">
    <div class="page-header-modern">
        <div class="d-flex justify-content-between align-items-center">
            <h2><i class="fas fa-apple-alt me-2"></i>Adicionar Múltiplas Alimentações</h2>
            <div>
                <a href="{{ route('feedings.create') }}" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-plus-circle"></i> Alimentação Única
                </a>
                <a href="{{ route('feedings.index') }}" class="modern-btn modern-btn-outline">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </div>

    <div class="modern-form-container">
        <form action="{{ route('feedings.store-bulk') }}" method="POST" id="bulkFeedingForm">
            @csrf
            
            <div class="mb-4">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-2">
                            <label class="form-label mb-0">Quantidade de alimentações:</label>
                            <input type="number" id="feedingQuantity" class="form-control" style="width: 80px;" min="1" max="50" value="1">
                            <button type="button" class="modern-btn modern-btn-info" onclick="setFeedingQuantity()">
                                <i class="fas fa-list"></i> Definir
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex gap-2">
                            <button type="button" class="modern-btn modern-btn-success" onclick="addFeedingRow()">
                                <i class="fas fa-plus"></i> Adicionar
                            </button>
                            <button type="button" class="modern-btn modern-btn-warning" onclick="removeLastRow()">
                                <i class="fas fa-minus"></i> Remover
                            </button>
                            <span class="ms-3 text-muted">Total: <span id="feedingCount">1</span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 25%">Animal <span class="text-danger">*</span></th>
                            <th style="width: 20%">Tipo de Alimento <span class="text-danger">*</span></th>
                            <th style="width: 15%">Quantidade <span class="text-danger">*</span></th>
                            <th style="width: 15%">Unidade</th>
                            <th style="width: 15%">Data <span class="text-danger">*</span></th>
                            <th style="width: 10%">Ação</th>
                        </tr>
                    </thead>
                    <tbody id="feedingRows">
                        <tr class="feeding-row">
                            <td>
                                <select name="feedings[0][animal_id]" class="form-select form-select-sm" required>
                                    <option value="">Selecione um animal...</option>
                                    @foreach($animals as $animal)
                                        <option value="{{ $animal->id }}">{{ $animal->tag }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" name="feedings[0][feed_type]" class="form-control form-control-sm" placeholder="Ex: Ração, Milho..." list="feedTypesList" required>
                                <datalist id="feedTypesList">
                                    @foreach($feedTypes as $feedType)
                                        <option value="{{ $feedType }}">
                                    @endforeach
                                </datalist>
                            </td>
                            <td>
                                <input type="number" step="0.01" name="feedings[0][quantity]" class="form-control form-control-sm" placeholder="0.00" required>
                            </td>
                            <td>
                                <input type="text" name="feedings[0][unit_of_measure]" class="form-control form-control-sm" placeholder="kg, g, saco...">
                            </td>
                            <td>
                                <input type="date" name="feedings[0][feeding_date]" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" required>
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
                    <i class="fas fa-save"></i> Salvar Todas as Alimentações
                </button>
                <a href="{{ route('feedings.index') }}" class="modern-btn modern-btn-secondary">
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
    let feedingRowCount = 1;

    function addFeedingRow() {
        const tbody = document.getElementById('feedingRows');
        const newRow = document.createElement('tr');
        newRow.className = 'feeding-row';
        
        newRow.innerHTML = `
            <td>
                <select name="feedings[${feedingRowCount}][animal_id]" class="form-select form-select-sm" required>
                    <option value="">Selecione um animal...</option>
                    @foreach($animals as $animal)
                        <option value="{{ $animal->id }}">{{ $animal->tag }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="text" name="feedings[${feedingRowCount}][feed_type]" class="form-control form-control-sm" placeholder="Ex: Ração, Milho..." list="feedTypesList" required>
            </td>
            <td>
                <input type="number" step="0.01" name="feedings[${feedingRowCount}][quantity]" class="form-control form-control-sm" placeholder="0.00" required>
            </td>
            <td>
                <input type="text" name="feedings[${feedingRowCount}][unit_of_measure]" class="form-control form-control-sm" placeholder="kg, g, saco...">
            </td>
            <td>
                <input type="date" name="feedings[${feedingRowCount}][feeding_date]" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" required>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        
        tbody.appendChild(newRow);
        feedingRowCount++;
        updateFeedingCount();
    }

    function removeRow(button) {
        const rows = document.querySelectorAll('.feeding-row');
        if (rows.length > 1) {
            button.closest('tr').remove();
            updateFeedingCount();
            reindexRows();
        } else {
            alert('Deve haver pelo menos uma alimentação para registrar.');
        }
    }

    function removeLastRow() {
        const rows = document.querySelectorAll('.feeding-row');
        if (rows.length > 1) {
            rows[rows.length - 1].remove();
            updateFeedingCount();
            reindexRows();
        } else {
            alert('Deve haver pelo menos uma alimentação para registrar.');
        }
    }

    function updateFeedingCount() {
        const count = document.querySelectorAll('.feeding-row').length;
        document.getElementById('feedingCount').textContent = count;
    }

    function reindexRows() {
        const rows = document.querySelectorAll('.feeding-row');
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
        feedingRowCount = rows.length;
    }

    function setFeedingQuantity() {
        const quantity = parseInt(document.getElementById('feedingQuantity').value);
        const currentRows = document.querySelectorAll('.feeding-row').length;
        
        if (quantity < 1 || quantity > 50) {
            alert('A quantidade deve estar entre 1 e 50 alimentações.');
            return;
        }
        
        if (quantity > currentRows) {
            // Adicionar linhas
            const toAdd = quantity - currentRows;
            for (let i = 0; i < toAdd; i++) {
                addFeedingRow();
            }
        } else if (quantity < currentRows) {
            // Remover linhas
            const toRemove = currentRows - quantity;
            const rows = document.querySelectorAll('.feeding-row');
            for (let i = 0; i < toRemove; i++) {
                if (rows.length > 1) {
                    rows[rows.length - 1 - i].remove();
                }
            }
            updateFeedingCount();
            reindexRows();
        }
    }

    // Focar no primeiro campo ao carregar a página
    document.addEventListener('DOMContentLoaded', function() {
        const firstSelect = document.querySelector('select[name="feedings[0][animal_id]"]');
        if (firstSelect) {
            firstSelect.focus();
        }
    });
</script>
@endsection