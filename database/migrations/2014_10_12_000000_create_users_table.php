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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique()->nullable();
            $table->string('password');
            $table->string('acc_id', 10)->nullable();
            $table->string('fname', 50)->nullable();
            $table->string('lname', 50)->nullable();
            $table->string('mobile', 100)->unique()->nullable();
            $table->timestamp('dob')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('adhaar', 12)->nullable();
            $table->string('adhaar_file', 50)->nullable();
            $table->string('lat', 30)->nullable();
            $table->string('long', 30)->nullable();
            $table->string('address', 255)->nullable();
            $table->integer('block_status')->default(110)->nullable();
            $table->integer('delete_status')->default(210)->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->string('change_status_date',10)->nullable();
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
