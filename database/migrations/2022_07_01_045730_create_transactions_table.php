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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('type')->nullable()->comment('pasarnak/investnak/wallet');
            $table->enum('transaction_type', ['income','outcome']);
            $table->foreignId('user_donations_id')->nullable()->foreign('user_donations_id')->references('id')->on('user_donations')->onDelete('cascade');
            $table->unsignedDouble('nominal');
            $table->string('payment_method')->nullable();
            $table->string('status')->nullable()->comment('pending/success/failed');
            $table->foreignId('proyek_batch_id')->nullable()->foreign('proyek_batch_id')->references('id')->on('proyek_batch')->onDelete('cascade');
            $table->string('description')->nullable();
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
        Schema::dropIfExists('transactions');
    }
};
