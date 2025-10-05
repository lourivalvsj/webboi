<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeder.
     *
     * @return void
     */
    public function run()
    {
        Schedule::create([
            'title' => 'Reunião com Fornecedores',
            'type' => 'meeting',
            'date' => '2025-01-10',
            'start_time' => '14:00',
            'end_time' => '16:00',
            'priority' => 'high',
            'status' => 'pending',
            'description' => 'Discussão sobre novos preços de ração',
            'location' => 'Escritório Principal'
        ]);

        Schedule::create([
            'title' => 'Medicação dos Animais',
            'type' => 'task',
            'date' => '2025-01-10',
            'start_time' => '08:00',
            'end_time' => '09:00',
            'priority' => 'high',
            'status' => 'completed',
            'description' => 'Aplicar vermífugo nos bovinos do lote 3'
        ]);

        Schedule::create([
            'title' => 'Consulta Veterinária',
            'type' => 'appointment',
            'date' => '2025-01-12',
            'start_time' => '10:30',
            'end_time' => '12:00',
            'priority' => 'medium',
            'status' => 'pending',
            'description' => 'Exame dos animais recém chegados',
            'location' => 'Curral A'
        ]);

        Schedule::create([
            'title' => 'Pesagem dos Animais',
            'type' => 'task',
            'date' => now()->toDateString(),
            'start_time' => '15:00',
            'end_time' => '17:00',
            'priority' => 'medium',
            'status' => 'pending',
            'description' => 'Pesagem mensal dos bovinos'
        ]);

        Schedule::create([
            'title' => 'Lembrete: Renovar Licença',
            'type' => 'reminder',
            'date' => now()->addDays(7)->toDateString(),
            'start_time' => '09:00',
            'end_time' => '09:00',
            'priority' => 'low',
            'status' => 'pending',
            'description' => 'Renovar licença ambiental'
        ]);
    }
}
