<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeathFieldsToAnimalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->boolean('is_dead')->default(false)->after('is_breeder');
            $table->date('death_date')->nullable()->after('is_dead');
            $table->text('death_location')->nullable()->after('death_date');
            $table->text('death_cause')->nullable()->after('death_location');
            $table->text('death_observations')->nullable()->after('death_cause');
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
            $table->dropColumn(['is_dead', 'death_date', 'death_location', 'death_cause', 'death_observations']);
        });
    }
}
