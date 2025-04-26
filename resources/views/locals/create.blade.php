@extends('layouts.app')

@section('title', 'Novo Local')
@section('content')
    <div class="container">
        <h2>Novo Local</h2>
        <form action="{{ route('locals.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="entry_date" class="form-label">Data de Entrada</label>
                <input type="date" name="entry_date" class="form-control">
            </div>

            <div class="mb-3">
                <label for="exit_date" class="form-label">Data de Saída</label>
                <input type="date" name="exit_date" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ route('locals.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
