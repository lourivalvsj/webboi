<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeAnimalIdNullableInSupplyExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supply_expenses', function (Blueprint $table) {
            $table->dropForeign(['animal_id']);
            $table->dropColumn('animal_id');
        });
        
        Schema::table('supply_expenses', function (Blueprint $table) {
            $table->foreignId('animal_id')->nullable()->constrained()->onDelete('set null')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('supply_expenses', function (Blueprint $table) {
            $table->dropForeign(['animal_id']);
            $table->dropColumn('animal_id');
        });
        
        Schema::table('supply_expenses', function (Blueprint $table) {
            $table->foreignId('animal_id')->constrained()->onDelete('cascade')->after('id');
        });
    }
}
