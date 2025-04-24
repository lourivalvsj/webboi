<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnimalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('animals', function (Blueprint $table) {
        $table->id();
        $table->string('tag')->unique(); // identificação do animal
        $table->string('breed')->nullable(); // raça
        $table->date('birth_date')->nullable(); // nascimento
        $table->decimal('initial_weight', 8, 2)->nullable(); // peso ao chegar
        $table->timestamps();

        $table->unsignedBigInteger('category_id')->nullable();
        $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');

    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('animals');
    }
}
