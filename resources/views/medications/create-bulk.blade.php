@extends('layouts.app')

@section('title', 'Adicionar Múltiplas Medicações')
@section('content')
<div class="container-fluid fade-in-up">
    <div class="page-header-modern">
        <div class="d-flex justify-content-between align-items-center">
            <h2><i class="fas fa-pills me-2"></i>Adicionar Múltiplas Medicações</h2>
            <div>
                <a href="{{ route('medications.create') }}" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-plus-circle"></i> Medicação Única
                </a>
                <a href="{{ route('medications.index') }}" class="modern-btn modern-btn-outline">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </div>

    <div class="modern-form-container">
        <form action="{{ route('medications.store-bulk') }}" method="POST" id="bulkMedicationForm">
            @csrf
            
            <div class="mb-4">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-2">
                            <label class="form-label mb-0">Quantidade de medicações:</label>
                            <input type="number" id="medicationQuantity" class="form-control" style="width: 80px;" min="1" max="50" value="1">
                            <button type="button" class="modern-btn modern-btn-info" onclick="setMedicationQuantity()">
                                <i class="fas fa-list"></i> Definir
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex gap-2">
                            <button type="button" class="modern-btn modern-btn-success" onclick="addMedicationRow()">
                                <i class="fas fa-plus"></i> Adicionar
                            </button>
                            <button type="button" class="modern-btn modern-btn-warning" onclick="removeLastRow()">
                                <i class="fas fa-minus"></i> Remover
                            </button>
                            <span class="ms-3 text-muted">Total: <span id="medicationCount">1</span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 25%">Animal <span class="text-danger">*</span></th>
                            <th style="width: 20%">Medicamento <span class="text-danger">*</span></th>
                            <th style="width: 15%">Dose <span class="text-danger">*</span></th>
                            <th style="width: 15%">Unidade</th>
                            <th style="width: 15%">Data <span class="text-danger">*</span></th>
                            <th style="width: 10%">Ação</th>
                        </tr>
                    </thead>
                    <tbody id="medicationRows">
                        <tr class="medication-row">
                            <td>
                                <select name="medications[0][animal_id]" class="form-select form-select-sm" required>
                                    <option value="">Selecione um animal...</option>
                                    @foreach($animals as $animal)
                                        <option value="{{ $animal->id }}">{{ $animal->tag }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" name="medications[0][medication_name]" class="form-control form-control-sm" placeholder="Nome do medicamento..." list="medicationNamesList" required>
                                <datalist id="medicationNamesList">
                                    @foreach($medicationNames as $medicationName)
                                        <option value="{{ $medicationName }}">
                                    @endforeach
                                </datalist>
                            </td>
                            <td>
                                <input type="number" step="0.01" name="medications[0][dose]" class="form-control form-control-sm" placeholder="0.00" required>
                            </td>
                            <td>
                                <input type="text" name="medications[0][unit_of_measure]" class="form-control form-control-sm" placeholder="ml, mg, comprimido...">
                            </td>
                            <td>
                                <input type="date" name="medications[0][administration_date]" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" required>
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
                    <i class="fas fa-save"></i> Salvar Todas as Medicações
                </button>
                <a href="{{ route('medications.index') }}" class="modern-btn modern-btn-secondary">
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
    let medicationRowCount = 1;

    function addMedicationRow() {
        const tbody = document.getElementById('medicationRows');
        const newRow = document.createElement('tr');
        newRow.className = 'medication-row';
        
        newRow.innerHTML = `
            <td>
                <select name="medications[${medicationRowCount}][animal_id]" class="form-select form-select-sm" required>
                    <option value="">Selecione um animal...</option>
                    @foreach($animals as $animal)
                        <option value="{{ $animal->id }}">{{ $animal->tag }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="text" name="medications[${medicationRowCount}][medication_name]" class="form-control form-control-sm" placeholder="Nome do medicamento..." list="medicationNamesList" required>
            </td>
            <td>
                <input type="number" step="0.01" name="medications[${medicationRowCount}][dose]" class="form-control form-control-sm" placeholder="0.00" required>
            </td>
            <td>
                <input type="text" name="medications[${medicationRowCount}][unit_of_measure]" class="form-control form-control-sm" placeholder="ml, mg, comprimido...">
            </td>
            <td>
                <input type="date" name="medications[${medicationRowCount}][administration_date]" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" required>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        
        tbody.appendChild(newRow);
        medicationRowCount++;
        updateMedicationCount();
    }

    function removeRow(button) {
        const rows = document.querySelectorAll('.medication-row');
        if (rows.length > 1) {
            button.closest('tr').remove();
            updateMedicationCount();
            reindexRows();
        } else {
            alert('Deve haver pelo menos uma medicação para registrar.');
        }
    }

    function removeLastRow() {
        const rows = document.querySelectorAll('.medication-row');
        if (rows.length > 1) {
            rows[rows.length - 1].remove();
            updateMedicationCount();
            reindexRows();
        } else {
            alert('Deve haver pelo menos uma medicação para registrar.');
        }
    }

    function updateMedicationCount() {
        const count = document.querySelectorAll('.medication-row').length;
        document.getElementById('medicationCount').textContent = count;
    }

    function reindexRows() {
        const rows = document.querySelectorAll('.medication-row');
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
        medicationRowCount = rows.length;
    }

    function setMedicationQuantity() {
        const quantity = parseInt(document.getElementById('medicationQuantity').value);
        const currentRows = document.querySelectorAll('.medication-row').length;
        
        if (quantity < 1 || quantity > 50) {
            alert('A quantidade deve estar entre 1 e 50 medicações.');
            return;
        }
        
        if (quantity > currentRows) {
            // Adicionar linhas
            const toAdd = quantity - currentRows;
            for (let i = 0; i < toAdd; i++) {
                addMedicationRow();
            }
        } else if (quantity < currentRows) {
            // Remover linhas
            const toRemove = currentRows - quantity;
            const rows = document.querySelectorAll('.medication-row');
            for (let i = 0; i < toRemove; i++) {
                if (rows.length > 1) {
                    rows[rows.length - 1 - i].remove();
                }
            }
            updateMedicationCount();
            reindexRows();
        }
    }

    // Focar no primeiro campo ao carregar a página
    document.addEventListener('DOMContentLoaded', function() {
        const firstSelect = document.querySelector('select[name="medications[0][animal_id]"]');
        if (firstSelect) {
            firstSelect.focus();
        }
    });
</script>
@endsection