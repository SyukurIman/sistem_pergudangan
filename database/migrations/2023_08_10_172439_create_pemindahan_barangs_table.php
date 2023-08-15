<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePemindahanBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pemindahan_barangs', function (Blueprint $table) {
            $table->id();
            $table->timestamp('tanggal_pemindahan');
            $table->text('kode_barang');
            $table->integer('id_rak_asal');
            $table->integer('id_rak_tujuan');
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
        Schema::dropIfExists('pemindahan_barangs');
    }
}
