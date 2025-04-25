@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Editar Frete</h2>
        <form action="{{ route('freights.update', $freight) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="truck_driver_id" class="form-label">Caminhoneiro</label>
                <select name="truck_driver_id" class="form-select" required>
                    @foreach ($truckDrivers as $driver)
                        <option value="{{ $driver->id }}" {{ $freight->truck_driver_id == $driver->id ? 'selected' : '' }}>
                            {{ $driver->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="local_id" class="form-label">Local</label>
                <select name="local_id" class="form-select" required>
                    @foreach ($locals as $local)
                        <option value="{{ $local->id }}" {{ $freight->local_id == $local->id ? 'selected' : '' }}>
                            {{ $local->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="quantity_animals" class="form-label">Quantidade de Animais</label>
                <input type="number" name="quantity_animals" value="{{ $freight->quantity_animals }}" class="form-control"
                    required>
            </div>

            <div class="mb-3">
                <label for="value" class="form-label">Valor do Frete (R$)</label>
                <input type="number" step="0.01" name="value" value="{{ $freight->value }}" class="form-control"
                    required>
            </div>

            <div class="mb-3">
                <label for="departure_date" class="form-label">Data de Saída</label>
                <input type="date" name="departure_date" value="{{ $freight->departure_date }}" class="form-control"
                    required>
            </div>

            <div class="mb-3">
                <label for="arrival_date" class="form-label">Data de Chegada</label>
                <input type="date" name="arrival_date" value="{{ $freight->arrival_date }}" class="form-control"
                    required>
            </div>

            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('freights.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
