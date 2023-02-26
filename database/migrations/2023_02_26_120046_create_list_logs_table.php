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
        Schema::create('list_logs', function (Blueprint $table) {
            $table->id();
            $table->string('log_id');
            $table->string('item_id');
            $table->integer('qty');
            $table->foreign('item_id')->references('item_id')->on('items');
            $table->foreign('log_id')->references('log_id')->on('item_logs');
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
        Schema::dropIfExists('list_logs');
    }
};