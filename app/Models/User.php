<?php

namespace App\Models;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'status_id',
        'password',
        'id_role'
        
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    public function orangtua()
    {
        return $this->belongsTo('App\Models\Masterdata\orangtua', 'id_orangtua', 'id_orangtua');
    }
    public function guru()
    {
        return $this->belongsTo('App\Models\guru', 'id', 'id_guru');
    }
    public function kepsek()
    {
        return $this->belongsTo('App\Models\kepsek', 'id', 'id_kepsek');
    }
}
