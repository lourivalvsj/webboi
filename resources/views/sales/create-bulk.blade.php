@extends('layouts.app')

@section('title', 'Adicionar Múltiplas Vendas')
@section('content')
<div class="container-fluid fade-in-up">
    <div class="page-header-modern">
        <div class="d-flex justify-content-between align-items-center">
            <h2><i class="fas fa-hand-holding-usd me-2"></i>Adicionar Múltiplas Vendas</h2>
            <div>
                <a href="{{ route('sales.create') }}" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-plus-circle"></i> Venda Única
                </a>
                <a href="{{ route('sales.index') }}" class="modern-btn modern-btn-outline">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </div>

    <div class="modern-form-container">
        <form action="{{ route('sales.store-bulk') }}" method="POST" id="bulkSaleForm">
            @csrf
            
            <div class="mb-4">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-2">
                            <label class="form-label mb-0">Quantidade de vendas:</label>
                            <input type="number" id="saleQuantity" class="form-control" style="width: 80px;" min="1" max="50" value="1">
                            <button type="button" class="modern-btn modern-btn-info" onclick="setSaleQuantity()">
                                <i class="fas fa-list"></i> Definir
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex gap-2">
                            <button type="button" class="modern-btn modern-btn-success" onclick="addSaleRow()">
                                <i class="fas fa-plus"></i> Adicionar
                            </button>
                            <button type="button" class="modern-btn modern-btn-warning" onclick="removeLastRow()">
                                <i class="fas fa-minus"></i> Remover
                            </button>
                            <span class="ms-3 text-muted">Total: <span id="saleCount">1</span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 30%">Animal <span class="text-danger">*</span></th>
                            <th style="width: 25%">Comprador</th>
                            <th style="width: 20%">Data da Venda</th>
                            <th style="width: 20%">Valor (R$) <span class="text-danger">*</span></th>
                            <th style="width: 5%">Ação</th>
                        </tr>
                    </thead>
                    <tbody id="saleRows">
                        <tr class="sale-row">
                            <td>
                                <select name="sales[0][animal_id]" class="form-select form-select-sm" required>
                                    <option value="">Selecione um animal...</option>
                                    @foreach($animals as $animal)
                                        <option value="{{ $animal->id }}">
                                            {{ $animal->tag }} 
                                            @if($animal->breed) - {{ $animal->breed }} @endif
                                            @if($animal->purchase) - Comprado: R$ {{ number_format($animal->purchase->value, 2, ',', '.') }} @endif
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="sales[0][buyer_id]" class="form-select form-select-sm">
                                    <option value="">Selecione um comprador...</option>
                                    @foreach($buyers as $buyer)
                                        <option value="{{ $buyer->id }}">{{ $buyer->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="date" name="sales[0][sale_date]" class="form-control form-control-sm">
                            </td>
                            <td>
                                <input type="number" step="0.01" name="sales[0][value]" class="form-control form-control-sm" placeholder="0.00" required>
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
                    <i class="fas fa-save"></i> Salvar Todas as Vendas
                </button>
                <a href="{{ route('sales.index') }}" class="modern-btn modern-btn-secondary">
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
    let saleRowCount = 1;

    function addSaleRow() {
        const tbody = document.getElementById('saleRows');
        const newRow = document.createElement('tr');
        newRow.className = 'sale-row';
        
        newRow.innerHTML = `
            <td>
                <select name="sales[${saleRowCount}][animal_id]" class="form-select form-select-sm" required>
                    <option value="">Selecione um animal...</option>
                    @foreach($animals as $animal)
                        <option value="{{ $animal->id }}">
                            {{ $animal->tag }} 
                            @if($animal->breed) - {{ $animal->breed }} @endif
                            @if($animal->purchase) - Comprado: R$ {{ number_format($animal->purchase->value, 2, ',', '.') }} @endif
                        </option>
                    @endforeach
                </select>
            </td>
            <td>
                <select name="sales[${saleRowCount}][buyer_id]" class="form-select form-select-sm">
                    <option value="">Selecione um comprador...</option>
                    @foreach($buyers as $buyer)
                        <option value="{{ $buyer->id }}">{{ $buyer->name }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="date" name="sales[${saleRowCount}][sale_date]" class="form-control form-control-sm">
            </td>
            <td>
                <input type="number" step="0.01" name="sales[${saleRowCount}][value]" class="form-control form-control-sm" placeholder="0.00" required>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        
        tbody.appendChild(newRow);
        saleRowCount++;
        updateSaleCount();
    }

    function removeRow(button) {
        const rows = document.querySelectorAll('.sale-row');
        if (rows.length > 1) {
            button.closest('tr').remove();
            updateSaleCount();
            reindexRows();
        } else {
            alert('Deve haver pelo menos uma venda para registrar.');
        }
    }

    function removeLastRow() {
        const rows = document.querySelectorAll('.sale-row');
        if (rows.length > 1) {
            rows[rows.length - 1].remove();
            updateSaleCount();
            reindexRows();
        } else {
            alert('Deve haver pelo menos uma venda para registrar.');
        }
    }

    function updateSaleCount() {
        const count = document.querySelectorAll('.sale-row').length;
        document.getElementById('saleCount').textContent = count;
    }

    function reindexRows() {
        const rows = document.querySelectorAll('.sale-row');
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
        saleRowCount = rows.length;
    }

    function setSaleQuantity() {
        const quantity = parseInt(document.getElementById('saleQuantity').value);
        const currentRows = document.querySelectorAll('.sale-row').length;
        
        if (quantity < 1 || quantity > 50) {
            alert('A quantidade deve estar entre 1 e 50 vendas.');
            return;
        }
        
        if (quantity > currentRows) {
            // Adicionar linhas
            const toAdd = quantity - currentRows;
            for (let i = 0; i < toAdd; i++) {
                addSaleRow();
            }
        } else if (quantity < currentRows) {
            // Remover linhas
            const toRemove = currentRows - quantity;
            const rows = document.querySelectorAll('.sale-row');
            for (let i = 0; i < toRemove; i++) {
                if (rows.length > 1) {
                    rows[rows.length - 1 - i].remove();
                }
            }
            updateSaleCount();
            reindexRows();
        }
    }

    // Focar no primeiro campo ao carregar a página
    document.addEventListener('DOMContentLoaded', function() {
        const firstSelect = document.querySelector('select[name="sales[0][animal_id]"]');
        if (firstSelect) {
            firstSelect.focus();
        }
    });
</script>
@endsection