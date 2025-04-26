@extends('layouts.app')

@section('title', 'Editar UF')
@section('content')
    <div class="container">
        <h2>Editar UF</h2>
        <form action="{{ route('ufs.update', $uf) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" name="name" value="{{ $uf->name }}" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="abbreviation" class="form-label">Sigla</label>
                <input type="text" name="abbreviation" maxlength="2" value="{{ $uf->abbreviation }}"
                    class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('ufs.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
