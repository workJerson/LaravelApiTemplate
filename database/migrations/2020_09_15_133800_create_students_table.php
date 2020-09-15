<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('school_id');
            $table->string('position');
            $table->string('ccaps')->nullable()->nullable();
            $table->string('letter_of_intent')->nullable();
            $table->string('pds')->nullable();
            $table->string('birth_certificate')->nullable();
            $table->string('marriage_certificate')->nullable();
            $table->string('employment_certificate')->nullable();
            $table->string('tor')->nullable();
            $table->string('honorable_dismissal')->nullable();
            $table->string('certificates')->nullable();
            $table->string('remarks')->nullable();
            $table->unsignedTinyInteger('status')->default(1);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('school_id')->references('id')->on('schools');
            $table->index('user_id');
            $table->index('school_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
