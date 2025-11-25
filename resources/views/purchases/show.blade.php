@extends('layouts.app')

@section('title', 'Detalhes da Compra')
@section('content')
<div class="container-fluid fade-in-up">
    <div class="page-header-modern">
        <h2><i class="fas fa-eye me-2"></i>Detalhes da Compra #{{ $purchase->id }}</h2>
    </div>

    <div class="modern-form-container">
        <div class="row">
            <div class="col-md-6">
                <div class="modern-form-group">
                    <label class="modern-form-label">Animal</label>
                    <div class="form-control-static">
                        {{ $purchase->animal->tag ?? 'N/A' }} - {{ $purchase->animal->name ?? 'Sem nome' }}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="modern-form-group">
                    <label class="modern-form-label">Vendedor</label>
                    <div class="form-control-static">
                        {{ $purchase->vendor->name ?? 'Não informado' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="modern-form-group">
                    <label class="modern-form-label">Data da Compra</label>
                    <div class="form-control-static">
                        {{ $purchase->purchase_date ? \Carbon\Carbon::parse($purchase->purchase_date)->format('d/m/Y') : 'Não informado' }}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="modern-form-group">
                    <label class="modern-form-label">Valor da Compra</label>
                    <div class="form-control-static text-success fw-bold">
                        R$ {{ number_format($purchase->value, 2, ',', '.') }}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="modern-form-group">
                    <label class="modern-form-label">Custo do Frete</label>
                    <div class="form-control-static">
                        {{ $purchase->freight_cost ? 'R$ ' . number_format($purchase->freight_cost, 2, ',', '.') : 'Não informado' }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="modern-form-group">
                    <label class="modern-form-label">Transportador</label>
                    <div class="form-control-static">
                        {{ $purchase->transporter ?? 'Não informado' }}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="modern-form-group">
                    <label class="modern-form-label">Valor da Comissão</label>
                    <div class="form-control-static">
                        {{ $purchase->commission_value ? 'R$ ' . number_format($purchase->commission_value, 2, ',', '.') : 'Não informado' }}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="modern-form-group">
                    <label class="modern-form-label">Percentual da Comissão</label>
                    <div class="form-control-static">
                        {{ $purchase->commission_percent ? number_format($purchase->commission_percent, 2, ',', '.') . '%' : 'Não informado' }}
                    </div>
                </div>
            </div>
        </div>

        @php
            $totalCost = $purchase->value + ($purchase->freight_cost ?? 0) + ($purchase->commission_value ?? 0);
        @endphp

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <h5><i class="fas fa-calculator me-2"></i>Resumo Financeiro</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Valor Base:</strong><br>
                            R$ {{ number_format($purchase->value, 2, ',', '.') }}
                        </div>
                        <div class="col-md-3">
                            <strong>Frete:</strong><br>
                            R$ {{ number_format($purchase->freight_cost ?? 0, 2, ',', '.') }}
                        </div>
                        <div class="col-md-3">
                            <strong>Comissão:</strong><br>
                            R$ {{ number_format($purchase->commission_value ?? 0, 2, ',', '.') }}
                        </div>
                        <div class="col-md-3">
                            <strong>Total Geral:</strong><br>
                            <span class="text-primary fw-bold fs-5">R$ {{ number_format($totalCost, 2, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <small class="text-muted">
                    <i class="fas fa-clock me-1"></i>
                    Criado em: {{ $purchase->created_at->format('d/m/Y H:i') }}
                    @if($purchase->updated_at != $purchase->created_at)
                        | Atualizado em: {{ $purchase->updated_at->format('d/m/Y H:i') }}
                    @endif
                </small>
            </div>
        </div>

        <div class="modern-form-actions">
            <a href="{{ route('purchases.edit', $purchase) }}" class="modern-btn modern-btn-warning">
                <i class="fas fa-edit"></i>
                Editar Compra
            </a>
            <a href="{{ route('purchases.index') }}" class="modern-btn modern-btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Voltar
            </a>
        </div>
    </div>
</div>

<style>
.form-control-static {
    padding: 0.75rem;
    background-color: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    min-height: 48px;
    display: flex;
    align-items: center;
}
</style>
@endsection