@extends('layouts.app')
@section('title', 'Editar Pesagem')
@section('content')
    <div class="container">
        <h2>Editar Pesagem</h2>
        
        @if($animalWeight->animal && $animalWeight->animal->isSold())
            <div class="alert alert-warning mb-4" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Aviso:</strong> Este animal já foi vendido. Você pode visualizar e editar este registro histórico, mas não poderá alterar o animal para outro que também já foi vendido.
            </div>
        @endif
        
        <form action="{{ route('animal-weights.update', $animalWeight) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label>Animal</label>
                <select name="animal_id" class="form-control">
                    @foreach ($animals as $animal)
                        <option value="{{ $animal->id }}" {{ $animalWeight->animal_id == $animal->id ? 'selected' : '' }}>
                            {{ $animal->tag }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Peso (kg)</label>
                <input type="number" name="weight" step="0.01" value="{{ $animalWeight->weight }}" class="form-control">
            </div>
            <div class="mb-3">
                <label>Data</label>
                <input type="date" name="recorded_at" value="{{ $animalWeight->recorded_at }}" class="form-control">
            </div>
            <button class="btn btn-primary">Atualizar</button>
        </form>
    </div>
@endsection
