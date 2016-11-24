<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistroPortales extends Model
{
    protected $table = 'registro_portales';

    protected $fillable = [
       'id_registro','fecha_registro','id_cliente','id_usuario_ph','mac','email','nombre','apellido','tiempo_registro','fecha_actividad'
    ];

    public $timestamps = false;

    protected $primaryKey = 'id_registro';

}
