@extends('layouts.app')

@section('title', 'Detalhes do Animal')
@section('content')
<div class="container-fluid fade-in-up">
    <div class="page-header-modern">
        <div class="d-flex justify-content-between align-items-center">
            <h2><i class="fas fa-paw me-2"></i>Detalhes do Animal</h2>
            <div>
                <a href="{{ route('animals.edit', $animal) }}" class="modern-btn modern-btn-warning">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <a href="{{ route('animals.index') }}" class="modern-btn modern-btn-outline">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="modern-form-container">
                <h4 class="mb-4"><i class="fas fa-info-circle me-2"></i>Informações Básicas</h4>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-muted">Brinco (ID)</label>
                        <div class="form-control-static">
                            <strong class="text-primary fs-5">{{ $animal->tag }}</strong>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Raça</label>
                        <div class="form-control-static">
                            {{ $animal->breed ?? 'Não informado' }}
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-muted">Gênero</label>
                        <div class="form-control-static">
                            <span class="badge badge-{{ $animal->gender === 'macho' ? 'primary' : 'pink' }} fs-6">
                                <i class="fas fa-{{ $animal->gender === 'macho' ? 'mars' : 'venus' }} me-1"></i>
                                {{ ucfirst($animal->gender ?? 'Não informado') }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Tipo Reprodutivo</label>
                        <div class="form-control-static">
                            @if($animal->is_breeder)
                                <span class="badge badge-success fs-6">
                                    <i class="fas fa-star me-1"></i>
                                    {{ $animal->reproductive_type }}
                                </span>
                            @else
                                <span class="text-muted">Animal comum (não reprodutor)</span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-muted">Data de Nascimento</label>
                        <div class="form-control-static">
                            {{ $animal->birth_date ? $animal->birth_date->format('d/m/Y') : 'Não informado' }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Peso Inicial</label>
                        <div class="form-control-static">
                            {{ $animal->initial_weight ? number_format($animal->initial_weight, 2, ',', '.') . ' kg' : 'Não informado' }}
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-muted">Categoria</label>
                        <div class="form-control-static">
                            {{ $animal->category->name ?? 'Não categorizado' }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Idade Aproximada</label>
                        <div class="form-control-static">
                            @if($animal->birth_date)
                                {{ $animal->birth_date->diffForHumans() }}
                            @else
                                Não calculável
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            @if($animal->is_breeder)
                <div class="card border-success">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-star me-2"></i>
                            {{ $animal->gender === 'macho' ? 'Reprodutor' : 'Matriz' }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">
                            <strong>Função:</strong> 
                            {{ $animal->gender === 'macho' ? 'Reprodução (Macho)' : 'Reprodução (Fêmea)' }}
                        </p>
                        
                        @if($animal->gender === 'macho')
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Reprodutor Macho</strong><br>
                                Animal destinado à cobertura e melhoramento genético do rebanho.
                            </div>
                        @else
                            <div class="alert alert-info mb-0">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>Matriz</strong><br>
                                Fêmea destinada à reprodução e formação de crias para o rebanho.
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2"></i>
                            Animal de Produção
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-0">
                            Este animal não está classificado como reprodutor/matriz. 
                            É considerado um animal de produção comum.
                        </p>
                    </div>
                </div>
            @endif

            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-calendar me-2"></i>
                        Registros
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-1">
                        <strong>Cadastrado em:</strong><br>
                        {{ $animal->created_at->format('d/m/Y H:i') }}
                    </p>
                    @if($animal->updated_at != $animal->created_at)
                        <p class="mb-0 text-muted">
                            <strong>Última atualização:</strong><br>
                            {{ $animal->updated_at->format('d/m/Y H:i') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-control-static {
    padding: 0.375rem 0;
    font-size: 1rem;
    line-height: 1.5;
    min-height: 38px;
    display: flex;
    align-items: center;
}

.badge-pink {
    background-color: #e91e63;
    color: white;
}

.badge-primary {
    background-color: #007bff;
}

.badge-success {
    background-color: #28a745;
}
</style>
@endsection