<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('address_records', function (Blueprint $table) {
            $table->string('id', 50)->unique()->primary();
            $table->string('company_id', 50);
            $table->foreign('company_id')->references('id')->on('companies');
            $table->string('line1', 50);
            $table->string('line2', 50);
            $table->string('city');
            $table->string('post_code');
            $table->string('state')->nullable();
            $table->string('country');
            $table->string('type')->default('office');
            $table->boolean('is_active');
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
        Schema::dropIfExists('address_records');
    }
}
