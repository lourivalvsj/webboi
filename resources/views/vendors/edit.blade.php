@extends('layouts.app')

@section('title', 'Editar Vendedor')
@section('content')
<div class="container-fluid fade-in-up">
    <div class="page-header-modern">
        <h2><i class="fas fa-user-tie me-2"></i>Editar Vendedor</h2>
    </div>

    <div class="modern-form-container">
        <form action="{{ route('vendors.update', $vendor) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="modern-form-group">
                        <label class="modern-form-label">Nome *</label>
                        <input type="text" name="name" class="modern-form-control" value="{{ old('name', $vendor->name) }}" required>
                        @error('name')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="modern-form-group">
                        <label class="modern-form-label">CPF/CNPJ</label>
                        <input type="text" name="cpf_cnpj" class="modern-form-control" value="{{ old('cpf_cnpj', $vendor->cpf_cnpj) }}" 
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
                        <input type="email" name="email" class="modern-form-control" value="{{ old('email', $vendor->email) }}">
                        @error('email')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="modern-form-group">
                        <label class="modern-form-label">Telefone</label>
                        <input type="text" name="phone" class="modern-form-control" value="{{ old('phone', $vendor->phone) }}" 
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
                                <option value="{{ $uf }}" {{ old('uf', $vendor->uf) == $uf ? 'selected' : '' }}>
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
                <div class="input-group">
                    <select name="city" id="city_select" class="modern-form-control" required>
                        <option value="">Selecione primeiro a UF</option>
                    </select>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="add_city_btn" style="margin-left: 5px;" title="Adicionar nova cidade">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                @error('city')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>
        </div>                <div class="col-md-4">
                    <div class="modern-form-group">
                        <label class="modern-form-label">Inscrição Estadual</label>
                        <input type="text" name="state_registration" class="modern-form-control" value="{{ old('state_registration', $vendor->state_registration) }}">
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
                        <textarea name="address" class="modern-form-control" rows="3" placeholder="Rua, número, bairro, CEP...">{{ old('address', $vendor->address) }}</textarea>
                        @error('address')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="modern-form-actions">
                <button type="submit" class="modern-btn modern-btn-primary">
                    <i class="fas fa-save"></i>
                    Atualizar Vendedor
                </button>
                <a href="{{ route('vendors.index') }}" class="modern-btn modern-btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Modal para adicionar nova cidade -->
<div class="modal fade" id="addCityModal" tabindex="-1" aria-labelledby="addCityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCityModalLabel">Adicionar Nova Cidade</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCityForm">
                    <div class="mb-3">
                        <label for="new_city_name" class="form-label">Nome da Cidade *</label>
                        <input type="text" class="form-control" id="new_city_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_city_uf" class="form-label">UF *</label>
                        <select class="form-control" id="new_city_uf" required>
                            <option value="">Selecione a UF</option>
                            @foreach(\App\Helpers\LocationHelper::getUfs() as $uf => $name)
                                <option value="{{ $uf }}">{{ $uf }} - {{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="save_city_btn">Salvar Cidade</button>
            </div>
        </div>
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
    const currentCity = '{{ old('city', $vendor->city) }}';
    if (currentCity) {
        updateCities();
        document.getElementById('city_select').value = currentCity;
    }

    // Configurar modal de adicionar cidade
    const addCityBtn = document.getElementById('add_city_btn');
    const addCityModal = new bootstrap.Modal(document.getElementById('addCityModal'));
    const saveCityBtn = document.getElementById('save_city_btn');
    const newCityUfSelect = document.getElementById('new_city_uf');
    const ufSelect = document.getElementById('uf_select');

    // Abrir modal para adicionar cidade
    addCityBtn.addEventListener('click', function() {
        // Se uma UF já estiver selecionada, pré-selecionar no modal
        if (ufSelect.value) {
            newCityUfSelect.value = ufSelect.value;
        }
        addCityModal.show();
    });

    // Salvar nova cidade
    saveCityBtn.addEventListener('click', function() {
        const cityName = document.getElementById('new_city_name').value.trim();
        const uf = document.getElementById('new_city_uf').value;

        if (!cityName || !uf) {
            alert('Por favor, preencha todos os campos.');
            return;
        }

        // Mostrar loading
        saveCityBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Salvando...';
        saveCityBtn.disabled = true;

        // Enviar requisição AJAX
        fetch('/cities', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                name: cityName,
                uf: uf
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Adicionar cidade à lista local
                if (!citiesByUf[uf]) {
                    citiesByUf[uf] = [];
                }
                citiesByUf[uf].push(data.city);
                citiesByUf[uf].sort();

                // Se a UF da nova cidade for a mesma selecionada, atualizar o select
                if (ufSelect.value === uf) {
                    updateCities();
                    document.getElementById('city_select').value = data.city;
                }

                // Fechar modal e limpar formulário
                addCityModal.hide();
                document.getElementById('addCityForm').reset();
                
                alert('Cidade adicionada com sucesso!');
            } else {
                alert(data.message || 'Erro ao adicionar cidade.');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao adicionar cidade. Tente novamente.');
        })
        .finally(() => {
            // Restaurar botão
            saveCityBtn.innerHTML = 'Salvar Cidade';
            saveCityBtn.disabled = false;
        });
    });
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
