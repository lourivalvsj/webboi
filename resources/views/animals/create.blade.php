@extends('layouts.app')

@section('title', 'Novo Animal')
@section('content')
    <div class="container">
        <h2>Novo Animal</h2>

        <form action="{{ route('animals.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Brinco</label>
                <input type="text" name="tag" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Raça</label>
                <input type="text" name="breed" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Data de Nascimento</label>
                <input type="date" name="birth_date" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Peso Inicial (kg)</label>
                <input type="number" step="0.01" name="initial_weight" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Categoria</label>
                <select name="category_id" class="form-select">
                    <option value="">Selecione uma categoria</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ route('animals.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
