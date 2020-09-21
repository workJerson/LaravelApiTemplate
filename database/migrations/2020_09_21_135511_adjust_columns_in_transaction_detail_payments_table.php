<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AdjustColumnsInTransactionDetailPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_detail_payments', function (Blueprint $table) {
            $table->dropColumn('payment_made');
            $table->decimal('session_cost', 18, 6)->nullable();
            $table->decimal('registration_fee', 18, 6)->nullable();
            $table->decimal('food_fee', 18, 6)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction_detail_payments', function (Blueprint $table) {
        });
    }
}
