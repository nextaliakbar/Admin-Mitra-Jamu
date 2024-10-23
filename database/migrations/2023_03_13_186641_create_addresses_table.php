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
        Schema::create('addresses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->string('label')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->integer('province_id')->nullable();
            $table->string('province_name')->nullable();
            $table->integer('city_id')->nullable();
            $table->string('city_name')->nullable();
            $table->integer('subdistrict_id')->nullable();
            $table->string('subdistrict_name')->nullable();
            $table->text('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('pinpoint')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_default')->default(false);
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
        Schema::dropIfExists('addresses');
    }
};
