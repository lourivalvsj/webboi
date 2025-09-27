<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToTruckDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('truck_drivers', function (Blueprint $table) {
            // Dados pessoais
            $table->string('cpf', 11)->nullable()->after('name');
            $table->string('cnh', 20)->nullable()->after('cpf');
            $table->string('phone', 15)->nullable()->after('cnh');
            $table->string('email')->nullable()->after('phone');
            
            // Endereço
            $table->text('address')->nullable()->after('email');
            $table->string('city', 100)->nullable()->after('address');
            $table->string('state', 2)->nullable()->after('city');
            $table->string('zip_code', 10)->nullable()->after('state');
            
            // Dados do caminhão
            $table->string('truck_plate', 10)->nullable()->after('zip_code');
            $table->string('truck_model', 100)->nullable()->after('truck_plate');
            $table->year('truck_year')->nullable()->after('truck_model');
            $table->decimal('truck_capacity', 8, 2)->nullable()->comment('Capacidade em toneladas')->after('truck_year');
            
            // Observações
            $table->text('observations')->nullable()->after('truck_description');
            
            // Índices para melhor performance
            $table->index('cpf');
            $table->index('truck_plate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('truck_drivers', function (Blueprint $table) {
            $table->dropIndex(['cpf']);
            $table->dropIndex(['truck_plate']);
            
            $table->dropColumn([
                'cpf', 'cnh', 'phone', 'email', 'address', 'city', 'state', 
                'zip_code', 'truck_plate', 'truck_model', 'truck_year', 
                'truck_capacity', 'observations'
            ]);
        });
    }
}
