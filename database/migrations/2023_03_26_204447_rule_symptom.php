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
        Schema::create('rule_symptoms', function (Blueprint $table) {
            $table->uuid('rule_id');
            $table->foreign('rule_id')->references('id')->on('rules');
            $table->uuid('symptoms_id');
            $table->foreign('symptoms_id')->references('id')->on('symptoms');
            $table->primary(['rule_id', 'symptoms_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rule_symptom');
    }
};
