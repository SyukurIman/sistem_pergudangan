<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pegawais';

    protected $fillable = [
        'nama',
        'email',
        'tanggal_lahir',
        'alamat',
        'no_telp'
    ];
}
