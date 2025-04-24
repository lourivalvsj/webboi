@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Editar Comprador</h2>

        <form action="{{ route('buyers.update', $buyer) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input type="text" name="name" value="{{ $buyer->name }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">CPF/CNPJ</label>
                <input type="text" name="cpf_cnpj" value="{{ $buyer->cpf_cnpj }}" class="form-control"
                    oninput="mascaraCpfCnpj(this)" maxlength="18">
            </div>

            <div class="mb-3">
                <label class="form-label">Telefone</label>
                <input type="text" name="phone" value="{{ $buyer->phone }}" class="form-control"
                    oninput="mascaraTelefone(this)" maxlength="15">
            </div>

            <div class="mb-3">
                <label class="form-label">Endereço</label>
                <input type="text" name="address" value="{{ $buyer->address }}" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Atualizar</button>
            <a href="{{ route('buyers.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
