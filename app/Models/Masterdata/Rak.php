<?php

namespace App\Models\Masterdata;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Rak extends Model
{
    protected $table = 'rak';

    protected $fillable = [
         'id_sektor_rak', 'kode_rak', 'nama_rak', 'tipe_rak', 'dimensi', 'daya_tampung'
    ];

    public function sektorrak()
    {
        return $this->belongsTo('App\Models\Masterdata\SektorRak', 'id_sektor', 'id_sektor');
    }
    public function dimensirak()
    {
        return $this->belongsTo('App\Models\Masterdata\DimensiRak', 'id_dimensi_rak', 'id_dimensi_rak');
    }
}
