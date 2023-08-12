<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dimensi_barang extends Model
{
    use HasFactory;

    protected $table = 'dimensi_barangs';

    protected $fillable = [
        'panjang',
        'lebar',
        'tinggi',
        'total_dimensi',
        'nama_dimensi'
    ];
}
