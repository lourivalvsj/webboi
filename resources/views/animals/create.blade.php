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

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Gênero *</label>
                        <select name="gender" class="form-control" required>
                            <option value="">Selecione o gênero</option>
                            <option value="macho">Macho</option>
                            <option value="femea">Fêmea</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <div class="form-check mt-4">
                            <input type="hidden" name="is_breeder" value="0">
                            <input type="checkbox" name="is_breeder" value="1" class="form-check-input" id="is_breeder">
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
