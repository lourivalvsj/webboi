@extends('layouts.app')

@section('title', 'Calendário de Anotações')

@section('content')
<div class="container-fluid">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Calendário -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>{{ $currentMonth->translatedFormat('F Y') }}</h4>
                    <div class="d-flex gap-2">
                        <a href="{{ route('schedules.index', ['date' => $currentMonth->copy()->subMonth()->toDateString()]) }}" 
                           class="btn btn-outline-light btn-sm">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                        <a href="{{ route('schedules.index', ['date' => now()->toDateString()]) }}" 
                           class="btn btn-light btn-sm">Hoje</a>
                        <a href="{{ route('schedules.index', ['date' => $currentMonth->copy()->addMonth()->toDateString()]) }}" 
                           class="btn btn-outline-light btn-sm">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="calendar-container">
                        <div class="calendar-header">
                            @foreach(['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'] as $day)
                                <div class="calendar-day-header">{{ $day }}</div>
                            @endforeach
                        </div>
                        <div class="calendar-grid">
                            @php
                                $startOfMonth = $currentMonth->copy()->startOfMonth();
                                $endOfMonth = $currentMonth->copy()->endOfMonth();
                                $startOfCalendar = $startOfMonth->copy()->startOfWeek();
                                $endOfCalendar = $endOfMonth->copy()->endOfWeek();
                                $currentCalendarDate = $startOfCalendar->copy();
                            @endphp
                            
                            @while($currentCalendarDate->lte($endOfCalendar))
                                @php
                                    $daySchedules = $schedules->filter(function($schedule) use ($currentCalendarDate) {
                                        return $schedule->date->format('Y-m-d') === $currentCalendarDate->format('Y-m-d');
                                    });
                                    $isToday = $currentCalendarDate->isToday();
                                    $isCurrentMonth = $currentCalendarDate->month === $currentMonth->month;
                                    $isSelected = $currentCalendarDate->format('Y-m-d') === $currentDate;
                                @endphp
                                
                                <div class="calendar-day {{ !$isCurrentMonth ? 'other-month' : '' }} {{ $isToday ? 'today' : '' }} {{ $isSelected ? 'selected' : '' }}"
                                     onclick="selectDate('{{ $currentCalendarDate->format('Y-m-d') }}')">
                                    <div class="day-number">{{ $currentCalendarDate->day }}</div>
                                    <div class="day-events">
                                        @foreach($daySchedules->take(2) as $schedule)
                                            <div class="event-dot" title="{{ $schedule->title }}"></div>
                                        @endforeach
                                        @if($daySchedules->count() > 2)
                                            <div class="event-more">+{{ $daySchedules->count() - 2 }}</div>
                                        @endif
                                    </div>
                                </div>
                                @php $currentCalendarDate->addDay(); @endphp
                            @endwhile
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Anotações do dia -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">
                        <i class="fas fa-sticky-note me-2"></i>{{ \Carbon\Carbon::parse($currentDate)->format('d/m/Y') }}
                    </h6>
                    <a href="{{ route('schedules.create', ['date' => $currentDate]) }}" 
                       class="btn btn-light btn-sm">
                        <i class="fas fa-plus"></i> Nova
                    </a>
                </div>
                <div class="card-body">
                    @if($dayEvents->count() > 0)
                        @foreach($dayEvents as $event)
                            <div class="event-item mb-3 p-3 border-start border-primary border-3 bg-light">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="mb-0">{{ $event->title }}</h6>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="{{ route('schedules.edit', $event) }}">
                                                <i class="fas fa-edit me-2"></i>Editar</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <form action="{{ route('schedules.destroy', $event) }}" method="POST" 
                                                      onsubmit="return confirm('Confirmar exclusão?')">
                                                    @csrf @method('DELETE')
                                                    <button class="dropdown-item text-danger">
                                                        <i class="fas fa-trash me-2"></i>Excluir
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                
                                @if($event->formatted_time)
                                    <div class="text-muted mb-2">
                                        <i class="fas fa-clock me-1"></i>{{ $event->formatted_time }}
                                    </div>
                                @endif
                                
                                @if($event->description)
                                    <p class="text-muted mb-0">{{ $event->description }}</p>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-sticky-note fa-3x mb-3"></i>
                            <p>Nenhuma anotação para este dia</p>
                            <a href="{{ route('schedules.create', ['date' => $currentDate]) }}" 
                               class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Nova Anotação
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .calendar-container {
        background: white;
    }
    
    .calendar-header {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        background: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    
    .calendar-day-header {
        padding: 12px 8px;
        text-align: center;
        font-weight: 600;
        color: #495057;
        border-right: 1px solid #dee2e6;
        font-size: 0.9rem;
    }
    
    .calendar-day-header:last-child {
        border-right: none;
    }
    
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
    }
    
    .calendar-day {
        min-height: 80px;
        padding: 8px;
        border-right: 1px solid #dee2e6;
        border-bottom: 1px solid #dee2e6;
        cursor: pointer;
        transition: background-color 0.2s ease;
        position: relative;
    }
    
    .calendar-day:hover {
        background-color: #f0f8ff;
    }
    
    .calendar-day:last-child {
        border-right: none;
    }
    
    .calendar-day.other-month {
        color: #adb5bd;
        background-color: #fafafa;
    }
    
    .calendar-day.today {
        background-color: #e7f3ff;
        border-left: 4px solid #007bff;
    }
    
    .calendar-day.selected {
        background-color: #fff2cc;
        border-left: 4px solid #ffc107;
    }
    
    .day-number {
        font-weight: 600;
        margin-bottom: 4px;
        font-size: 0.9rem;
    }
    
    .day-events {
        display: flex;
        flex-wrap: wrap;
        gap: 2px;
        margin-top: 4px;
    }
    
    .event-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background-color: #007bff;
        flex-shrink: 0;
    }
    
    .event-more {
        font-size: 9px;
        color: #6c757d;
        font-weight: 500;
    }
    
    .event-item {
        border-radius: 6px;
        transition: all 0.2s ease;
    }
    
    .event-item:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
</style>
@endpush

@push('scripts')
<script>
function selectDate(date) {
    window.location.href = `{{ route('schedules.index') }}?date=${date}`;
}

// Auto refresh para manter dados atualizados
setInterval(function() {
    const currentUrl = new URL(window.location);
    const date = currentUrl.searchParams.get('date') || '{{ now()->toDateString() }}';
    // Apenas recarrega se não houver modals abertos
    if (!document.querySelector('.modal.show')) {
        window.location.reload();
    }
}, 300000); // 5 minutos
</script>
@endpush
