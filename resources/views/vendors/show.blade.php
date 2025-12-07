@extends('layouts.app')

@section('title', 'Visualizar Vendedor')
@section('content')
<div class="container-fluid fade-in-up">
    <div class="page-header-modern">
        <div class="d-flex justify-content-between align-items-center">
            <h2><i class="fas fa-user-tie me-2"></i>Detalhes do Vendedor</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('vendors.edit', $vendor) }}" class="modern-btn modern-btn-warning">
                    <i class="fas fa-edit"></i>
                    Editar
                </a>
                <a href="{{ route('vendors.index') }}" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Voltar
                </a>
            </div>
        </div>
    </div>

    <div class="modern-form-container">
        <div class="row">
            <div class="col-md-6">
                <div class="modern-form-group">
                    <label class="modern-form-label">Nome</label>
                    <div class="modern-form-control" style="background: #f8f9fa; border-color: #e9ecef;">
                        {{ $vendor->name }}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="modern-form-group">
                    <label class="modern-form-label">CPF/CNPJ</label>
                    <div class="modern-form-control" style="background: #f8f9fa; border-color: #e9ecef;">
                        {{ $vendor->cpf_cnpj ?: 'Não informado' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="modern-form-group">
                    <label class="modern-form-label">Email</label>
                    <div class="modern-form-control" style="background: #f8f9fa; border-color: #e9ecef;">
                        {{ $vendor->email ?: 'Não informado' }}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="modern-form-group">
                    <label class="modern-form-label">Telefone</label>
                    <div class="modern-form-control" style="background: #f8f9fa; border-color: #e9ecef;">
                        {{ $vendor->phone ?: 'Não informado' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="modern-form-group">
                    <label class="modern-form-label">UF</label>
                    <div class="modern-form-control" style="background: #f8f9fa; border-color: #e9ecef;">
                        {{ $vendor->uf ?: 'Não informado' }}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="modern-form-group">
                    <label class="modern-form-label">Cidade</label>
                    <div class="modern-form-control" style="background: #f8f9fa; border-color: #e9ecef;">
                        {{ $vendor->city ?: 'Não informado' }}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="modern-form-group">
                    <label class="modern-form-label">Inscrição Estadual</label>
                    <div class="modern-form-control" style="background: #f8f9fa; border-color: #e9ecef;">
                        {{ $vendor->state_registration ?: 'Não informado' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="modern-form-group">
                    <label class="modern-form-label">Endereço Completo</label>
                    <div class="modern-form-control" style="background: #f8f9fa; border-color: #e9ecef; min-height: 100px; white-space: pre-wrap;">{{ $vendor->address ?: 'Não informado' }}</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="modern-form-group">
                    <label class="modern-form-label">Data de Cadastro</label>
                    <div class="modern-form-control" style="background: #f8f9fa; border-color: #e9ecef;">
                        {{ $vendor->created_at ? $vendor->created_at->format('d/m/Y H:i') : 'Não informado' }}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="modern-form-group">
                    <label class="modern-form-label">Última Atualização</label>
                    <div class="modern-form-control" style="background: #f8f9fa; border-color: #e9ecef;">
                        {{ $vendor->updated_at ? $vendor->updated_at->format('d/m/Y H:i') : 'Não informado' }}
                    </div>
                </div>
            </div>
        </div>

        @if($vendor->purchases && $vendor->purchases->count() > 0)
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="modern-search-container">
                        <h5 class="text-primary mb-3"><i class="fas fa-shopping-bag me-2"></i>Histórico de Vendas</h5>
                        <div class="table-responsive">
                            <table class="table modern-table">
                                <thead>
                                    <tr>
                                        <th>Data</th>
                                        <th>Animal</th>
                                        <th>Valor</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($vendor->purchases as $purchase)
                                        <tr>
                                            <td>{{ $purchase->purchase_date ? \Carbon\Carbon::parse($purchase->purchase_date)->format('d/m/Y') : '-' }}</td>
                                            <td>{{ $purchase->animal->tag ?? '-' }}</td>
                                            <td>R$ {{ number_format($purchase->value, 2, ',', '.') }}</td>
                                            <td>Finalizada</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection