@extends('layouts.app')

@section('title', 'Detalhes da Venda')
@section('content')
<div class="container-fluid fade-in-up">
    <div class="page-header-modern">
        <h2><i class="fas fa-eye me-2"></i>Detalhes da Venda #{{ $sale->id }}</h2>
    </div>

    <div class="modern-form-container">
        <div class="row">
            <div class="col-md-6">
                <div class="modern-form-group">
                    <label class="modern-form-label">Animal</label>
                    <div class="form-control-static">
                        {{ $sale->animal->tag ?? 'N/A' }} - {{ $sale->animal->name ?? 'Sem nome' }}
                        @if($sale->animal->breed)
                            <small class="text-muted d-block">Raça: {{ $sale->animal->breed }}</small>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="modern-form-group">
                    <label class="modern-form-label">Comprador</label>
                    <div class="form-control-static">
                        {{ $sale->buyer->name ?? 'Não informado' }}
                        @if($sale->buyer && $sale->buyer->phone)
                            <small class="text-muted d-block">Telefone: {{ $sale->buyer->phone }}</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="modern-form-group">
                    <label class="modern-form-label">Data da Venda</label>
                    <div class="form-control-static">
                        {{ $sale->sale_date ? \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y') : 'Não informado' }}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="modern-form-group">
                    <label class="modern-form-label">Valor da Venda</label>
                    <div class="form-control-static text-success fw-bold">
                        R$ {{ number_format($sale->value, 2, ',', '.') }}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="modern-form-group">
                    <label class="modern-form-label">Peso na Venda</label>
                    <div class="form-control-static">
                        {{ $sale->weight_at_sale ? number_format($sale->weight_at_sale, 2, ',', '.') . ' kg' : 'Não informado' }}
                    </div>
                </div>
            </div>
        </div>

        @if($sale->animal && $sale->animal->purchase)
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <h5><i class="fas fa-info-circle me-2"></i>Informações da Compra Original</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Data da Compra:</strong><br>
                            {{ $sale->animal->purchase->purchase_date ? \Carbon\Carbon::parse($sale->animal->purchase->purchase_date)->format('d/m/Y') : 'N/A' }}
                        </div>
                        <div class="col-md-3">
                            <strong>Valor de Compra:</strong><br>
                            R$ {{ number_format($sale->animal->purchase->value ?? 0, 2, ',', '.') }}
                        </div>
                        <div class="col-md-3">
                            <strong>Vendedor Original:</strong><br>
                            {{ $sale->animal->purchase->vendor->name ?? 'N/A' }}
                        </div>
                        <div class="col-md-3">
                            <strong>Lucro/Prejuízo:</strong><br>
                            @php
                                $profit = $sale->value - ($sale->animal->purchase->value ?? 0);
                                $profitClass = $profit >= 0 ? 'text-success' : 'text-danger';
                            @endphp
                            <span class="{{ $profitClass }} fw-bold">
                                R$ {{ number_format($profit, 2, ',', '.') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @php
            $purchaseValue = $sale->animal->purchase->value ?? 0;
            $saleValue = $sale->value;
            $profit = $saleValue - $purchaseValue;
            $profitPercent = $purchaseValue > 0 ? (($profit / $purchaseValue) * 100) : 0;
        @endphp

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="alert alert-{{ $profit >= 0 ? 'success' : 'danger' }}">
                    <h5><i class="fas fa-calculator me-2"></i>Resumo Financeiro</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Valor de Compra:</strong><br>
                            R$ {{ number_format($purchaseValue, 2, ',', '.') }}
                        </div>
                        <div class="col-md-3">
                            <strong>Valor de Venda:</strong><br>
                            R$ {{ number_format($saleValue, 2, ',', '.') }}
                        </div>
                        <div class="col-md-3">
                            <strong>{{ $profit >= 0 ? 'Lucro' : 'Prejuízo' }}:</strong><br>
                            <span class="fw-bold fs-5">R$ {{ number_format(abs($profit), 2, ',', '.') }}</span>
                        </div>
                        <div class="col-md-3">
                            <strong>Margem:</strong><br>
                            <span class="fw-bold">{{ number_format($profitPercent, 2, ',', '.') }}%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <small class="text-muted">
                    <i class="fas fa-clock me-1"></i>
                    Criado em: {{ $sale->created_at->format('d/m/Y H:i') }}
                    @if($sale->updated_at != $sale->created_at)
                        | Atualizado em: {{ $sale->updated_at->format('d/m/Y H:i') }}
                    @endif
                </small>
            </div>
        </div>

        <div class="modern-form-actions">
            <a href="{{ route('sales.edit', $sale) }}" class="modern-btn modern-btn-warning">
                <i class="fas fa-edit"></i>
                Editar Venda
            </a>
            <a href="{{ route('sales.index') }}" class="modern-btn modern-btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Voltar
            </a>
            @if($sale->animal && $sale->animal->purchase)
            <a href="{{ route('purchases.show', $sale->animal->purchase) }}" class="modern-btn modern-btn-info">
                <i class="fas fa-shopping-cart"></i>
                Ver Compra Original
            </a>
            @endif
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