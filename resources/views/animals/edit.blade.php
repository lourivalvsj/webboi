@extends('layouts.app')

@section('title', 'Editar Animal')
@section('content')
    <div class="container">
        <h2>Editar Animal</h2>

        <form action="{{ route('animals.update', $animal) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Brinco</label>
                <input type="text" name="tag" value="{{ $animal->tag }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Raça</label>
                <input type="text" name="breed" value="{{ $animal->breed }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Data de Nascimento</label>
                <input type="date" name="birth_date" value="{{ $animal->birth_date }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Peso Inicial (kg)</label>
                <input type="number" step="0.01" name="initial_weight" value="{{ $animal->initial_weight }}"
                    class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Categoria</label>
                <select name="category_id" class="form-select">
                    <option value="">Selecione uma categoria</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $animal->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('animals.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
