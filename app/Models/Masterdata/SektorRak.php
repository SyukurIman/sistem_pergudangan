<?php

namespace App\Models\Masterdata;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SektorRak extends Model
{
    protected $table = 'sektor_rak';

    protected $fillable = [
         'nama_sektor', 'kode_sektor',
    ];
}
