@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Fretes</h2>
            <a href="{{ route('freights.create') }}" class="btn btn-primary">Novo</a>
        </div>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Caminhoneiro</th>
                    <th>Local</th>
                    <th>Animais</th>
                    <th>Valor</th>
                    <th>Saída</th>
                    <th>Chegada</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($freights as $item)
                    <tr>
                        <td>{{ $item->truckDriver->name ?? '-' }}</td>
                        <td>{{ $item->local->name ?? '-' }}</td>
                        <td>{{ $item->quantity_animals }}</td>
                        <td>R$ {{ number_format($item->value, 2, ',', '.') }}</td>
                        <td>{{ $item->departure_date }}</td>
                        <td>{{ $item->arrival_date }}</td>
                        <td>
                            <a href="{{ route('freights.edit', $item) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('freights.destroy', $item) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Confirmar exclusão?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
