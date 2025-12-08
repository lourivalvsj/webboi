@extends('layouts.app')

@section('title', 'Adicionar Múltiplos Animais')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Adicionar Múltiplos Animais</h2>
            <div>
                <a href="{{ route('animals.create') }}" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-plus-circle"></i> Animal Único
                </a>
                <a href="{{ route('animals.index') }}" class="modern-btn modern-btn-outline">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('animals.store-bulk') }}" method="POST" id="bulkAnimalForm">
                    @csrf
                    
                    <div class="mb-3">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center gap-2">
                                    <label class="form-label mb-0">Quantidade de animais:</label>
                                    <input type="number" id="animalQuantity" class="form-control" style="width: 80px;" min="1" max="50" value="1">
                                    <button type="button" class="modern-btn modern-btn-info" onclick="setAnimalQuantity()">
                                        <i class="fas fa-list"></i> Definir
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex gap-2">
                                    <button type="button" class="modern-btn modern-btn-success" onclick="addAnimalRow()">
                                        <i class="fas fa-plus"></i> Adicionar
                                    </button>
                                    <button type="button" class="modern-btn modern-btn-warning" onclick="removeLastRow()">
                                        <i class="fas fa-minus"></i> Remover
                                    </button>
                                    <span class="ms-3 text-muted">Total: <span id="animalCount">1</span></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 15%">Brinco <span class="text-danger">*</span></th>
                                    <th style="width: 15%">Raça</th>
                                    <th style="width: 10%">Gênero <span class="text-danger">*</span></th>
                                    <th style="width: 10%">Reprodutor</th>
                                    <th style="width: 15%">Data Nascimento</th>
                                    <th style="width: 10%">Peso Inicial (kg)</th>
                                    <th style="width: 15%">Categoria</th>
                                    <th style="width: 10%">Ação</th>
                                </tr>
                            </thead>
                            <tbody id="animalRows">
                                <tr class="animal-row">
                                    <td>
                                        <input type="text" name="animals[0][tag]" class="form-control form-control-sm" placeholder="Ex: 001" required>
                                    </td>
                                    <td>
                                        <input type="text" name="animals[0][breed]" class="form-control form-control-sm" placeholder="Ex: Nelore">
                                    </td>
                                    <td>
                                        <select name="animals[0][gender]" class="form-select form-select-sm" required>
                                            <option value="">Selecione</option>
                                            <option value="macho">Macho</option>
                                            <option value="femea">Fêmea</option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="form-check">
                                            <input type="hidden" name="animals[0][is_breeder]" value="0">
                                            <input type="checkbox" name="animals[0][is_breeder]" value="1" class="form-check-input">
                                        </div>
                                    </td>
                                    <td>
                                        <input type="date" name="animals[0][birth_date]" class="form-control form-control-sm">
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" name="animals[0][initial_weight]" class="form-control form-control-sm" placeholder="0.00">
                                    </td>
                                    <td>
                                        <select name="animals[0][category_id]" class="form-select form-select-sm">
                                            <option value="">Selecione...</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
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

                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            <button type="submit" class="modern-btn modern-btn-success">
                                <i class="fas fa-save"></i> Salvar Todos os Animais
                            </button>
                            <a href="{{ route('animals.index') }}" class="modern-btn modern-btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                        <div class="text-muted">
                            <small>* Campos obrigatórios</small>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let animalRowCount = 1;

        function addAnimalRow() {
            const tbody = document.getElementById('animalRows');
            const newRow = document.createElement('tr');
            newRow.className = 'animal-row';
            
            newRow.innerHTML = `
                <td>
                    <input type="text" name="animals[${animalRowCount}][tag]" class="form-control form-control-sm" placeholder="Ex: ${String(animalRowCount + 1).padStart(3, '0')}" required>
                </td>
                <td>
                    <input type="text" name="animals[${animalRowCount}][breed]" class="form-control form-control-sm" placeholder="Ex: Nelore">
                </td>
                <td>
                    <select name="animals[${animalRowCount}][gender]" class="form-select form-select-sm" required>
                        <option value="">Selecione</option>
                        <option value="macho">Macho</option>
                        <option value="femea">Fêmea</option>
                    </select>
                </td>
                <td>
                    <div class="form-check">
                        <input type="hidden" name="animals[${animalRowCount}][is_breeder]" value="0">
                        <input type="checkbox" name="animals[${animalRowCount}][is_breeder]" value="1" class="form-check-input">
                    </div>
                </td>
                <td>
                    <input type="date" name="animals[${animalRowCount}][birth_date]" class="form-control form-control-sm">
                </td>
                <td>
                    <input type="number" step="0.01" name="animals[${animalRowCount}][initial_weight]" class="form-control form-control-sm" placeholder="0.00">
                </td>
                <td>
                    <select name="animals[${animalRowCount}][category_id]" class="form-select form-select-sm">
                        <option value="">Selecione...</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeRow(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            `;
            
            tbody.appendChild(newRow);
            animalRowCount++;
            updateAnimalCount();
        }

        function removeRow(button) {
            const rows = document.querySelectorAll('.animal-row');
            if (rows.length > 1) {
                button.closest('tr').remove();
                updateAnimalCount();
                reindexRows();
            } else {
                alert('Deve haver pelo menos um animal para cadastrar.');
            }
        }

        function removeLastRow() {
            const rows = document.querySelectorAll('.animal-row');
            if (rows.length > 1) {
                rows[rows.length - 1].remove();
                updateAnimalCount();
                reindexRows();
            } else {
                alert('Deve haver pelo menos um animal para cadastrar.');
            }
        }

        function updateAnimalCount() {
            const count = document.querySelectorAll('.animal-row').length;
            document.getElementById('animalCount').textContent = count;
        }

        function reindexRows() {
            const rows = document.querySelectorAll('.animal-row');
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
            animalRowCount = rows.length;
        }

        function setAnimalQuantity() {
            const quantity = parseInt(document.getElementById('animalQuantity').value);
            const currentRows = document.querySelectorAll('.animal-row').length;
            
            if (quantity < 1 || quantity > 50) {
                alert('A quantidade deve estar entre 1 e 50 animais.');
                return;
            }
            
            if (quantity > currentRows) {
                // Adicionar linhas
                const toAdd = quantity - currentRows;
                for (let i = 0; i < toAdd; i++) {
                    addAnimalRow();
                }
            } else if (quantity < currentRows) {
                // Remover linhas
                const toRemove = currentRows - quantity;
                const rows = document.querySelectorAll('.animal-row');
                for (let i = 0; i < toRemove; i++) {
                    if (rows.length > 1) {
                        rows[rows.length - 1 - i].remove();
                    }
                }
                updateAnimalCount();
                reindexRows();
            }
        }

        // Focar no primeiro campo ao carregar a página
        document.addEventListener('DOMContentLoaded', function() {
            const firstInput = document.querySelector('input[name="animals[0][tag]"]');
            if (firstInput) {
                firstInput.focus();
            }
        });
    </script>
@endsection