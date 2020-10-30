<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id', 50)->unique()->primary();
            $table->string('user_name', 128)->unique();
            $table->string('password', 256);
            $table->string('first_name', 128)->nullable();
            $table->string('last_name', 128)->nullable();
            $table->string('full_name', 128)->nullable();
            $table->string('avatar', 256)->nullable();
            $table->string('user_token',256)->nullable();
            $table->boolean('user_active')->default(false);
            $table->boolean('is_verified')->default(false);
            $table->integer('expires')->default(48);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }

}
