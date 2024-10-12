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
        Schema::create('pest_diseases', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code');
            $table->string('label');
            $table->longText('description');
            $table->json('treatment');
            $table->bigInteger('day')->nullable();
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
        Schema::dropIfExists('pest_diseases');
    }
};
