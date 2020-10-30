<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNameRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('name_records', function (Blueprint $table) {
            $table->string('id', 50)->unique()->primary();
            $table->string('company_id', 50);
            $table->foreign('company_id')->references('id')->on('companies');
            $table->string('name', 50)->unique();
            $table->dateTime('added_date');
            $table->dateTime('removed_date')->nullable();
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
        Schema::dropIfExists('name_records');
    }
}
