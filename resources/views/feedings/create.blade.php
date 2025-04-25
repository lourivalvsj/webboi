@extends('layouts.app')
@section('content')
    <div class="container">
        <h2>Nova Alimentação</h2>
        <form action="{{ route('feedings.store') }}" method="POST">
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
                <label>Tipo de Alimento</label>
                <input type="text" name="feed_type" class="form-control">
            </div>
            <div class="mb-3">
                <label>Quantidade</label>
                <input type="number" name="quantity" step="0.01" class="form-control">
            </div>
            <div class="mb-3">
                <label>Data</label>
                <input type="date" name="feeding_date" class="form-control">
            </div>
            <button class="btn btn-success">Salvar</button>
        </form>
    </div>
@endsection
