<?php

namespace App\Models\Masterdata;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DimensiRak extends Model
{
    use HasFactory;

    protected $table = 'dimensi_rak';

    protected $fillable = [
        'panjang',
        'lebar',
        'tinggi',
        'total_dimensi',
    ];
}
