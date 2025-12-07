@extends('layouts.app')
@section('title', 'Editar Medicação')
@section('content')
    <div class="container">
        <h2>Editar Medicação</h2>
        
        @if($medication->animal && $medication->animal->isSold())
            <div class="alert alert-warning mb-4" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Aviso:</strong> Este animal já foi vendido. Você pode visualizar e editar este registro histórico, mas não poderá alterar o animal para outro que também já foi vendido.
            </div>
        @endif
        
        <form action="{{ route('medications.update', $medication) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label>Animal</label>
                <select name="animal_id" class="form-control">
                    @foreach ($animals as $animal)
                        <option value="{{ $animal->id }}" {{ $medication->animal_id == $animal->id ? 'selected' : '' }}>
                            {{ $animal->tag }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Medicamento</label>
                @if($medicationNames->count() > 0)
                    <select name="medication_name" class="form-control" required>
                        <option value="">Selecione um medicamento</option>
                        @foreach ($medicationNames as $medicationName)
                            <option value="{{ $medicationName }}" {{ $medication->medication_name == $medicationName ? 'selected' : '' }}>
                                {{ $medicationName }}
                            </option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">
                        <i class="fas fa-info-circle me-1"></i>
                        Apenas produtos cadastrados em "Gastos com Insumos" aparecem aqui.
                    </small>
                @else
                    <select name="medication_name" class="form-control" disabled>
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
                        <input type="number" step="0.001" name="dose" value="{{ $medication->dose }}" class="form-control" required placeholder="Ex: 2.5">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label>Unidade de Medida</label>
                        <select name="unit_of_measure" class="form-control">
                            <option value="">Selecione a unidade</option>
                            <option value="ml" {{ $medication->unit_of_measure == 'ml' ? 'selected' : '' }}>Mililitro (ml)</option>
                            <option value="l" {{ $medication->unit_of_measure == 'l' ? 'selected' : '' }}>Litro (l)</option>
                            <option value="mg" {{ $medication->unit_of_measure == 'mg' ? 'selected' : '' }}>Miligrama (mg)</option>
                            <option value="g" {{ $medication->unit_of_measure == 'g' ? 'selected' : '' }}>Grama (g)</option>
                            <option value="kg" {{ $medication->unit_of_measure == 'kg' ? 'selected' : '' }}>Quilograma (kg)</option>
                            <option value="dose" {{ $medication->unit_of_measure == 'dose' ? 'selected' : '' }}>Dose</option>
                            <option value="comprimido" {{ $medication->unit_of_measure == 'comprimido' ? 'selected' : '' }}>Comprimido</option>
                            <option value="capsula" {{ $medication->unit_of_measure == 'capsula' ? 'selected' : '' }}>Cápsula</option>
                            <option value="ampola" {{ $medication->unit_of_measure == 'ampola' ? 'selected' : '' }}>Ampola</option>
                            <option value="frasco" {{ $medication->unit_of_measure == 'frasco' ? 'selected' : '' }}>Frasco</option>
                            <option value="aplicacao" {{ $medication->unit_of_measure == 'aplicacao' ? 'selected' : '' }}>Aplicação</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label>Data</label>
                <input type="date" name="administration_date" value="{{ $medication->administration_date }}"
                    class="form-control" required>
            </div>
            <button class="btn btn-primary">Atualizar</button>
        </form>
    </div>
@endsection
