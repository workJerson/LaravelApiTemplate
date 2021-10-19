<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdditionalChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additional_charges', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->decimal('amount', 18, 6)->nullable();
            $table->unsignedBigInteger('program_id');
            $table->timestamps();
            $table->foreign('program_id')->references('id')->on('programs');
            $table->index('program_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('additional_charges');
    }
}
