@extends('layouts.app')

@section('title', 'Nova Despesa Operacional')
@section('content')
    <div class="container">
        <h2>Nova Despesa Operacional</h2>
        <form action="{{ route('operational-expenses.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="local_id" class="form-label">Local</label>
                <select name="local_id" class="form-select" required>
                    <option value="">Selecione</option>
                    @foreach ($locals as $local)
                        <option value="{{ $local->id }}">{{ $local->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Nome da Despesa</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="value" class="form-label">Valor (R$)</label>
                <input type="number" step="0.01" name="value" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Data</label>
                <input type="date" name="date" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ route('operational-expenses.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
