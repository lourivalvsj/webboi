<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReproductionFieldsToAnimalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->enum('gender', ['macho', 'femea'])->nullable()->after('breed');
            $table->boolean('is_breeder')->default(false)->after('gender')->comment('Reprodutor/Matriz');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->dropColumn(['gender', 'is_breeder']);
        });
    }
}
