@extends('layouts.app')

@section('title', 'Editar Comprador')
@section('content')
<div class="container-fluid fade-in-up">
    <div class="page-header-modern">
        <h2><i class="fas fa-user-check me-2"></i>Editar Comprador</h2>
    </div>

    <div class="modern-form-container">
        <form action="{{ route('buyers.update', $buyer) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="modern-form-group">
                        <label class="modern-form-label">Nome *</label>
                        <input type="text" name="name" class="modern-form-control" value="{{ old('name', $buyer->name) }}" required>
                        @error('name')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="modern-form-group">
                        <label class="modern-form-label">CPF/CNPJ</label>
                        <input type="text" name="cpf_cnpj" class="modern-form-control" value="{{ old('cpf_cnpj', $buyer->cpf_cnpj) }}" 
                               oninput="mascaraCpfCnpj(this)" maxlength="18">
                        @error('cpf_cnpj')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="modern-form-group">
                        <label class="modern-form-label">Email</label>
                        <input type="email" name="email" class="modern-form-control" value="{{ old('email', $buyer->email) }}">
                        @error('email')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="modern-form-group">
                        <label class="modern-form-label">Telefone</label>
                        <input type="text" name="phone" class="modern-form-control" value="{{ old('phone', $buyer->phone) }}" 
                               oninput="mascaraTelefone(this)" maxlength="15">
                        @error('phone')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="modern-form-group">
                        <label class="modern-form-label">UF *</label>
                        <select name="uf" id="uf_select" class="modern-form-control" required onchange="updateCities()">
                            <option value="">Selecione a UF</option>
                            @foreach(\App\Helpers\LocationHelper::getUfs() as $uf => $name)
                                <option value="{{ $uf }}" {{ old('uf', $buyer->uf) == $uf ? 'selected' : '' }}>
                                    {{ $uf }} - {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        @error('uf')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="modern-form-group">
                        <label class="modern-form-label">Cidade *</label>
                        <select name="city" id="city_select" class="modern-form-control" required>
                            <option value="">Selecione primeiro a UF</option>
                        </select>
                        @error('city')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="modern-form-group">
                        <label class="modern-form-label">Inscrição Estadual</label>
                        <input type="text" name="state_registration" class="modern-form-control" value="{{ old('state_registration', $buyer->state_registration) }}">
                        @error('state_registration')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="modern-form-group">
                        <label class="modern-form-label">Endereço Completo</label>
                        <textarea name="address" class="modern-form-control" rows="3" placeholder="Rua, número, bairro, CEP...">{{ old('address', $buyer->address) }}</textarea>
                        @error('address')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="modern-form-actions">
                <button type="submit" class="modern-btn modern-btn-primary">
                    <i class="fas fa-save"></i>
                    Atualizar Comprador
                </button>
                <a href="{{ route('buyers.index') }}" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
const citiesByUf = @json(\App\Helpers\LocationHelper::getCitiesByUf());

function updateCities() {
    const ufSelect = document.getElementById('uf_select');
    const citySelect = document.getElementById('city_select');
    const selectedUf = ufSelect.value;
    
    // Limpar opções das cidades
    citySelect.innerHTML = '<option value="">Selecione a cidade</option>';
    
    if (selectedUf && citiesByUf[selectedUf]) {
        citiesByUf[selectedUf].forEach(city => {
            const option = document.createElement('option');
            option.value = city;
            option.textContent = city;
            citySelect.appendChild(option);
        });
    }
}

// Carregar cidades se UF já estiver selecionada
document.addEventListener('DOMContentLoaded', function() {
    const currentCity = '{{ old('city', $buyer->city) }}';
    if (currentCity) {
        updateCities();
        document.getElementById('city_select').value = currentCity;
    }
});

function mascaraCpfCnpj(input) {
    let value = input.value.replace(/\D/g, '');
    if (value.length <= 11) {
        // CPF
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    } else {
        // CNPJ
        value = value.replace(/^(\d{2})(\d)/, '$1.$2');
        value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
        value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
        value = value.replace(/(\d{4})(\d)/, '$1-$2');
    }
    input.value = value;
}

function mascaraTelefone(input) {
    let value = input.value.replace(/\D/g, '');
    value = value.replace(/(\d{2})(\d)/, '($1) $2');
    value = value.replace(/(\d{4,5})(\d{4})$/, '$1-$2');
    input.value = value;
}
</script>
@endsection
