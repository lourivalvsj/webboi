@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Novo Frete</h2>
        <form action="{{ route('freights.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="truck_driver_id" class="form-label">Caminhoneiro</label>
                <select name="truck_driver_id" class="form-select" required>
                    <option value="">Selecione</option>
                    @foreach ($truckDrivers as $driver)
                        <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                    @endforeach
                </select>
            </div>

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
                <label for="quantity_animals" class="form-label">Quantidade de Animais</label>
                <input type="number" name="quantity_animals" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="value" class="form-label">Valor do Frete (R$)</label>
                <input type="number" step="0.01" name="value" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="departure_date" class="form-label">Data de Saída</label>
                <input type="date" name="departure_date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="arrival_date" class="form-label">Data de Chegada</label>
                <input type="date" name="arrival_date" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ route('freights.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
