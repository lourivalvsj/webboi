{{-- Modern Table Component --}}
{{-- Usage: @include('layouts.partials.modern-table', ['config' => $tableConfig]) --}}

@php
    $config = $config ?? [];
    $title = $config['title'] ?? 'Lista';
    $icon = $config['icon'] ?? 'fas fa-list';
    $createRoute = $config['createRoute'] ?? null;
    $createText = $config['createText'] ?? 'Novo Item';
    $searchAction = $config['searchAction'] ?? null;
    $searchPlaceholder = $config['searchPlaceholder'] ?? 'Buscar...';
    $headers = $config['headers'] ?? [];
    $items = $config['items'] ?? collect();
    $emptyMessage = $config['emptyMessage'] ?? 'Nenhum item encontrado';
    $emptyDescription = $config['emptyDescription'] ?? 'Não há itens cadastrados no sistema.';
    $pagination = $config['pagination'] ?? null;
    $filters = $config['filters'] ?? [];
@endphp

<div class="container-fluid fade-in-up">
    {{-- Header --}}
    <div class="page-header-modern">
        <div class="d-flex justify-content-between align-items-center">
            <h2><i class="{{ $icon }} me-2"></i>{{ $title }}</h2>
            @if($createRoute)
                <a href="{{ $createRoute }}" class="modern-btn modern-btn-success">
                    <i class="fas fa-plus"></i>
                    {{ $createText }}
                </a>
            @endif
        </div>
    </div>

    {{-- Flash Messages --}}
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

    {{-- Search and Filters --}}
    @if($searchAction || count($filters) > 0)
        <div class="modern-search-container">
            <form method="GET" action="{{ $searchAction }}">
                <div class="row g-3">
                    {{-- Search Input --}}
                    @if($searchAction)
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" name="search" class="form-control modern-search-input" 
                                       placeholder="{{ $searchPlaceholder }}" 
                                       value="{{ request('search') }}">
                            </div>
                        </div>
                    @endif

                    {{-- Custom Filters --}}
                    @foreach($filters as $filter)
                        <div class="col-md-{{ $filter['width'] ?? 3 }}">
                            @if($filter['type'] === 'select')
                                <select name="{{ $filter['name'] }}" class="form-select modern-search-input">
                                    <option value="">{{ $filter['placeholder'] }}</option>
                                    @foreach($filter['options'] as $value => $label)
                                        <option value="{{ $value }}" 
                                            {{ request($filter['name']) == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            @elseif($filter['type'] === 'date')
                                <input type="date" name="{{ $filter['name'] }}" 
                                       class="form-control modern-search-input" 
                                       placeholder="{{ $filter['placeholder'] }}" 
                                       value="{{ request($filter['name']) }}">
                            @else
                                <input type="{{ $filter['type'] }}" name="{{ $filter['name'] }}" 
                                       class="form-control modern-search-input" 
                                       placeholder="{{ $filter['placeholder'] }}" 
                                       value="{{ request($filter['name']) }}">
                            @endif
                        </div>
                    @endforeach

                    {{-- Search Button --}}
                    <div class="col-md-2">
                        <button type="submit" class="modern-btn modern-btn-primary w-100">
                            <i class="fas fa-search"></i>
                            Buscar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    @endif

    {{-- Table Container --}}
    <div class="modern-table-container">
        @if($items->count() > 0)
            <div class="table-responsive">
                <table class="table modern-table">
                    <thead>
                        <tr>
                            @foreach($headers as $header)
                                <th @if(isset($header['width'])) width="{{ $header['width'] }}" @endif>
                                    {{ $header['label'] }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                            <tr>
                                @foreach($headers as $key => $header)
                                    <td data-label="{{ $header['label'] }}">
                                        @if(isset($header['render']))
                                            {!! $header['render']($item) !!}
                                        @else
                                            {{ data_get($item, $key) }}
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="empty-state">
                <i class="{{ $icon }}"></i>
                <h4>{{ $emptyMessage }}</h4>
                <p class="mb-4">{{ $emptyDescription }}</p>
                @if($createRoute)
                    <a href="{{ $createRoute }}" class="modern-btn modern-btn-primary">
                        <i class="fas fa-plus"></i>
                        {{ $createText }}
                    </a>
                @endif
            </div>
        @endif
    </div>

    {{-- Pagination --}}
    @if($pagination && $pagination->hasPages())
        <div class="modern-pagination">
            <div class="d-flex justify-content-between align-items-center">
                <div class="text-muted">
                    Mostrando {{ $pagination->firstItem() }} a {{ $pagination->lastItem() }} 
                    de {{ $pagination->total() }} resultados
                </div>
                {{ $pagination->links() }}
            </div>
        </div>
    @endif
</div>
