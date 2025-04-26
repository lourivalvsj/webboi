@extends('layouts.app')

@section('title', 'Compradores')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Compradores</h2>
            <a href="{{ route('buyers.create') }}" class="btn btn-primary">Adicionar Novo</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>CPF/CNPJ</th>
                    <th>Telefone</th>
                    <th>Endereço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($buyers as $buyer)
                    <tr>
                        <td>{{ $buyer->id }}</td>
                        <td>{{ $buyer->name }}</td>
                        <td>{{ $buyer->cpf_cnpj }}</td>
                        <td>{{ $buyer->phone }}</td>
                        <td>{{ $buyer->address }}</td>
                        <td>
                            <a href="{{ route('buyers.edit', $buyer) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('buyers.destroy', $buyer) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Deseja excluir este comprador?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Nenhum comprador cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
