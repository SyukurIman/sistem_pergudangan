<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRakTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rak', function (Blueprint $table) {
            $table->bigIncrements('id_rak');
            $table->integer('id_sektor');
            $table->string('kode_rak', (50));
            $table->string('nama_rak', (50));
            $table->string('tipe_rak', (50));
            $table->integer('id_dimensi');
            $table->float('daya_tampung');
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
        Schema::dropIfExists('rak');
    }
}
