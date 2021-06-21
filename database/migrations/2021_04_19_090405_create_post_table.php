<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Createposttable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onCascade('delete');
            $table->string('person_name', 50)->nullable();
            $table->string('surname', 50)->nullable();
            $table->string('description', 255)->nullable();
            $table->integer('template_id')->default(0);       
            $table->integer('is_draft')->default(0);   
            $table->date('age')->nullable();
            $table->date('date_of_death')->nullable();
            $table->string('number', 12)->nullable();
            $table->string('relation', 50)->nullable();
            $table->string('address', 255)->nullable();
            $table->string('death_certificate', 50)->nullable();
            $table->string('person_pic', 50)->nullable();
            $table->string('lat', 30)->nullable();
            $table->string('long', 30)->nullable();
            $table->boolean('flowers')->default(false);
            $table->string('flower_type',5)->nullable();
            $table->integer('show_poc',5)->nullable(); 
            $table->string('pocontact', 50)->nullable();
            $table->string('lname', 50)->nullable();
            $table->string('institute', 50)->nullable();
            $table->string('swd', 10)->nullable();
            $table->string('swdperson', 50)->nullable();
            $table->integer('approval_status')->default(411)->nullable();
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('posts');
    }
}
