@extends('layouts.app')

@section('title', 'Editar Caminhoneiro')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0"><i class="fas fa-user-edit me-2"></i>Editar Caminhoneiro</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('truck-drivers.update', $truckDriver) }}" method="POST" id="truckDriverForm">
                        @csrf
                        @method('PUT')

                        <!-- Dados Pessoais -->
                        <div class="section-header">
                            <h5 class="text-warning mb-3"><i class="fas fa-user me-2"></i>Dados Pessoais</h5>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Nome Completo <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $truckDriver->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label for="cpf" class="form-label">CPF</label>
                                <input type="text" name="cpf" id="cpf" class="form-control @error('cpf') is-invalid @enderror" 
                                       value="{{ old('cpf', $truckDriver->formatted_cpf) }}" placeholder="000.000.000-00">
                                @error('cpf')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-3 mb-3">
                                <label for="cnh" class="form-label">CNH</label>
                                <input type="text" name="cnh" id="cnh" class="form-control @error('cnh') is-invalid @enderror" 
                                       value="{{ old('cnh', $truckDriver->cnh) }}">
                                @error('cnh')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Telefone</label>
                                <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone', $truckDriver->formatted_phone) }}" placeholder="(00) 00000-0000">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $truckDriver->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Endereço -->
                        <div class="section-header">
                            <h5 class="text-warning mb-3"><i class="fas fa-map-marker-alt me-2"></i>Endereço</h5>
                        </div>

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="address" class="form-label">Endereço</label>
                                <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" 
                                          rows="2">{{ old('address', $truckDriver->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="zip_code" class="form-label">CEP</label>
                                <input type="text" name="zip_code" id="zip_code" class="form-control @error('zip_code') is-invalid @enderror" 
                                       value="{{ old('zip_code', $truckDriver->zip_code) }}" placeholder="00000-000">
                                @error('zip_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="city" class="form-label">Cidade</label>
                                <input type="text" name="city" id="city" class="form-control @error('city') is-invalid @enderror" 
                                       value="{{ old('city', $truckDriver->city) }}">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="state" class="form-label">Estado (UF)</label>
                                <input type="text" name="state" id="state" class="form-control @error('state') is-invalid @enderror" 
                                       value="{{ old('state', $truckDriver->state) }}" placeholder="GO" maxlength="2">
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Dados do Caminhão -->
                        <div class="section-header">
                            <h5 class="text-warning mb-3"><i class="fas fa-truck me-2"></i>Dados do Caminhão</h5>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="truck_plate" class="form-label">Placa</label>
                                <input type="text" name="truck_plate" id="truck_plate" class="form-control @error('truck_plate') is-invalid @enderror" 
                                       value="{{ old('truck_plate', $truckDriver->truck_plate) }}" placeholder="ABC-1234">
                                @error('truck_plate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="truck_model" class="form-label">Modelo</label>
                                <input type="text" name="truck_model" id="truck_model" class="form-control @error('truck_model') is-invalid @enderror" 
                                       value="{{ old('truck_model', $truckDriver->truck_model) }}">
                                @error('truck_model')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="truck_year" class="form-label">Ano</label>
                                <input type="number" name="truck_year" id="truck_year" class="form-control @error('truck_year') is-invalid @enderror" 
                                       value="{{ old('truck_year', $truckDriver->truck_year) }}" min="1980" max="{{ date('Y') + 1 }}">
                                @error('truck_year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="truck_capacity" class="form-label">Capacidade de Carga (toneladas)</label>
                                <input type="number" name="truck_capacity" id="truck_capacity" 
                                       class="form-control @error('truck_capacity') is-invalid @enderror" 
                                       value="{{ old('truck_capacity', $truckDriver->truck_capacity) }}" step="0.01" min="0" placeholder="0.00">
                                @error('truck_capacity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="truck_description" class="form-label">Descrição do Caminhão</label>
                                <input type="text" name="truck_description" id="truck_description" 
                                       class="form-control @error('truck_description') is-invalid @enderror" 
                                       value="{{ old('truck_description', $truckDriver->truck_description) }}">
                                @error('truck_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Observações -->
                        <div class="section-header">
                            <h5 class="text-warning mb-3"><i class="fas fa-sticky-note me-2"></i>Observações</h5>
                        </div>

                        <div class="mb-3">
                            <label for="observations" class="form-label">Observações Gerais</label>
                            <textarea name="observations" id="observations" class="form-control @error('observations') is-invalid @enderror" 
                                      rows="3">{{ old('observations', $truckDriver->observations) }}</textarea>
                            @error('observations')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Botões -->
                        <div class="d-flex justify-content-between pt-3">
                            <a href="{{ route('truck-drivers.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-warning text-dark">
                                <i class="fas fa-save me-2"></i>Atualizar Caminhoneiro
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .section-header {
        border-left: 4px solid #ffc107;
        padding-left: 15px;
        margin-bottom: 20px;
    }
    
    .card {
        border: none;
    }
    
    .form-label {
        font-weight: 500;
        margin-bottom: 5px;
    }
    
    .text-danger {
        font-size: 0.8em;
    }
    
    hr {
        border-color: rgba(0,0,0,0.1);
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Máscara para CPF
    const cpfInput = document.getElementById('cpf');
    if (cpfInput) {
        cpfInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            e.target.value = value;
        });
    }

    // Máscara para telefone
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/(\d{2})(\d)/, '($1) $2');
                value = value.replace(/(\d{5})(\d)/, '$1-$2');
            }
            e.target.value = value;
        });
    }

    // Máscara para CEP
    const zipInput = document.getElementById('zip_code');
    if (zipInput) {
        zipInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{5})(\d)/, '$1-$2');
            e.target.value = value;
        });
    }

    // Converter estado para maiúsculas
    const stateInput = document.getElementById('state');
    if (stateInput) {
        stateInput.addEventListener('input', function(e) {
            e.target.value = e.target.value.toUpperCase();
        });
    }

    // Converter placa para maiúsculas
    const plateInput = document.getElementById('truck_plate');
    if (plateInput) {
        plateInput.addEventListener('input', function(e) {
            e.target.value = e.target.value.toUpperCase();
        });
    }
});
</script>
@endpush
