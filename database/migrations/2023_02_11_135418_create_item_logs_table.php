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
        Schema::create('item_logs', function (Blueprint $table) {
            $table->id();
            $table->string('log_id')->unique();
            $table->string('description')->nullable();
            $table->date('date_start');
            $table->date('date_end')->nullable();
            $table->string('officer');
            $table->string('guest')->nullable();
            $table->foreign('officer')->references('username')->on('users');
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
        Schema::dropIfExists('item_logs');
    }
};