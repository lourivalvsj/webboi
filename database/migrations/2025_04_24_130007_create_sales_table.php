<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('animal_id');
        $table->date('sale_date')->nullable();
        $table->decimal('value', 10, 2)->nullable();
        $table->decimal('weight_at_sale', 8, 2)->nullable();
        $table->timestamps();

        $table->foreign('animal_id')->references('id')->on('animals')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
