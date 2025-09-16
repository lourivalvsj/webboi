@extends('layouts.app')

@section('title', 'Compradores')
@section('content')
<div class="container-fluid fade-in-up">
    <div class="page-header-modern">
        <div class="d-flex justify-content-between align-items-center">
            <h2><i class="fas fa-user-check me-2"></i>Gerenciar Compradores</h2>
            <a href="{{ route('buyers.create') }}" class="modern-btn modern-btn-success">
                <i class="fas fa-plus"></i>
                Novo Comprador
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="modern-search-container">
        <form method="GET" action="{{ route('buyers.index') }}">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control modern-search-input" 
                               placeholder="Buscar por nome, e-mail, telefone ou cidade..." 
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="modern-btn modern-btn-primary w-100">
                        <i class="fas fa-search"></i>
                        Buscar
                    </button>
                </div>
                @if(request('search'))
                    <div class="col-md-2">
                        <a href="{{ route('buyers.index') }}" class="modern-btn modern-btn-secondary w-100">
                            <i class="fas fa-times"></i>
                            Limpar
                        </a>
                    </div>
                @endif
            </div>
        </form>
    </div>

    <div class="modern-table-container">
        @if($buyers->count() > 0)
            <div class="table-responsive">
                <table class="table modern-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>CPF/CNPJ</th>
                            <th>Contato</th>
                            <th>Localização</th>
                            <th width="200">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($buyers as $buyer)
                            <tr>
                                <td data-label="ID">{{ $buyer->id }}</td>
                                <td data-label="Nome">
                                    <strong class="text-primary">{{ $buyer->name }}</strong>
                                    @if($buyer->email)
                                        <br><small class="text-muted">{{ $buyer->email }}</small>
                                    @endif
                                </td>
                                <td data-label="CPF/CNPJ">
                                    @if($buyer->cpf_cnpj)
                                        <span class="text-dark">{{ $buyer->cpf_cnpj }}</span>
                                    @else
                                        <span class="text-muted">Não informado</span>
                                    @endif
                                </td>
                                <td data-label="Contato">
                                    @if($buyer->phone)
                                        <strong>{{ $buyer->phone }}</strong>
                                    @else
                                        <span class="text-muted">Não informado</span>
                                    @endif
                                </td>
                                <td data-label="Localização">
                                    @if($buyer->city || $buyer->state)
                                        <span>{{ $buyer->city }}@if($buyer->city && $buyer->state), @endif{{ $buyer->state }}</span>
                                        @if($buyer->address)
                                            <br><small class="text-muted">{{ Str::limit($buyer->address, 30) }}</small>
                                        @endif
                                    @else
                                        <span class="text-muted">Não informado</span>
                                    @endif
                                </td>
                                <td data-label="Ações">
                                    <div class="d-flex gap-1 flex-wrap">
                                        <a href="{{ route('buyers.show', $buyer) }}" 
                                           class="modern-btn modern-btn-info"
                                           title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('buyers.edit', $buyer) }}" 
                                           class="modern-btn modern-btn-warning"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('buyers.destroy', $buyer) }}" 
                                              method="POST" 
                                              style="display: inline-block;"
                                              onsubmit="return confirm('Tem certeza que deseja excluir este comprador?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="modern-btn modern-btn-danger"
                                                    title="Excluir">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Summary Card --}}
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="modern-search-container">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="text-center">
                                    <h5 class="text-muted mb-1">Total de Compradores</h5>
                                    <h3 class="text-primary">{{ $buyers->total() }}</h3>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <h5 class="text-muted mb-1">Com Telefone</h5>
                                    <h3 class="text-success">{{ $buyers->filter(fn($b) => !empty($b->phone))->count() }}</h3>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <h5 class="text-muted mb-1">Com Email</h5>
                                    <h3 class="text-info">{{ $buyers->filter(fn($b) => !empty($b->email))->count() }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-user-check"></i>
                <h4>Nenhum comprador encontrado</h4>
                <p class="mb-4">Não há compradores cadastrados no sistema ou que correspondam aos filtros aplicados.</p>
                <a href="{{ route('buyers.create') }}" class="modern-btn modern-btn-primary">
                    <i class="fas fa-plus"></i>
                    Cadastrar Primeiro Comprador
                </a>
            </div>
        @endif
    </div>

    @if($buyers->hasPages())
        <div class="modern-pagination">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Mostrando {{ $buyers->firstItem() }} a {{ $buyers->lastItem() }} 
                    de {{ $buyers->total() }} resultados
                </div>
                {{ $buyers->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
