<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->string('title', 100)->after('id');
            $table->enum('type', ['meeting', 'task', 'appointment', 'reminder', 'other'])->default('other')->after('title');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium')->after('type');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending')->after('priority');
            $table->string('location', 100)->nullable()->after('description');
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
            $table->dropColumn(['title', 'type', 'priority', 'status', 'location']);
        });
    }
}
