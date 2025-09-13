@extends('layouts.app')

@section('title', 'Animais')
@section('content')
<div class="container-fluid fade-in-up">
    <div class="page-header-modern">
        <div class="d-flex justify-content-between align-items-center">
            <h2><i class="fas fa-paw me-2"></i>Gerenciar Animais</h2>
            <a href="{{ route('animals.create') }}" class="modern-btn modern-btn-success">
                <i class="fas fa-plus"></i>
                Novo Animal
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
        <form method="GET" action="{{ route('animals.index') }}">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" name="search" class="form-control modern-search-input" 
                               placeholder="Buscar por brinco ou raça..." 
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select modern-search-input">
                        <option value="">Todas as categorias</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}" 
                                {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" name="birth_date" class="form-control modern-search-input" 
                           placeholder="Data de nascimento" 
                           value="{{ request('birth_date') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="modern-btn modern-btn-primary w-100">
                        <i class="fas fa-search"></i>
                        Buscar
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="modern-table-container">
        @if($animals->count() > 0)
            <div class="table-responsive">
                <table class="table modern-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Brinco</th>
                            <th>Raça</th>
                            <th>Data Nascimento</th>
                            <th>Peso Inicial (kg)</th>
                            <th>Categoria</th>
                            <th width="200">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($animals as $animal)
                            <tr>
                                <td data-label="ID">{{ $animal->id }}</td>
                                <td data-label="Brinco">
                                    <strong class="text-primary">{{ $animal->tag }}</strong>
                                </td>
                                <td data-label="Raça">{{ $animal->breed }}</td>
                                <td data-label="Data Nascimento">
                                    {{ $animal->birth_date ? \Carbon\Carbon::parse($animal->birth_date)->format('d/m/Y') : 'N/A' }}
                                </td>
                                <td data-label="Peso Inicial">
                                    {{ $animal->initial_weight ? number_format($animal->initial_weight, 2, ',', '.') : 'N/A' }}
                                </td>
                                <td data-label="Categoria">
                                    @if($animal->category)
                                        <span class="status-badge active">{{ $animal->category->name }}</span>
                                    @else
                                        <span class="status-badge inactive">N/A</span>
                                    @endif
                                </td>
                                <td data-label="Ações">
                                    <div class="d-flex gap-1 flex-wrap">
                                        <a href="{{ route('animals.edit', $animal) }}" 
                                           class="modern-btn modern-btn-warning"
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('animals.destroy', $animal) }}" 
                                              method="POST" 
                                              style="display: inline-block;"
                                              onsubmit="return confirm('Tem certeza que deseja excluir este animal?')">
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
                <i class="fas fa-paw"></i>
                <h4>Nenhum animal encontrado</h4>
                <p class="mb-4">Não há animais cadastrados no sistema ou que correspondam aos filtros aplicados.</p>
                <a href="{{ route('animals.create') }}" class="modern-btn modern-btn-primary">
                    <i class="fas fa-plus"></i>
                    Cadastrar Primeiro Animal
                </a>
            </div>
        @endif
    </div>

    @if($animals->hasPages())
        <div class="modern-pagination">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Mostrando {{ $animals->firstItem() }} a {{ $animals->lastItem() }} 
                    de {{ $animals->total() }} resultados
                </div>
                {{ $animals->links() }}
            </div>
        </div>
    @endif
</div>
@endsection
