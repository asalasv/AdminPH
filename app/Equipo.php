<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
  protected $table = 'equipos';

  protected $fillable = [
     'id_equipo','marca','hostname','noip'
  ];

  public $timestamps = false;

  protected $primaryKey = 'id_equipo';
}
