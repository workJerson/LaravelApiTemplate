<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnsInTransactionDetailPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaction_detail_payments', function (Blueprint $table) {
            $table->dropColumn('session_cost');
            $table->dropColumn('registration_fee');
            $table->dropColumn('food_fee');
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