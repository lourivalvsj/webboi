@extends('layouts.app')

@section('title', 'Despesas Operacionais')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Despesas Operacionais</h2>
            <a href="{{ route('operational-expenses.create') }}" class="btn btn-primary">Novo</a>
        </div>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Local</th>
                    <th>Despesa</th>
                    <th>Data</th>
                    <th>Quantidade</th>
                    <th>Unidade</th>
                    <th>Valor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($expenses as $item)
                    <tr>
                        <td>{{ $item->local->name ?? '-' }}</td>
                        <td><strong>{{ $item->name }}</strong></td>
                        <td>{{ \Carbon\Carbon::parse($item->date)->format('d/m/Y') }}</td>
                        <td>{{ $item->quantity ? number_format($item->quantity, 3, ',', '.') : '-' }}</td>
                        <td>
                            @if ($item->unit_of_measure)
                                <span class="text-primary fw-bold">{{ $item->unit_of_measure }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>R$ {{ number_format($item->value, 2, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('operational-expenses.edit', $item) }}"
                                class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('operational-expenses.destroy', $item) }}" method="POST"
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
