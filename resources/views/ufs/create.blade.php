@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Nova UF</h2>
        <form action="{{ route('ufs.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="abbreviation" class="form-label">Sigla</label>
                <input type="text" name="abbreviation" class="form-control" maxlength="2" required>
            </div>

            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ route('ufs.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
