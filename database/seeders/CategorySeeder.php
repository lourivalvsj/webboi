<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            // Categorias por idade/tipo de animal
            [
                'name' => 'Bezerro',
                'type' => 'tipo_animal',
                'description' => 'Animais jovens até 12 meses'
            ],
            [
                'name' => 'Novilho',
                'type' => 'tipo_animal', 
                'description' => 'Machos de 1 a 3 anos'
            ],
            [
                'name' => 'Novilha',
                'type' => 'tipo_animal',
                'description' => 'Fêmeas de 1 a 3 anos'
            ],
            [
                'name' => 'Boi',
                'type' => 'tipo_animal',
                'description' => 'Machos adultos acima de 3 anos'
            ],
            [
                'name' => 'Vaca',
                'type' => 'tipo_animal',
                'description' => 'Fêmeas adultas acima de 3 anos'
            ],
            [
                'name' => 'Reprodutor',
                'type' => 'tipo_animal',
                'description' => 'Animais destinados à reprodução'
            ],
            [
                'name' => 'Descarte',
                'type' => 'tipo_animal',
                'description' => 'Animais para descarte ou abate'
            ],

            // Categorias por fase de tratamento
            [
                'name' => 'Cria',
                'type' => 'fase_tratamento',
                'description' => 'Fase inicial de criação'
            ],
            [
                'name' => 'Recria',
                'type' => 'fase_tratamento',
                'description' => 'Fase de recriação e desenvolvimento'
            ],
            [
                'name' => 'Engorda',
                'type' => 'fase_tratamento',
                'description' => 'Fase final de engorda para abate'
            ]
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
