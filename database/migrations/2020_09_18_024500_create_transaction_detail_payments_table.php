<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionDetailPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_detail_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_detail_id');
            $table->string('official_receipt_number')->nullable();
            $table->decimal('payment_made', 18, 6)->nullable();
            $table->timestamps();
            $table->foreign('transaction_detail_id')->references('id')->on('transaction_details');
            $table->index('transaction_detail_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_detail_payments');
    }
}
