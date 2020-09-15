<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_id');
            $table->unsignedBigInteger('hub_id');
            $table->string('prefixed_id')->nullable();
            $table->decimal('total_actual_amount', 18, 6)->nullable();
            $table->decimal('total_amount_paid', 18, 6)->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->unsignedTinyInteger('event_status')->default(1);
            $table->timestamps();
            $table->foreign('program_id')->references('id')->on('programs');
            $table->foreign('hub_id')->references('id')->on('hubs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
