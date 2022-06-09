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
        Schema::create('proyek', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->foreign('owner_id')->references('id')->on('proyek_owner')->onDelete('cascade');
            $table->string('name');
            $table->string('type')->nullable()->comment('Makanan/Bencana_Alam/Zakat/Panti_Asuhan/Kemanusiaan');
            $table->string('location_code')->nullable();
            $table->string('image');
            $table->longText('description')->nullable();           
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
        Schema::dropIfExists('proyek');
    }
};
