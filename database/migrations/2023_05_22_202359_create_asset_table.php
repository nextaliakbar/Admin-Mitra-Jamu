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
        Schema::create('assets', function (Blueprint $table) {
          $table->uuid('id')->primary();
          $table->string("code_asset")->nullable();
          $table->string("name")->nullable();
          $table->string("date")->nullable();
          $table->string("unit")->nullable();
          $table->string("type")->nullable();
          $table->string("useful_life")->nullable();
          $table->string("assets_price")->nullable();
          $table->string("monthly_depreciation")->nullable();
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
        Schema::dropIfExists('assets');
    }
};
