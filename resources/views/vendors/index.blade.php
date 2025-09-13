@extends('layouts.app')

@section('title', 'Vendedores')
@section('content')
<div class="container-fluid fade-in-up">
    <div class="page-header-modern">
        <div class="d-flex justify-content-between align-items-center">
            <h2><i class="fas fa-user-tie me-2"></i>Gerenciar Vendedores</h2>
            <a href="{{ route('vendors.create') }}" class="modern-btn modern-btn-success">
                <i class="fas fa-plus"></i>
                Novo Vendedor
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
        <form method="GET" action="{{ route('vendors.index') }}">
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
                        <a href="{{ route('vendors.index') }}" class="modern-btn modern-btn-secondary w-100">
                            <i class="fas fa-times"></i>
                            Limpar
                        </a>
                    </div>
                @endif
            </div>
        </form>
    </div>

    <div class="modern-table-container">
        @if($vendors->count() > 0)
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
                        @foreach($vendors as $vendor)
                            <tr>
                                <td data-label="ID">{{ $vendor->id }}</td>
                                <td data-label="Nome">
                                    <strong class="text-primary">{{ $vendor->name }}</strong>
                                    @if($vendor->email)
                                        <br><small class="text-muted">{{ $vendor->email }}</small>
                                    @endif
                                </td>
                                <td data-label="CPF/CNPJ">
                                    @if($vendor->cpf_cnpj)
                                        <span class="text-dark">{{ $vendor->cpf_cnpj }}</span>
                                    @else
                                        <span class="text-muted">Não informado</span>
                                    @endif
                                </td>
                                <td data-label="Contato">
                                    @if($vendor->phone)
                                        <strong>{{ $vendor->phone }}</strong>
                                    @else
                                        <span class="text-muted">Não informado</span>
                                    @endif
                                </td>
                                <td data-label="Localização">
                                    @if($vendor->city || $vendor->state)
                                        <span>{{ $vendor->city }}@if($vendor->city && $vendor->state), @endif{{ $vendor->state }}</span>
                                        @if($vendor->address)
                                            <br><small class="text-muted">{{ Str::limit($vendor->address, 30) }}</small>
                                        @endif
                                    @else
                                        <span class="text-muted">Não informado</span>
                                    @endif
                                </td>
                                <td data-label="Ações">
                                    <div class="d-flex gap-1 flex-wrap">
                                        <a href="{{ route('vendors.show', $vendor) }}" 
                                           class="modern-btn modern-btn-info"
                                           title="Visualizar">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('vendors.edit', $vendor) }}" 
                                           class="modern-btn modern-btn-warning"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('vendors.destroy', $vendor) }}" 
                                              method="POST" 
                                              style="display: inline-block;"
                                              onsubmit="return confirm('Tem certeza que deseja excluir este vendedor?')">
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
                                    <h5 class="text-muted mb-1">Total de Vendedores</h5>
                                    <h3 class="text-primary">{{ $vendors->total() }}</h3>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <h5 class="text-muted mb-1">Com Telefone</h5>
                                    <h3 class="text-success">{{ $vendors->filter(fn($v) => !empty($v->phone))->count() }}</h3>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <h5 class="text-muted mb-1">Com Email</h5>
                                    <h3 class="text-info">{{ $vendors->filter(fn($v) => !empty($v->email))->count() }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-user-tie"></i>
                <h4>Nenhum vendedor encontrado</h4>
                <p class="mb-4">Não há vendedores cadastrados no sistema ou que correspondam aos filtros aplicados.</p>
                <a href="{{ route('vendors.create') }}" class="modern-btn modern-btn-primary">
                    <i class="fas fa-plus"></i>
                    Cadastrar Primeiro Vendedor
                </a>
            </div>
        @endif
    </div>

    @if($vendors->hasPages())
        <div class="modern-pagination">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Mostrando {{ $vendors->firstItem() }} a {{ $vendors->lastItem() }} 
                    de {{ $vendors->total() }} resultados
                </div>
                {{ $vendors->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
