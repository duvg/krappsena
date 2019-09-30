<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('rols', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description');
            $table->timestamps();
        });

        Schema::create('headquarters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('occupations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('lastname');
            $table->string('telephone');
            $table->datetime('birthdate');
            $table->boolean('status');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();

            $table->unsignedBigInteger('rol_id');
            $table->unsignedBigInteger('headquarter_id');
            $table->unsignedBigInteger('occupation_id');


            $table->foreign('rol_id')->references('id')->on('rols');
            $table->foreign('headquarter_id')->references('id')->on('headquarters');
            $table->foreign('occupation_id')->references('id')->on('occupations');
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
        Schema::dropIfExists('users');
        Schema::dropIfExists('occupations');
        Schema::dropIfExists('headquarters');
        Schema::dropIfExists('rols');
    }
}
