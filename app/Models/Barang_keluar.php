<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang_keluar extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'barang_keluars';

    protected $fillable = [
        'kode_barang',
        'tanggal_keluar'
    ];
    public function anggota_barang()
    {
        return $this->belongsTo(anggota_barang::class, 'kode_barang', 'kode_barang');
    }
}
