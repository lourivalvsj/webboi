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

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Gênero *</label>
                        <select name="gender" class="form-control" required>
                            <option value="">Selecione o gênero</option>
                            <option value="macho" {{ $animal->gender === 'macho' ? 'selected' : '' }}>Macho</option>
                            <option value="femea" {{ $animal->gender === 'femea' ? 'selected' : '' }}>Fêmea</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <div class="form-check mt-4">
                            <input type="hidden" name="is_breeder" value="0">
                            <input type="checkbox" name="is_breeder" value="1" class="form-check-input" id="is_breeder" {{ $animal->is_breeder ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_breeder">
                                <strong>Reprodutor/Matriz</strong>
                                <small class="text-muted d-block">Animal destinado à reprodução</small>
                            </label>
                        </div>
                    </div>
                </div>
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
