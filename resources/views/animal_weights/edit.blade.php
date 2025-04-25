@extends('layouts.app')
@section('content')
    <div class="container">
        <h2>Editar Pesagem</h2>
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
