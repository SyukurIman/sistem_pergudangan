<?php

namespace App\Models\Masterdata;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Penempatan_barang extends Model
{
    protected $table = 'penempatan_barangs';

    protected $fillable = [
        'kode_barang', 'id_rak'
    ];

    public function rak()
    {
        return $this->belongsTo('App\Models\Masterdata\Rak', 'id_rak', 'id_rak');
    }
    public function anggotabarang()
    {
        return $this->belongsTo('App\Models\Anggota_barang', 'kode_barang', 'kode_barang');
    }
}
