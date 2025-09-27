@extends('layouts.app')

@section('title', 'Caminhoneiros')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0"><i class="fas fa-users me-2"></i>Caminhoneiros</h4>
            <a href="{{ route('truck-drivers.create') }}" class="btn btn-light">
                <i class="fas fa-user-plus me-2"></i>Novo Caminhoneiro
            </a>
        </div>
        
        <div class="card-body">
            <!-- Filtros e Busca -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <form method="GET" action="{{ route('truck-drivers.index') }}" class="d-flex">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Buscar por nome, CPF, placa ou modelo..." 
                                   value="{{ request('search') }}">
                            <button type="submit" class="btn btn-outline-primary">Buscar</button>
                            @if(request('search'))
                                <a href="{{ route('truck-drivers.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="col-md-4 text-end">
                    <small class="text-muted">
                        Total: <strong>{{ $truckDrivers->total() }}</strong> caminhoneiros
                    </small>
                </div>
            </div>

            <!-- Alertas -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Tabela -->
            @if($truckDrivers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th width="5%">#</th>
                                <th width="20%">Nome</th>
                                <th width="12%">CPF</th>
                                <th width="15%">Telefone</th>
                                <th width="15%">Caminhão</th>
                                <th width="10%">Placa</th>
                                <th width="8%">Capacidade</th>
                                <th width="5%">Fretes</th>
                                <th width="10%">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($truckDrivers as $driver)
                                <tr>
                                    <td>{{ $driver->id }}</td>
                                    <td>
                                        <div class="fw-bold">{{ $driver->name }}</div>
                                        @if($driver->email)
                                            <small class="text-muted">
                                                <i class="fas fa-envelope me-1"></i>{{ $driver->email }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($driver->cpf)
                                            <span class="badge bg-light text-dark">{{ $driver->formatted_cpf }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($driver->phone)
                                            <a href="tel:{{ $driver->phone }}" class="text-decoration-none">
                                                <i class="fas fa-phone me-1"></i>{{ $driver->formatted_phone }}
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($driver->truck_model || $driver->truck_year)
                                            <div class="fw-bold">{{ $driver->truck_model ?? 'N/A' }}</div>
                                            @if($driver->truck_year)
                                                <small class="text-muted">Ano: {{ $driver->truck_year }}</small>
                                            @endif
                                        @else
                                            {{ $driver->truck_description ?? '-' }}
                                        @endif
                                    </td>
                                    <td>
                                        @if($driver->truck_plate)
                                            <span class="badge bg-secondary">{{ $driver->truck_plate }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($driver->truck_capacity)
                                            <span class="fw-bold">{{ number_format($driver->truck_capacity, 1) }}t</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info">{{ $driver->freights_count ?? 0 }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('truck-drivers.edit', $driver) }}" 
                                               class="btn btn-outline-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" 
                                                    onclick="confirmDelete({{ $driver->id }}, '{{ $driver->name }}')"
                                                    title="Excluir">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        
                                        <!-- Form de exclusão (oculto) -->
                                        <form id="delete-form-{{ $driver->id }}" 
                                              action="{{ route('truck-drivers.destroy', $driver) }}" 
                                              method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginação -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div>
                        <p class="text-muted mb-0">
                            Exibindo {{ $truckDrivers->firstItem() }} a {{ $truckDrivers->lastItem() }} 
                            de {{ $truckDrivers->total() }} resultados
                        </p>
                    </div>
                    <div>
                        {{ $truckDrivers->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                <!-- Resultado vazio -->
                <div class="text-center py-5">
                    <i class="fas fa-users fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Nenhum caminhoneiro encontrado</h5>
                    @if(request('search'))
                        <p class="text-muted mb-4">
                            Não encontramos resultados para "<strong>{{ request('search') }}</strong>"
                        </p>
                        <a href="{{ route('truck-drivers.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-times me-2"></i>Limpar busca
                        </a>
                    @else
                        <p class="text-muted mb-4">Comece cadastrando seu primeiro caminhoneiro</p>
                        <a href="{{ route('truck-drivers.create') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus me-2"></i>Cadastrar Caminhoneiro
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(id, name) {
    if (confirm(`Tem certeza que deseja excluir o caminhoneiro "${name}"?\n\nEsta ação não pode ser desfeita.`)) {
        document.getElementById('delete-form-' + id).submit();
    }
}

// Auto-dismiss alerts
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>
@endpush

@push('styles')
<style>
    .table th {
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .table td {
        vertical-align: middle;
    }
    
    .btn-group-sm > .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
    }
    
    .badge {
        font-size: 0.75rem;
    }
    
    .alert {
        border: none;
        border-radius: 8px;
    }
    
    .input-group-text {
        background: white;
        border-right: none;
    }
    
    .input-group .form-control {
        border-left: none;
        border-right: none;
    }
    
    .input-group .btn {
        border-left: none;
    }
</style>
@endpush
