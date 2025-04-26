@extends('layouts.app')
@section('title', 'Nova Medicação')
@section('content')
    <div class="container">
        <h2>Nova Medicação</h2>
        <form action="{{ route('medications.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>Animal</label>
                <select name="animal_id" class="form-control">
                    @foreach ($animals as $animal)
                        <option value="{{ $animal->id }}">{{ $animal->tag }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label>Medicamento</label>
                <input type="text" name="medication_name" class="form-control">
            </div>
            <div class="mb-3">
                <label>Dosagem</label>
                <input type="text" name="dose" class="form-control">
            </div>
            <div class="mb-3">
                <label>Data</label>
                <input type="date" name="administration_date" class="form-control">
            </div>
            <button class="btn btn-success">Salvar</button>
        </form>
    </div>
@endsection
