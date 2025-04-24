@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Vendas</h2>
            <a href="{{ route('sales.create') }}" class="btn btn-primary">Adicionar Nova</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Animal</th>
                    <th>Comprador</th>
                    <th>Data</th>
                    <th>Valor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($sales as $sale)
                    <tr>
                        <td>{{ $sale->id }}</td>
                        <td>{{ $sale->animal->tag ?? '-' }}</td>
                        <td>{{ $sale->buyer->name ?? '-' }}</td>
                        <td>{{ $sale->sale_date }}</td>
                        <td>R$ {{ number_format($sale->value, 2, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('sales.edit', $sale) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Deseja excluir esta venda?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Nenhuma venda registrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
