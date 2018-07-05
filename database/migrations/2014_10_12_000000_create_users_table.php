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
        Schema::defaultStringLength(191);
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname');
            $table->string('surname');
            $table->string('dob');
            $table->string('email')->unique();
            $table->string('address');
            $table->string('addtional_address_information');
            $table->integer('postcode');
            $table->string('town');
            $table->string('country');
            $table->string('currency');
            $table->integer('telephone');
            $table->string('username');
            $table->string('password');
            $table->string('security_question');
            $table->string('referal_username');
            $table->string('promotional_code');
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
