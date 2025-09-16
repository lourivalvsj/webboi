@extends('layouts.app')

@section('title', 'Visualizar Comprador')
@section('content')
<div class="container-fluid fade-in-up">
    <div class="page-header-modern">
        <div class="d-flex justify-content-between align-items-center">
            <h2><i class="fas fa-user-check me-2"></i>Detalhes do Comprador</h2>
            <div class="d-flex gap-2">
                <a href="{{ route('buyers.edit', $buyer) }}" class="modern-btn modern-btn-warning">
                    <i class="fas fa-edit"></i>
                    Editar
                </a>
                <a href="{{ route('buyers.index') }}" class="modern-btn modern-btn-secondary">
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
                        {{ $buyer->name }}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="modern-form-group">
                    <label class="modern-form-label">CPF/CNPJ</label>
                    <div class="modern-form-control" style="background: #f8f9fa; border-color: #e9ecef;">
                        {{ $buyer->cpf_cnpj ?: 'Não informado' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="modern-form-group">
                    <label class="modern-form-label">Email</label>
                    <div class="modern-form-control" style="background: #f8f9fa; border-color: #e9ecef;">
                        {{ $buyer->email ?: 'Não informado' }}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="modern-form-group">
                    <label class="modern-form-label">Telefone</label>
                    <div class="modern-form-control" style="background: #f8f9fa; border-color: #e9ecef;">
                        {{ $buyer->phone ?: 'Não informado' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="modern-form-group">
                    <label class="modern-form-label">UF</label>
                    <div class="modern-form-control" style="background: #f8f9fa; border-color: #e9ecef;">
                        {{ $buyer->uf ?: 'Não informado' }}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="modern-form-group">
                    <label class="modern-form-label">Cidade</label>
                    <div class="modern-form-control" style="background: #f8f9fa; border-color: #e9ecef;">
                        {{ $buyer->city ?: 'Não informado' }}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="modern-form-group">
                    <label class="modern-form-label">Inscrição Estadual</label>
                    <div class="modern-form-control" style="background: #f8f9fa; border-color: #e9ecef;">
                        {{ $buyer->state_registration ?: 'Não informado' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="modern-form-group">
                    <label class="modern-form-label">Endereço Completo</label>
                    <div class="modern-form-control" style="background: #f8f9fa; border-color: #e9ecef; min-height: 100px; white-space: pre-wrap;">{{ $buyer->address ?: 'Não informado' }}</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="modern-form-group">
                    <label class="modern-form-label">Data de Cadastro</label>
                    <div class="modern-form-control" style="background: #f8f9fa; border-color: #e9ecef;">
                        {{ $buyer->created_at ? $buyer->created_at->format('d/m/Y H:i') : 'Não informado' }}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="modern-form-group">
                    <label class="modern-form-label">Última Atualização</label>
                    <div class="modern-form-control" style="background: #f8f9fa; border-color: #e9ecef;">
                        {{ $buyer->updated_at ? $buyer->updated_at->format('d/m/Y H:i') : 'Não informado' }}
                    </div>
                </div>
            </div>
        </div>

        @if($buyer->sales && $buyer->sales->count() > 0)
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="modern-search-container">
                        <h5 class="text-primary mb-3"><i class="fas fa-shopping-cart me-2"></i>Histórico de Compras</h5>
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
                                    @foreach($buyer->sales as $sale)
                                        <tr>
                                            <td>{{ $sale->sale_date ? \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y') : '-' }}</td>
                                            <td>{{ $sale->animal->tag ?? '-' }}</td>
                                            <td>R$ {{ number_format($sale->value, 2, ',', '.') }}</td>
                                            <td><span class="status-badge active">Finalizada</span></td>
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