<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manejo_Portal extends Model
{
  protected $table = 'manejo_portal';

  protected $fillable = [
    'id_cliente','tiempo','web',
  ];

  public $timestamps = false;

  protected $primaryKey = 'id_cliente';

}
