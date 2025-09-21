<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CategorySeeder::class,
            // UfSeeder::class, // Removido - usando helper LocationHelper
            // CitySeeder::class, // Removido - usando helper LocationHelper
        ]);
    }
}
