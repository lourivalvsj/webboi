<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFreightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('freights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('truck_driver_id')->constrained()->onDelete('cascade');
            $table->foreignId('local_id')->constrained()->onDelete('cascade');
            $table->integer('quantity_animals');
            $table->decimal('value', 10, 2);
            $table->date('departure_date');
            $table->date('arrival_date');
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
        Schema::dropIfExists('freights');
    }
}
