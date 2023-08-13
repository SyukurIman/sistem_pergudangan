<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota_barang extends Model
{
    use HasFactory;

    protected $table = 'anggota_barangs';

    protected $fillable = [
        'id_barang',
        'kode_barang'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id');
    }

    public function barang_masuk()
    {
        return $this->belongsTo(Barang_masuk::class, 'kode_barang', 'kode_barang');
    }

    public function barang_keluar()
    {
        return $this->belongsTo(Barang_keluar::class, 'kode_barang', 'kode_barang');
    }
}
