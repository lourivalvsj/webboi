<?php

namespace Database\Seeders;

use App\Models\Uf;
use Illuminate\Database\Seeder;

class UfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Uf::count() > 0) {
            $this->command->warn('Tabela de UFs já possui dados. Seed ignorado.');
            return;
        }

        $ufs = [
            ['name' => 'Acre', 'abbreviation' => 'AC'],
            ['name' => 'Alagoas', 'abbreviation' => 'AL'],
            ['name' => 'Amapá', 'abbreviation' => 'AP'],
            ['name' => 'Amazonas', 'abbreviation' => 'AM'],
            ['name' => 'Bahia', 'abbreviation' => 'BA'],
            ['name' => 'Ceará', 'abbreviation' => 'CE'],
            ['name' => 'Distrito Federal', 'abbreviation' => 'DF'],
            ['name' => 'Espírito Santo', 'abbreviation' => 'ES'],
            ['name' => 'Goiás', 'abbreviation' => 'GO'],
            ['name' => 'Maranhão', 'abbreviation' => 'MA'],
            ['name' => 'Mato Grosso', 'abbreviation' => 'MT'],
            ['name' => 'Mato Grosso do Sul', 'abbreviation' => 'MS'],
            ['name' => 'Minas Gerais', 'abbreviation' => 'MG'],
            ['name' => 'Pará', 'abbreviation' => 'PA'],
            ['name' => 'Paraíba', 'abbreviation' => 'PB'],
            ['name' => 'Paraná', 'abbreviation' => 'PR'],
            ['name' => 'Pernambuco', 'abbreviation' => 'PE'],
            ['name' => 'Piauí', 'abbreviation' => 'PI'],
            ['name' => 'Rio de Janeiro', 'abbreviation' => 'RJ'],
            ['name' => 'Rio Grande do Norte', 'abbreviation' => 'RN'],
            ['name' => 'Rio Grande do Sul', 'abbreviation' => 'RS'],
            ['name' => 'Rondônia', 'abbreviation' => 'RO'],
            ['name' => 'Roraima', 'abbreviation' => 'RR'],
            ['name' => 'Santa Catarina', 'abbreviation' => 'SC'],
            ['name' => 'São Paulo', 'abbreviation' => 'SP'],
            ['name' => 'Sergipe', 'abbreviation' => 'SE'],
            ['name' => 'Tocantins', 'abbreviation' => 'TO'],
        ];

        foreach ($ufs as $uf) {
            Uf::create($uf);
        }

        $this->command->info('UFs inseridas com sucesso!');
    }
}
