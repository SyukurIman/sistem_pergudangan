<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'barangs';

    protected $fillable = [
        'nama_barang',
        'id_kategori',
        'id_dimensi',
        'berat_barang'
    ];

    public function dimensi_barang()
    {
        return $this->belongsTo(Dimensi_barang::class, 'id_dimensi', 'id');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_dimensi', 'id');
    }

    public function anggota_barang()
    {
        return $this->belongsTo(anggota_barang::class, 'id', 'id_barang');
    }
}
