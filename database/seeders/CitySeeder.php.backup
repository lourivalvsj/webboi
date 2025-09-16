<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use Illuminate\Support\Facades\Storage;

class CitySeeder extends Seeder
{
    public function run()
{
    $csvFile = database_path('seeders/cities.csv');

    if (file_exists($csvFile)) {
        // Se a tabela já tiver registros, não insere de novo
        if (DB::table('cities')->count() > 0) {
            $this->command->warn('Tabela de cidades já possui dados. Seed ignorado.');
            return;
        }

        $csv = Reader::createFromPath($csvFile, 'r');
        $csv->setHeaderOffset(0);

        $records = $csv->getRecords();

        $cities = [];
        foreach ($records as $record) {
            $cities[] = [
                'name' => $record['name'],
                'uf_id' => $record['uf_id'],
                'created_at' => $record['created_at'],
                'latitude' => $record['latitude'],
                'longitude' => $record['longitude'],
                'updated_at' => now(),
            ];
        }

        DB::table('cities')->insert($cities);

        $this->command->info('Cidades inseridas com sucesso!');
    } else {
        $this->command->error('Arquivo CSV não encontrado!');
    }
}

}
