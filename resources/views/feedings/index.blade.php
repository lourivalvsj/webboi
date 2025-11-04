@extends('layouts.app')
@section('title', 'Alimentações')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Alimentações</h2>
            <a href="{{ route('feedings.create') }}" class="btn btn-primary">Nova Alimentação</a>
        </div>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Animal</th>
                    <th>Tipo de Alimento</th>
                    <th>Quantidade</th>
                    <th>Unidade</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($feedings as $feeding)
                    <tr>
                        <td>{{ $feeding->animal->tag }}</td>
                        <td><strong>{{ $feeding->feed_type }}</strong></td>
                        <td>{{ number_format($feeding->quantity, 2, ',', '.') }}</td>
                        <td>
                            @if ($feeding->unit_of_measure)
                                <span class="text-primary fw-bold">{{ $feeding->unit_of_measure }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($feeding->feeding_date)->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('feedings.edit', $feeding) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('feedings.destroy', $feeding) }}" method="POST"
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
