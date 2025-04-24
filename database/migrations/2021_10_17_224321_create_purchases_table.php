<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('animal_id');
            $table->date('purchase_date')->nullable();
            $table->decimal('value', 10, 2)->nullable();
            $table->decimal('freight_cost', 10, 2)->nullable();
            $table->string('transporter')->nullable();
            $table->decimal('commission_value', 10, 2)->nullable();
            $table->decimal('commission_percent', 5, 2)->nullable();
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
        Schema::dropIfExists('purchases');
    }
}
