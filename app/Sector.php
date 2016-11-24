<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
  protected $table = 'sectores';

  protected $fillable = [
    'id_sector','country','state','city'
  ];

  public $timestamps = false;

}
