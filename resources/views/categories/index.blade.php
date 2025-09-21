@extends('layouts.app')

@section('title', 'Categorias')
@section('content')
<div class="container-fluid fade-in-up">
    <div class="page-header-modern">
        <div class="d-flex justify-content-between align-items-center">
            <h2><i class="fas fa-tags me-2"></i>Gerenciar Categorias</h2>
            <a href="{{ route('categories.create') }}" class="modern-btn modern-btn-success">
                <i class="fas fa-plus"></i>
                Nova Categoria
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
        <form method="GET" action="{{ route('categories.index') }}">
            <div class="row g-3">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control modern-search-input" 
                               placeholder="Buscar por nome ou descrição..." 
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="modern-btn modern-btn-primary w-100">
                        <i class="fas fa-search"></i>
                        Buscar
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('categories.index') }}" class="modern-btn modern-btn-info w-100">
                        <i class="fas fa-times"></i>
                        Limpar
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="modern-table-container">
        @if($categories->count() > 0)
            <div class="table-responsive">
                <table class="table modern-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Descrição</th>
                            <th>Data Criação</th>
                            <th width="200">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td data-label="ID">{{ $category->id }}</td>
                                <td data-label="Nome">
                                    <strong class="text-primary">{{ $category->name }}</strong>
                                </td>
                                <td data-label="Descrição">
                                    {{ $category->description ?? 'Sem descrição' }}
                                </td>
                                <td data-label="Data Criação">
                                    {{ $category->created_at ? \Carbon\Carbon::parse($category->created_at)->format('d/m/Y H:i') : 'N/A' }}
                                </td>
                                <td data-label="Ações">
                                    <div class="d-flex gap-1 flex-wrap">
                                        <a href="{{ route('categories.edit', $category) }}" 
                                           class="modern-btn modern-btn-warning"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('categories.destroy', $category) }}" 
                                              method="POST" 
                                              style="display: inline-block;"
                                              onsubmit="return confirm('Tem certeza que deseja excluir esta categoria?')">
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
        @else
            <div class="empty-state">
                <i class="fas fa-tags"></i>
                <h4>Nenhuma categoria encontrada</h4>
                <p class="mb-4">Não há categorias cadastradas no sistema ou que correspondam aos filtros aplicados.</p>
                <a href="{{ route('categories.create') }}" class="modern-btn modern-btn-primary">
                    <i class="fas fa-plus"></i>
                    Cadastrar Primeira Categoria
                </a>
            </div>
        @endif
    </div>

    @if($categories->hasPages())
        <div class="modern-pagination">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Mostrando {{ $categories->firstItem() }} a {{ $categories->lastItem() }} 
                    de {{ $categories->total() }} resultados
                </div>
                {{ $categories->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
