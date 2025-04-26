@extends('layouts.app')

@section('title', 'Novo Caminhoneiro')
@section('content')
    <div class="container">
        <h2>Novo Caminhoneiro</h2>
        <form action="{{ route('truck-drivers.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="truck_description" class="form-label">Descrição do Caminhão</label>
                <input type="text" name="truck_description" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ route('truck-drivers.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
