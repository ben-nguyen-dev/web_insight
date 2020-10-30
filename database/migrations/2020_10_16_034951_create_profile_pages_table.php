<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_pages', function (Blueprint $table) {
            $table->string('id', 50)->unique()->primary();
            $table->string('user_id', 50);
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('profile_title');
            $table->longText('profile_description');
            $table->string('location');
            $table->string('status');
            $table->dateTime('added_date');
            $table->dateTime('removed_date')->nullable();
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
        Schema::dropIfExists('profile_pages');
    }
}
