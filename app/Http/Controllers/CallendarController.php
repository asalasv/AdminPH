<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Portal;
use App\Cliente;
use Illuminate\Support\Facades\Session;

class CallendarController extends Controller
{
  public function getIdcliente(){

    return Session::get('client.id_cliente');

  }

  public function api()
  {

    $portales = Portal::where('id_cliente', '=', $this->getIdcliente())->get();
    $data = array();

    foreach ($portales as $p) {
      if($p->fecha_inicio != ''){
        $event = array(
          "title" => $p->descripcion,
          "start" => $p->fecha_inicio.' '.$p->hora_inicio,
          "end" => $p->fecha_fin.' '.$p->hora_fin,
          "url" => "editportal/".$p->id_portal_cliente,
        );
        array_push($data, $event);
      }
    }

    return response()->json($data); //para luego retornarlo y estar listo para consumirlo

  }
}
