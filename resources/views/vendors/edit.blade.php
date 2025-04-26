@extends('layouts.app')

@section('title', 'Editar Vendedor')
@section('content')
    <div class="container">
        <h2>Editar Vendedor</h2>

        <form action="{{ route('vendors.update', $vendor) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input type="text" name="name" value="{{ $vendor->name }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">CPF/CNPJ</label>
                <input type="text" name="cpf_cnpj" class="form-control" oninput="mascaraCpfCnpj(this)" maxlength="18">
            </div>

            <div class="mb-3">
                <label class="form-label">Telefone</label>
                <input type="text" name="phone" value="{{ $vendor->phone }}" class="form-control"
                    oninput="mascaraTelefone(this)" maxlength="15">
            </div>

            <div class="mb-3">
                <label class="form-label">Endereço</label>
                <input type="text" name="address" value="{{ $vendor->address }}" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('vendors.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
