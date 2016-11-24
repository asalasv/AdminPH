<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientes_Usuarios extends Model
{
    protected $table = 'clientes_usuarios';

    protected $fillable = [
       'id_cliente','id_usuario_ph','status','grupo','fecha_inicio','hora_inicio','fecha_fin','hora_fin'
    ];

    public $timestamps = false;

}
