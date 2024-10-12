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
        Schema::create('conditions', function (Blueprint $table) {
            $table->id('id');
            $table->uuid('pest_disease_id')->nullable();
            $table->foreign('pest_disease_id')->references('id')->on('pest_diseases')->onDelete('cascade');
            $table->string('code');
            $table->enum('status', ['IMPROVED', 'WORSENED', 'HEALED', 'DIED'])->default('IMPROVED');
            $table->string('value');
            $table->json('treatment');
            $table->bigInteger('day')->nullable();
            $table->bigInteger('is_after')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conditions');
    }
};
