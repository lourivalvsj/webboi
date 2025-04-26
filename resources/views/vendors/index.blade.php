@extends('layouts.app')

@section('title', 'Vendedores')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Vendedores</h2>
            <a href="{{ route('vendors.create') }}" class="btn btn-primary">Adicionar Novo</a>
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
                @forelse($vendors as $vendor)
                    <tr>
                        <td>{{ $vendor->id }}</td>
                        <td>{{ $vendor->name }}</td>
                        <td>{{ $vendor->cpf_cnpj }}</td>
                        <td>{{ $vendor->phone }}</td>
                        <td>{{ $vendor->address }}</td>
                        <td>
                            <a href="{{ route('vendors.edit', $vendor) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('vendors.destroy', $vendor) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Deseja excluir este vendedor?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Nenhum vendedor cadastrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
