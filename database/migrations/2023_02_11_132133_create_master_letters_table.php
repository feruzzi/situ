<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_letters', function (Blueprint $table) {
            $table->id();
            $table->string('letter_id')->unique();
            $table->string('letter_name');
            $table->string('letter_type');
            $table->string('username');
            $table->string('company_id');
            $table->foreign('username')->references('username')->on('users');
            $table->foreign('company_id')->references('company_id')->on('companies');
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
        Schema::dropIfExists('master_letters');
    }
};