@extends('layouts.app')

@section('title', 'Novo Agendamento')
@section('content')
    <div class="container">
        <h2>Novo Agendamento</h2>
        <form action="{{ route('schedules.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="date" class="form-label">Data</label>
                <input type="date" name="date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="start_time" class="form-label">Hora de Início</label>
                <input type="time" name="start_time" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="end_time" class="form-label">Hora de Término</label>
                <input type="time" name="end_time" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Descrição</label>
                <input type="text" name="description" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ route('schedules.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
