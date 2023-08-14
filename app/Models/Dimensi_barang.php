<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dimensi_barang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dimensi_barangs';

    protected $fillable = [
        'panjang',
        'lebar',
        'tinggi',
        'total_dimensi',
        'nama_dimensi'
    ];
}
