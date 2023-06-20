<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("first_name");
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('mobile')->unique();
            $table->integer('age')->default(0);
            $table->enum('gender', ['M', 'F']);
            $table->string('password');
            $table->enum('status', ['Active', 'Blocked'])->default('Active');
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
        Schema::dropIfExists('admins');
    }
}
