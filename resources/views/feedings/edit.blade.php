@extends('layouts.app')
@section('title', 'Editar Alimentação')
@section('content')
    <div class="container">
        <h2>Editar Alimentação</h2>
        
        @if($feeding->animal && $feeding->animal->isSold())
            <div class="alert alert-warning mb-4" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Aviso:</strong> Este animal já foi vendido. Você pode visualizar e editar este registro histórico, mas não poderá alterar o animal para outro que também já foi vendido.
            </div>
        @endif
        
        <form action="{{ route('feedings.update', $feeding) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label>Animal</label>
                <select name="animal_id" class="form-control">
                    @foreach ($animals as $animal)
                        <option value="{{ $animal->id }}" {{ $feeding->animal_id == $animal->id ? 'selected' : '' }}>
                            {{ $animal->tag }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Tipo de Alimento</label>
                @if($feedTypes->count() > 0)
                    <select name="feed_type" class="form-control" required>
                        <option value="">Selecione um alimento</option>
                        @foreach ($feedTypes as $feedType)
                            <option value="{{ $feedType }}" {{ $feeding->feed_type == $feedType ? 'selected' : '' }}>
                                {{ $feedType }}
                            </option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Apenas produtos cadastrados em "Gastos com Insumos" aparecem aqui.
                    </small>
                @else
                    <select name="feed_type" class="form-control" disabled>
                        <option value="">Nenhum produto cadastrado</option>
                    </select>
                    <small class="form-text text-warning">
                        <i class="fas fa-exclamation-triangle me-1"></i>
                        É necessário cadastrar produtos em <a href="{{ route('supply-expenses.create') }}">Gastos com Insumos</a> primeiro.
                    </small>
                @endif
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label>Quantidade</label>
                        <input type="number" name="quantity" step="0.01" value="{{ $feeding->quantity }}" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label>Unidade de Medida</label>
                        <select name="unit_of_measure" class="form-control">
                            <option value="">Selecione a unidade</option>
                            <option value="kg" {{ $feeding->unit_of_measure == 'kg' ? 'selected' : '' }}>Quilograma (kg)</option>
                            <option value="g" {{ $feeding->unit_of_measure == 'g' ? 'selected' : '' }}>Grama (g)</option>
                            <option value="t" {{ $feeding->unit_of_measure == 't' ? 'selected' : '' }}>Tonelada (t)</option>
                            <option value="l" {{ $feeding->unit_of_measure == 'l' ? 'selected' : '' }}>Litro (l)</option>
                            <option value="ml" {{ $feeding->unit_of_measure == 'ml' ? 'selected' : '' }}>Mililitro (ml)</option>
                            <option value="balde" {{ $feeding->unit_of_measure == 'balde' ? 'selected' : '' }}>Balde</option>
                            <option value="saco" {{ $feeding->unit_of_measure == 'saco' ? 'selected' : '' }}>Saco</option>
                            <option value="fardo" {{ $feeding->unit_of_measure == 'fardo' ? 'selected' : '' }}>Fardo</option>
                            <option value="unidade" {{ $feeding->unit_of_measure == 'unidade' ? 'selected' : '' }}>Unidade</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label>Data</label>
                <input type="date" name="feeding_date" value="{{ $feeding->feeding_date }}" class="form-control" required>
            </div>
            <button class="btn btn-primary">Atualizar</button>
        </form>
    </div>
@endsection
