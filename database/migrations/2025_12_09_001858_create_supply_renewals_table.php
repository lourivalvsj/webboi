<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplyRenewalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supply_renewals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supply_expense_id')->constrained()->onDelete('cascade');
            $table->decimal('previous_quantity', 10, 3);
            $table->decimal('added_quantity', 10, 3);
            $table->decimal('new_total_quantity', 10, 3);
            $table->decimal('previous_value', 10, 2);
            $table->decimal('new_value', 10, 2);
            $table->decimal('renewal_cost', 10, 2);
            $table->date('renewal_date');
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('supply_renewals');
    }
}
