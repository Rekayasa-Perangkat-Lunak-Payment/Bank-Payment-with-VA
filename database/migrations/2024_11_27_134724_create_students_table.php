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
        Schema::create('student', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('institution_id');
            $table->string('student_id');
            $table->string('name');
            $table->enum('gender', ['Pria', 'Wanita'])->default('Pria');
            $table->char('year', 4);
            $table->string('phone');
            $table->string('email')->unique();
            $table->integer('balance')->default(0);
            $table->string('password');
            $table->string('major');
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();

            $table->foreign('institution_id')->references('id')->on('institution')->onDelete('cascade');
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
