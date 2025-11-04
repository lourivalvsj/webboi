<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUnitAndQuantityToOperationalExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('operational_expenses', function (Blueprint $table) {
            $table->string('unit_of_measure')->nullable()->after('value');
            $table->decimal('quantity', 10, 3)->nullable()->after('unit_of_measure');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('operational_expenses', function (Blueprint $table) {
            $table->dropColumn(['unit_of_measure', 'quantity']);
        });
    }
}
