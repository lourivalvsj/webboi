<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeTimeFieldsNullableInSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn(['start_time', 'end_time']);
        });
        
        Schema::table('schedules', function (Blueprint $table) {
            $table->time('start_time')->nullable()->after('date');
            $table->time('end_time')->nullable()->after('start_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn(['start_time', 'end_time']);
        });
        
        Schema::table('schedules', function (Blueprint $table) {
            $table->time('start_time')->after('date');
            $table->time('end_time')->after('start_time');
        });
    }
}
