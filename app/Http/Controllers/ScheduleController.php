<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $currentDate = $request->get('date', now()->toDateString());
        $currentMonth = Carbon::parse($currentDate);
        
        // Eventos do mês para o calendário
        $schedules = Schedule::whereYear('date', $currentMonth->year)
                          ->whereMonth('date', $currentMonth->month)
                          ->orderBy('date')
                          ->orderBy('start_time')
                          ->get();
        
        // Eventos do dia selecionado
        $dayEvents = Schedule::whereDate('date', $currentDate)
                           ->orderBy('start_time')
                           ->get();
        
        return view('schedules.index', compact('schedules', 'currentDate', 'currentMonth', 'dayEvents'));
    }

    public function create(Request $request)
    {
        $selectedDate = $request->get('date', now()->toDateString());
        return view('schedules.create', compact('selectedDate'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after_or_equal:start_time',
        ], [
            'title.required' => 'O título é obrigatório.',
            'date.required' => 'A data é obrigatória.',
            'end_time.after_or_equal' => 'O horário de fim deve ser posterior ao de início.',
        ]);

        Schedule::create($validated);
        
        return redirect()->route('schedules.index', ['date' => $validated['date']])
                        ->with('success', 'Anotação criada com sucesso.');
    }

    public function show(Schedule $schedule)
    {
        return view('schedules.show', compact('schedule'));
    }

    public function edit(Schedule $schedule)
    {
        return view('schedules.edit', compact('schedule'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after_or_equal:start_time',
        ], [
            'title.required' => 'O título é obrigatório.',
            'date.required' => 'A data é obrigatória.',
            'end_time.after_or_equal' => 'O horário de fim deve ser posterior ao de início.',
        ]);

        $schedule->update($validated);
        
        return redirect()->route('schedules.index', ['date' => $validated['date']])
                        ->with('success', 'Anotação atualizada com sucesso.');
    }

    public function destroy(Schedule $schedule)
    {
        $eventDate = $schedule->date->toDateString();
        $schedule->delete();
        
        return redirect()->route('schedules.index', ['date' => $eventDate])
                        ->with('success', 'Anotação excluída com sucesso.');
    }
}
