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
        Schema::create('letters', function (Blueprint $table) {
            $table->id();
            $table->string('letter_code')->unique();
            $table->string('letter_id');
            $table->string('title');
            $table->date('date_created');
            $table->text('description')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->foreign('letter_id')->references('letter_id')->on('master_letters');
            $table->string('file_path')->nullable();
            $table->string('username');
            $table->foreign('username')->references('username')->on('users');
            $table->string('company_id');
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
        Schema::dropIfExists('letters');
    }
};
