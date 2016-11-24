<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_cliente extends Model
{
  protected $table = 'tipo_clientes';

  protected $fillable = [
    'id_tipo_cliente','tipo_cliente','descripcion'
  ];

  public $timestamps = false;
}
