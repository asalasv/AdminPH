<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manejo_mac extends Model
{
    protected $table = 'manejo_mac';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'id_equipo', 'mac' , 'action', 'descr', 'orden'
    ];
    
    public $timestamps = false;
}
