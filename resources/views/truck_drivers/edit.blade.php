@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Editar Caminhoneiro</h2>
        <form action="{{ route('truck-drivers.update', $truckDriver) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" name="name" value="{{ $truckDriver->name }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="truck_description" class="form-label">Descrição do Caminhão</label>
                <input type="text" name="truck_description" value="{{ $truckDriver->truck_description }}"
                    class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('truck-drivers.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
