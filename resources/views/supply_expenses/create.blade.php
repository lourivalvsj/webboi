@extends('layouts.app')

@section('title', 'Novo Gasto com Insumo')
@section('content')
    <div class="container">
        <h2>Novo Gasto com Insumo</h2>
        <form action="{{ route('supply-expenses.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nome do Gasto</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descrição</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="purchase_date" class="form-label">Data da Compra</label>
                <input type="date" name="purchase_date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="value" class="form-label">Valor (R$)</label>
                <input type="number" step="0.01" name="value" class="form-control" required>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantidade</label>
                        <input type="number" step="0.001" name="quantity" class="form-control" placeholder="Ex: 25">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="unit_of_measure" class="form-label">Unidade de Medida</label>
                        <select name="unit_of_measure" class="form-select">
                            <option value="">Selecione a unidade</option>
                            <option value="kg">Quilograma (kg)</option>
                            <option value="g">Grama (g)</option>
                            <option value="t">Tonelada (t)</option>
                            <option value="l">Litro (l)</option>
                            <option value="ml">Mililitro (ml)</option>
                            <option value="m">Metro (m)</option>
                            <option value="cm">Centímetro (cm)</option>
                            <option value="unidade">Unidade</option>
                            <option value="pacote">Pacote</option>
                            <option value="saco">Saco</option>
                            <option value="caixa">Caixa</option>
                            <option value="outro">Outro</option>
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ route('supply-expenses.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
