@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Novo Comprador</h2>

        <form action="{{ route('buyers.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">CPF/CNPJ</label>
                <input type="text" name="cpf_cnpj" class="form-control" oninput="mascaraCpfCnpj(this)" maxlength="18">
            </div>

            <div class="mb-3">
                <label class="form-label">Telefone</label>
                <input type="text" name="phone" class="form-control" oninput="mascaraTelefone(this)" maxlength="15">
            </div>

            <div class="mb-3">
                <label class="form-label">Endereço</label>
                <input type="text" name="address" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Salvar</button>
            <a href="{{ route('buyers.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
