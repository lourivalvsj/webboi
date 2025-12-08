@extends('layouts.app')

@section('title', 'Adicionar Múltiplas Compras')
@section('content')
<div class="container-fluid fade-in-up">
    <div class="page-header-modern">
        <div class="d-flex justify-content-between align-items-center">
            <h2><i class="fas fa-shopping-cart me-2"></i>Adicionar Múltiplas Compras</h2>
            <div>
                <a href="{{ route('purchases.create') }}" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-plus-circle"></i> Compra Única
                </a>
                <a href="{{ route('purchases.index') }}" class="modern-btn modern-btn-outline">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </div>

    <div class="modern-form-container">
        <form action="{{ route('purchases.store-bulk') }}" method="POST" id="bulkPurchaseForm">
            @csrf
            
            <div class="mb-4">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-2">
                            <label class="form-label mb-0">Quantidade de compras:</label>
                            <input type="number" id="purchaseQuantity" class="form-control" style="width: 80px;" min="1" max="50" value="1">
                            <button type="button" class="modern-btn modern-btn-info" onclick="setPurchaseQuantity()">
                                <i class="fas fa-list"></i> Definir
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex gap-2">
                            <button type="button" class="modern-btn modern-btn-success" onclick="addPurchaseRow()">
                                <i class="fas fa-plus"></i> Adicionar
                            </button>
                            <button type="button" class="modern-btn modern-btn-warning" onclick="removeLastRow()">
                                <i class="fas fa-minus"></i> Remover
                            </button>
                            <span class="ms-3 text-muted">Total: <span id="purchaseCount">1</span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 15%">Animal <span class="text-danger">*</span></th>
                            <th style="width: 15%">Vendedor</th>
                            <th style="width: 12%">Data Compra</th>
                            <th style="width: 10%">Valor (R$) <span class="text-danger">*</span></th>
                            <th style="width: 10%">Frete (R$)</th>
                            <th style="width: 12%">Transportador</th>
                            <th style="width: 10%">Comissão (R$)</th>
                            <th style="width: 8%">Comissão (%)</th>
                            <th style="width: 8%">Ação</th>
                        </tr>
                    </thead>
                    <tbody id="purchaseRows">
                        <tr class="purchase-row">
                            <td>
                                <select name="purchases[0][animal_id]" class="form-select form-select-sm" required>
                                    <option value="">Selecione...</option>
                                    @foreach($animals as $animal)
                                        <option value="{{ $animal->id }}">{{ $animal->tag }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="purchases[0][vendor_id]" class="form-select form-select-sm">
                                    <option value="">Selecione...</option>
                                    @foreach($vendors as $vendor)
                                        <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="date" name="purchases[0][purchase_date]" class="form-control form-control-sm">
                            </td>
                            <td>
                                <input type="number" step="0.01" name="purchases[0][value]" class="form-control form-control-sm" placeholder="0.00" required>
                            </td>
                            <td>
                                <input type="number" step="0.01" name="purchases[0][freight_cost]" class="form-control form-control-sm" placeholder="0.00">
                            </td>
                            <td>
                                <input type="text" name="purchases[0][transporter]" class="form-control form-control-sm" placeholder="Nome">
                            </td>
                            <td>
                                <input type="number" step="0.01" name="purchases[0][commission_value]" class="form-control form-control-sm" placeholder="0.00">
                            </td>
                            <td>
                                <input type="number" step="0.01" max="100" name="purchases[0][commission_percent]" class="form-control form-control-sm" placeholder="0.00">
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
                    <i class="fas fa-save"></i> Salvar Todas as Compras
                </button>
                <a href="{{ route('purchases.index') }}" class="modern-btn modern-btn-secondary">
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
    let purchaseRowCount = 1;

    function addPurchaseRow() {
        const tbody = document.getElementById('purchaseRows');
        const newRow = document.createElement('tr');
        newRow.className = 'purchase-row';
        
        newRow.innerHTML = `
            <td>
                <select name="purchases[${purchaseRowCount}][animal_id]" class="form-select form-select-sm" required>
                    <option value="">Selecione...</option>
                    @foreach($animals as $animal)
                        <option value="{{ $animal->id }}">{{ $animal->tag }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <select name="purchases[${purchaseRowCount}][vendor_id]" class="form-select form-select-sm">
                    <option value="">Selecione...</option>
                    @foreach($vendors as $vendor)
                        <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="date" name="purchases[${purchaseRowCount}][purchase_date]" class="form-control form-control-sm">
            </td>
            <td>
                <input type="number" step="0.01" name="purchases[${purchaseRowCount}][value]" class="form-control form-control-sm" placeholder="0.00" required>
            </td>
            <td>
                <input type="number" step="0.01" name="purchases[${purchaseRowCount}][freight_cost]" class="form-control form-control-sm" placeholder="0.00">
            </td>
            <td>
                <input type="text" name="purchases[${purchaseRowCount}][transporter]" class="form-control form-control-sm" placeholder="Nome">
            </td>
            <td>
                <input type="number" step="0.01" name="purchases[${purchaseRowCount}][commission_value]" class="form-control form-control-sm" placeholder="0.00">
            </td>
            <td>
                <input type="number" step="0.01" max="100" name="purchases[${purchaseRowCount}][commission_percent]" class="form-control form-control-sm" placeholder="0.00">
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        
        tbody.appendChild(newRow);
        purchaseRowCount++;
        updatePurchaseCount();
    }

    function removeRow(button) {
        const rows = document.querySelectorAll('.purchase-row');
        if (rows.length > 1) {
            button.closest('tr').remove();
            updatePurchaseCount();
            reindexRows();
        } else {
            alert('Deve haver pelo menos uma compra para registrar.');
        }
    }

    function removeLastRow() {
        const rows = document.querySelectorAll('.purchase-row');
        if (rows.length > 1) {
            rows[rows.length - 1].remove();
            updatePurchaseCount();
            reindexRows();
        } else {
            alert('Deve haver pelo menos uma compra para registrar.');
        }
    }

    function updatePurchaseCount() {
        const count = document.querySelectorAll('.purchase-row').length;
        document.getElementById('purchaseCount').textContent = count;
    }

    function reindexRows() {
        const rows = document.querySelectorAll('.purchase-row');
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
        purchaseRowCount = rows.length;
    }

    function setPurchaseQuantity() {
        const quantity = parseInt(document.getElementById('purchaseQuantity').value);
        const currentRows = document.querySelectorAll('.purchase-row').length;
        
        if (quantity < 1 || quantity > 50) {
            alert('A quantidade deve estar entre 1 e 50 compras.');
            return;
        }
        
        if (quantity > currentRows) {
            // Adicionar linhas
            const toAdd = quantity - currentRows;
            for (let i = 0; i < toAdd; i++) {
                addPurchaseRow();
            }
        } else if (quantity < currentRows) {
            // Remover linhas
            const toRemove = currentRows - quantity;
            const rows = document.querySelectorAll('.purchase-row');
            for (let i = 0; i < toRemove; i++) {
                if (rows.length > 1) {
                    rows[rows.length - 1 - i].remove();
                }
            }
            updatePurchaseCount();
            reindexRows();
        }
    }

    // Focar no primeiro campo ao carregar a página
    document.addEventListener('DOMContentLoaded', function() {
        const firstSelect = document.querySelector('select[name="purchases[0][animal_id]"]');
        if (firstSelect) {
            firstSelect.focus();
        }
    });
</script>
@endsection