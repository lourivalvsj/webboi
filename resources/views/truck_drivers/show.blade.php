@extends('layouts.app')

@section('title', 'Detalhes do Caminhoneiro')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-user me-2"></i>Detalhes do Caminhoneiro</h4>
                    <div class="btn-group">
                        <a href="{{ route('truck-drivers.edit', $truckDriver) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit me-2"></i>Editar
                        </a>
                        <a href="{{ route('truck-drivers.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-2"></i>Voltar
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- Dados Pessoais -->
                    <div class="section-header">
                        <h5 class="text-info mb-3"><i class="fas fa-user me-2"></i>Dados Pessoais</h5>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">Nome Completo:</label>
                                <div class="info-value">{{ $truckDriver->name }}</div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="info-item">
                                <label class="info-label">CPF:</label>
                                <div class="info-value">
                                    @if($truckDriver->cpf)
                                        <span class="badge bg-light text-dark">{{ $truckDriver->formatted_cpf }}</span>
                                    @else
                                        <span class="text-muted">Não informado</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="info-item">
                                <label class="info-label">CNH:</label>
                                <div class="info-value">{{ $truckDriver->cnh ?? 'Não informado' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">Telefone:</label>
                                <div class="info-value">
                                    @if($truckDriver->phone)
                                        <a href="tel:{{ $truckDriver->phone }}" class="text-decoration-none">
                                            <i class="fas fa-phone me-1"></i>{{ $truckDriver->formatted_phone }}
                                        </a>
                                    @else
                                        <span class="text-muted">Não informado</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">E-mail:</label>
                                <div class="info-value">
                                    @if($truckDriver->email)
                                        <a href="mailto:{{ $truckDriver->email }}" class="text-decoration-none">
                                            <i class="fas fa-envelope me-1"></i>{{ $truckDriver->email }}
                                        </a>
                                    @else
                                        <span class="text-muted">Não informado</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Endereço -->
                    <div class="section-header">
                        <h5 class="text-info mb-3"><i class="fas fa-map-marker-alt me-2"></i>Endereço</h5>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="info-item">
                                <label class="info-label">Endereço:</label>
                                <div class="info-value">{{ $truckDriver->address ?? 'Não informado' }}</div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="info-item">
                                <label class="info-label">CEP:</label>
                                <div class="info-value">{{ $truckDriver->zip_code ?? 'Não informado' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="info-item">
                                <label class="info-label">Cidade:</label>
                                <div class="info-value">{{ $truckDriver->city ?? 'Não informado' }}</div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="info-item">
                                <label class="info-label">Estado:</label>
                                <div class="info-value">{{ $truckDriver->state ?? 'Não informado' }}</div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Dados do Caminhão -->
                    <div class="section-header">
                        <h5 class="text-info mb-3"><i class="fas fa-truck me-2"></i>Dados do Caminhão</h5>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="info-item">
                                <label class="info-label">Placa:</label>
                                <div class="info-value">
                                    @if($truckDriver->truck_plate)
                                        <span class="badge bg-secondary">{{ $truckDriver->truck_plate }}</span>
                                    @else
                                        <span class="text-muted">Não informado</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="info-item">
                                <label class="info-label">Modelo:</label>
                                <div class="info-value">{{ $truckDriver->truck_model ?? 'Não informado' }}</div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="info-item">
                                <label class="info-label">Ano:</label>
                                <div class="info-value">{{ $truckDriver->truck_year ?? 'Não informado' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">Capacidade de Carga:</label>
                                <div class="info-value">
                                    @if($truckDriver->truck_capacity)
                                        <span class="fw-bold text-success">{{ number_format($truckDriver->truck_capacity, 2) }} toneladas</span>
                                    @else
                                        <span class="text-muted">Não informado</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="info-label">Descrição:</label>
                                <div class="info-value">{{ $truckDriver->truck_description ?? 'Não informado' }}</div>
                            </div>
                        </div>
                    </div>

                    @if($truckDriver->observations)
                        <hr class="my-4">
                        
                        <!-- Observações -->
                        <div class="section-header">
                            <h5 class="text-info mb-3"><i class="fas fa-sticky-note me-2"></i>Observações</h5>
                        </div>

                        <div class="alert alert-light border">
                            <p class="mb-0">{{ $truckDriver->observations }}</p>
                        </div>
                    @endif

                    <hr class="my-4">

                    <!-- Estatísticas -->
                    <div class="section-header">
                        <h5 class="text-info mb-3"><i class="fas fa-chart-bar me-2"></i>Estatísticas</h5>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="stat-card bg-primary text-white">
                                <div class="stat-icon">
                                    <i class="fas fa-shipping-fast"></i>
                                </div>
                                <div class="stat-info">
                                    <div class="stat-number">{{ $truckDriver->freights->count() }}</div>
                                    <div class="stat-label">Fretes Realizados</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="stat-card bg-success text-white">
                                <div class="stat-icon">
                                    <i class="fas fa-calendar-check"></i>
                                </div>
                                <div class="stat-info">
                                    <div class="stat-number">{{ $truckDriver->created_at->format('d/m/Y') }}</div>
                                    <div class="stat-label">Cadastrado em</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="stat-card bg-warning text-dark">
                                <div class="stat-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="stat-info">
                                    <div class="stat-number">{{ $truckDriver->updated_at->format('d/m/Y') }}</div>
                                    <div class="stat-label">Última Atualização</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .section-header {
        border-left: 4px solid #17a2b8;
        padding-left: 15px;
        margin-bottom: 20px;
    }
    
    .info-item {
        margin-bottom: 1rem;
    }
    
    .info-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: #6c757d;
        margin-bottom: 0.25rem;
        display: block;
    }
    
    .info-value {
        font-size: 1rem;
        color: #495057;
        font-weight: 500;
    }
    
    .stat-card {
        padding: 1.5rem;
        border-radius: 10px;
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .stat-icon {
        font-size: 2rem;
        margin-right: 1rem;
        opacity: 0.8;
    }
    
    .stat-number {
        font-size: 1.5rem;
        font-weight: bold;
        line-height: 1;
    }
    
    .stat-label {
        font-size: 0.9rem;
        opacity: 0.9;
        margin-top: 0.25rem;
    }
    
    .badge {
        font-size: 0.85rem;
        padding: 0.5rem 0.75rem;
    }
    
    hr {
        border-color: rgba(0,0,0,0.1);
    }
</style>
@endpush