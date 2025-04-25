@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Editar Local</h2>
        <form action="{{ route('locals.update', $local) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" name="name" value="{{ $local->name }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="entry_date" class="form-label">Data de Entrada</label>
                <input type="date" name="entry_date" value="{{ $local->entry_date }}" class="form-control">
            </div>

            <div class="mb-3">
                <label for="exit_date" class="form-label">Data de Saída</label>
                <input type="date" name="exit_date" value="{{ $local->exit_date }}" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('locals.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
