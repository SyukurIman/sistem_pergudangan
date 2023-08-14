<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang_masuk extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'barang_masuks';

    protected $fillable = [
        'kode_barang',
        'tanggal_masuk'
    ];

    public function anggota_barang()
    {
        return $this->belongsTo(anggota_barang::class, 'kode_barang', 'kode_barang');
    }
}
