@extends('layouts.app')

@section('title', 'Gastos com Insumos')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Gastos com Insumos</h2>
            <a href="{{ route('supply-expenses.create') }}" class="btn btn-primary">Novo</a>
        </div>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Animal</th>
                    <th>Gasto</th>
                    <th>Data</th>
                    <th>Valor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($expenses as $item)
                    <tr>
                        <td>{{ $item->animal->tag ?? '-' }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->purchase_date }}</td>
                        <td>R$ {{ number_format($item->value, 2, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('supply-expenses.edit', $item) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('supply-expenses.destroy', $item) }}" method="POST"
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
