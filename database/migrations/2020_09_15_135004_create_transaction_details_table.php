<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->string('type')->nullable();
            $table->string('official_receipt_number')->nullable();
            $table->decimal('session_cost', 18, 6)->nullable();
            $table->decimal('registration_fee', 18, 6)->nullable();
            $table->decimal('food_fee', 18, 6)->nullable();
            $table->decimal('payment_made', 18, 6)->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedTinyInteger('event_status')->nullable();
            $table->timestamps();
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->index('transaction_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_details');
    }
}
