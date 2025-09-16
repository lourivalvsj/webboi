@extends('layouts.app')

@section('title', 'Editar Cidade')
@section('content')
    <div class="container">
        <h2>Editar Cidade</h2>
        <form action="{{ route('cities.update', $city) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nome da Cidade</label>
                <input type="text" name="name" value="{{ $city->name }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="uf_id" class="form-label">UF</label>
                <select name="uf_id" class="form-select" required>
                    <option value="">Selecione</option>
                    @foreach ($ufs as $uf)
                        <option value="{{ $uf->id }}" {{ $city->uf_id == $uf->id ? 'selected' : '' }}>
                            {{ $uf->abbreviation }} - {{ $uf->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('cities.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
