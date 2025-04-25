<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::all();
        return view('schedules.index', compact('schedules'));
    }

    public function create()
    {
        return view('schedules.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after_or_equal:start_time',
            'description' => 'nullable|string|max:255',
        ]);

        Schedule::create($request->all());
        return redirect()->route('schedules.index')->with('success', 'Agendamento criado com sucesso.');
    }

    public function edit(Schedule $schedule)
    {
        return view('schedules.edit', compact('schedule'));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after_or_equal:start_time',
            'description' => 'nullable|string|max:255',
        ]);

        $schedule->update($request->all());
        return redirect()->route('schedules.index')->with('success', 'Agendamento atualizado com sucesso.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('schedules.index')->with('success', 'Agendamento excluído com sucesso.');
    }
}
