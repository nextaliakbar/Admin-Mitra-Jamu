<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->date('salary_date')->nullable();
            $table->string('invoice')->unique()->nullable();
            $table->uuid('employee_id')->nullable();
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->double('basic_salary')->default(0)->nullable();
            $table->double('salary_reduction')->default(0)->nullable();
            $table->double('net_salary')->default(0)->nullable();
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
        Schema::dropIfExists('salary_payments');
    }
};
