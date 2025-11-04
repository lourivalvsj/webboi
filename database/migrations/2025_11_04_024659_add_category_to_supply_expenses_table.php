<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryToSupplyExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('supply_expenses', function (Blueprint $table) {
            $table->enum('category', ['medicamento', 'alimentacao'])->after('name')->default('alimentacao');
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
            $table->dropColumn('category');
        });
    }
}
