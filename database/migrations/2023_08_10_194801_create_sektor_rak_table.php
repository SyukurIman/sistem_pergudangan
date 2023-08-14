<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSektorRakTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sektor_rak', function (Blueprint $table) {
            $table->bigIncrements('id_sektor');
            $table->string('nama_sektor', (50));
            $table->string('kode_sektor', (50));
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
        Schema::dropIfExists('sektor_rak');
    }
}
