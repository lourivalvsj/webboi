@extends('layouts.app')

@section('title', 'Nova Anotação')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-plus me-2"></i>Nova Anotação</h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('schedules.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Título *</label>
                            <input type="text" name="title" id="title" class="form-control" 
                                   value="{{ old('title') }}" required maxlength="255" 
                                   placeholder="Ex: Reunião com cliente">
                        </div>

                        <div class="mb-3">
                            <label for="date" class="form-label">Data *</label>
                            <input type="date" name="date" id="date" class="form-control" 
                                   value="{{ old('date', request('date', now()->toDateString())) }}" required>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="start_time" class="form-label">Horário Início</label>
                                <input type="time" name="start_time" id="start_time" class="form-control" 
                                       value="{{ old('start_time') }}">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="end_time" class="form-label">Horário Fim</label>
                                <input type="time" name="end_time" id="end_time" class="form-control" 
                                       value="{{ old('end_time') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descrição</label>
                            <textarea name="description" id="description" class="form-control" rows="3" 
                                      maxlength="1000" placeholder="Detalhes da anotação...">{{ old('description') }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('schedules.index', ['date' => request('date', now()->toDateString())]) }}" 
                               class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Voltar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validação de horários
    const startTime = document.getElementById('start_time');
    const endTime = document.getElementById('end_time');
    
    function validateTimes() {
        if (startTime.value && endTime.value) {
            if (endTime.value <= startTime.value) {
                endTime.setCustomValidity('O horário de fim deve ser posterior ao horário de início');
            } else {
                endTime.setCustomValidity('');
            }
        }
    }
    
    startTime.addEventListener('change', validateTimes);
    endTime.addEventListener('change', validateTimes);
    
    // Preview de prioridade
    const prioritySelect = document.getElementById('priority');
    prioritySelect.addEventListener('change', function() {
        const colors = {
            'low': 'success',
            'medium': 'warning', 
            'high': 'danger'
        };
        this.className = `form-select border-${colors[this.value]}`;
    });
    
    // Trigger inicial
    prioritySelect.dispatchEvent(new Event('change'));
});
</script>
@endpush
