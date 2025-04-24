@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Compras</h2>
            <a href="{{ route('purchases.create') }}" class="btn btn-primary">Adicionar Nova</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Animal</th>
                    <th>Vendedor</th>
                    <th>Data</th>
                    <th>Valor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($purchases as $purchase)
                    <tr>
                        <td>{{ $purchase->id }}</td>
                        <td>{{ $purchase->animal->tag ?? '-' }}</td>
                        <td>{{ $purchase->vendor->name ?? '-' }}</td>
                        <td>{{ $purchase->purchase_date }}</td>
                        <td>R$ {{ number_format($purchase->value, 2, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('purchases.edit', $purchase) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('purchases.destroy', $purchase) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Deseja excluir esta compra?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Nenhuma compra registrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
