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
        Schema::create('user_donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('proyek_id')->foreign('proyek')->references('id')->on('proyek')->onDelete('cascade');
            $table->foreignId('proyek_batch_id')->foreign('proyek_batch_id')->references('id')->on('proyek_batch')->onDelete('cascade');
            $table->unsignedDouble('nominal');
            $table->boolean('isAnonim')->default(0);
            $table->string('message')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_donations');
    }
};
