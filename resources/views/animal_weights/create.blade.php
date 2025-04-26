@extends('layouts.app')
@section('title', 'Nova Pesagem')
@section('content')
    <div class="container">
        <h2>Nova Pesagem</h2>
        <form action="{{ route('animal-weights.store') }}" method="POST">
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
                <label>Peso (kg)</label>
                <input type="number" name="weight" step="0.01" class="form-control">
            </div>
            <div class="mb-3">
                <label>Data</label>
                <input type="date" name="recorded_at" class="form-control">
            </div>
            <button class="btn btn-success">Salvar</button>
        </form>
    </div>
@endsection
