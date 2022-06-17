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
        Schema::create('proyek_batch', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proyek_id')->foreign('proyek_id')->references('id')->on('proyek')->onDelete('cascade');
            $table->unsignedInteger('batch_no');
            $table->unsignedDouble('minimum_fund')->nullable();
            $table->unsignedDouble('maximum_fund')->nullable();
            $table->unsignedDouble('target_nominal')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->enum('status', ['draft','funding','ongoing','paid','closed']);
            $table->unsignedDouble('dana_terkumpul')->nullable();
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
        Schema::dropIfExists('proyek_batch');
    }
};
