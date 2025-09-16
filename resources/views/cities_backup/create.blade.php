@extends('layouts.app')

@section('title', 'Nova Cidade')
@section('content')
    <div class="container">
        <h2>Nova Cidade</h2>
        <form action="{{ route('cities.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nome da Cidade</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="uf_id" class="form-label">UF</label>
                <select name="uf_id" class="form-select" required>
                    <option value="">Selecione</option>
                    @foreach ($ufs as $uf)
                        <option value="{{ $uf->id }}">{{ $uf->abbreviation }} - {{ $uf->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ route('cities.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
