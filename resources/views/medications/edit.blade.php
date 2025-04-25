@extends('layouts.app')
@section('content')
    <div class="container">
        <h2>Editar Medicação</h2>
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
                <input type="text" name="medication_name" value="{{ $medication->medication_name }}" class="form-control">
            </div>
            <div class="mb-3">
                <label>Dosagem</label>
                <input type="text" name="dose" value="{{ $medication->dose }}" class="form-control">
            </div>
            <div class="mb-3">
                <label>Data</label>
                <input type="date" name="administration_date" value="{{ $medication->administration_date }}"
                    class="form-control">
            </div>
            <button class="btn btn-primary">Atualizar</button>
        </form>
    </div>
@endsection
