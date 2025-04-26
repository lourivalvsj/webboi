@extends('layouts.app')

@section('title', 'Nova Categoria')
@section('content')
    <div class="container">
        <h2>Nova Categoria</h2>

        <form action="{{ route('categories.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nome da Categoria</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Tipo</label>
                <input type="text" name="type" id="type" class="form-control">
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descrição</label>
                <textarea name="description" id="description" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
