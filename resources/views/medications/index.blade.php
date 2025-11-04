@extends('layouts.app')
@section('title', 'Medicações')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Medicações</h2>
            <a href="{{ route('medications.create') }}" class="btn btn-primary">Nova Medicação</a>
        </div>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Animal</th>
                    <th>Medicamento</th>
                    <th>Quantidade</th>
                    <th>Unidade</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($medications as $medication)
                    <tr>
                        <td>{{ $medication->animal->tag }}</td>
                        <td><strong>{{ $medication->medication_name }}</strong></td>
                        <td>{{ number_format($medication->dose, 3, ',', '.') }}</td>
                        <td>
                            @if ($medication->unit_of_measure)
                                <span class="text-primary fw-bold">{{ $medication->unit_of_measure }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($medication->administration_date)->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('medications.edit', $medication) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('medications.destroy', $medication) }}" method="POST"
                                style="display:inline-block">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
