<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actividad_Portales extends Model
{
    protected $table = 'actividad_portales';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'id_actividad','fecha_actividad','id_cliente','mac','tipo_dispositivo','modelo','so_dispositivo','ip','tableta','mobil','smartphone','desktop','android','windowsphone','ios','navegador','version','resumen','id_portal_cliente','pantalla'
    ];

    protected $primaryKey = 'id_actividad';
    
    public $timestamps = false;
}
