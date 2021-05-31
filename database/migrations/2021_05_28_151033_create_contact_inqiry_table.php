<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactInqiryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_inqiries', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->nullable();
            $table->string('mobile', 12)->nullable();
            $table->string('email', 52)->nullable();
            $table->string('message', 255)->nullable();
            $table->integer('rating')->nullable();
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
        Schema::dropIfExists('contact_inqiries');
    }
}
