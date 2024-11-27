<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentPeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_periods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('institution_id');
            $table->char('year', 4);
            $table->char('month', 2)->nullable();
            $table->string('semester')->nullable();
            $table->integer('fixed_cost');
            $table->integer('credit_cost');
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();

            $table->foreign('institution_id')->references('id')->on('institutions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_periods');
    }
}
