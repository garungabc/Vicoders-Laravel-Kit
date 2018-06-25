<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('first_name');
            $table->string('last_name');
            $table->datetime('birth');
            $table->string('phone_area_code', 5);
            $table->string('phone_number', 20);
            $table->string('address');
            $table->string('avatar');
            $table->text('description');
            $table->string('account_type')->default('normal')->comment('facebook, google, ...');
            $table->string('social_id');
            $table->boolean('email_verified');
            $table->integer('order');
            $table->integer('status');
            $table->rememberToken();
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
    }
}
