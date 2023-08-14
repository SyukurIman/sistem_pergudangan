<?php

namespace App\Models\Masterdata;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Pemindahan_barang extends Model
{
    protected $table = 'pemindahan_barangs';

    protected $fillable = [
         'tanggal_pemindahan', 'kode_barang', 'id_rak_asal', 'id_rak_tujuan'
    ];
    
    public function anggotabarang()
    {
        return $this->belongsTo('App\Models\Anggota_barang', 'kode_barang', 'kode_barang');
    }
    public function rakAsal()
    {
        return $this->belongsTo('App\Models\Masterdata\Rak', 'id_rak_asal', 'id_rak');
    }
    public function rakTujuan()
    {
        return $this->belongsTo('App\Models\Masterdata\Rak', 'id_rak_tujuan', 'id_rak');
    }
}
