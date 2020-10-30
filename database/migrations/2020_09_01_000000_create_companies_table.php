<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->string('id', 50)->unique()->primary();
            $table->string('type');
            $table->string('registration_number')->unique();
            $table->string('email');
            $table->string('phone_number');
            $table->string('linked_in');
            $table->string('website');
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_consultant')->default(false);
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
        Schema::dropIfExists('companies');
    }
}
