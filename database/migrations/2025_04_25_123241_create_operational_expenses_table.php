<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperationalExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operational_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('local_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->decimal('value', 10, 2);
            $table->date('date');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operational_expenses');
    }
}
