<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use App\Portal;
// use App\Manejo_Portal;
use App\Cliente;
use App\Quotation;
use DB;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Collection as Collection;


class PortalesController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function getIdcliente(){

    return Session::get('client.id_cliente');

  }

  public function getclientes(){
    $user=Auth::user();

    if($user->id_usuario_web == '1' or $user->id_usuario_web == '29')
    $clientes = Cliente::all();
    else
    $clientes = Cliente::where('id_usuario_web', $user->id_usuario_web)->get();

    return $clientes;
  }

  public function index()
  {
    if($this->getIdcliente() == null ){
      return redirect('home');
    }

    $id_cliente = $this->getIdcliente();

    $clientes = $this->getclientes();
    $cliente = Cliente::findOrFail($this->getIdcliente());

    $portales = Portal::where('id_cliente', $id_cliente)->paginate(15);

    return view('portales/portales',compact('portales', 'clientes','cliente'));
  }

  public function newportal(Request $request){
    if($this->getIdcliente() == null ){
      return redirect('home');
    }

    $clientes = $this->getclientes();

    $cliente = Cliente::findOrFail($this->getIdcliente());

    if($cliente->certifica_email == 'F'){
      return redirect('portales');
    }

    return view('portales/newportal',compact('clientes','cliente'));

  }

  public function editportal($id_portal_cliente, Request $request){

    if($this->getIdcliente() == null ){
      return redirect('home');
    }

    $portal = Portal::findOrFail($id_portal_cliente);

    $clientes = $this->getclientes();

    $cliente = Cliente::findOrFail($this->getIdcliente());

    return view('portales/editportal',compact('portal','clientes','cliente'));
  }

  public function getportalpordefecto(){

    $portal = Portal::where('predeterminado', '=', 'V')->where('id_cliente', '=', $this->getIdcliente());

    if($portal->first()){
      $portal = $portal->first();
      return $portal->id_portal_cliente;
    }
    else
    return null;
  }

  public function update($id_portal_cliente, Request $request){

    $portal = Portal::findOrFail($id_portal_cliente);

    //$portal->fill($request->all());

    $portal->descripcion = $request->descripcion;

    if($request->predeterminado == 'on'){

      // recorrer todos los portales clientes y ponerlos en falso a todoso
      $portales = Portal::where('id_cliente', '=', $portal->id_cliente)->get();

      foreach ($portales as $p) {
        if($p->id_portal_cliente != $portal->id_portal_cliente){
          $p->predeterminado = 'F';
          $p->save();
        }
      }

      $portal->predeterminado = 'V';

      $portal->fecha_inicio = null;
      $portal->fecha_fin = null;
      $portal->hora_inicio = null;
      $portal->hora_fin = null;
      $portal->save();


    }else{
      $portal->fecha_inicio = $request->fecha_inicio;
      $portal->fecha_fin = $request->fecha_fin;
      $portal->predeterminado = 'F';
      $portal->hora_inicio = $request->hora_inicio;
      $portal->hora_fin = $request->hora_fin;
    }

    if($request->horario_parcial == 'on')
    $portal->horario_parcial = 'V';
    else
    $portal->horario_parcial = 'F';


    foreach ($request->only('imagen_publicidad') as $publicidad) {
      if($publicidad){
        if($publicidad->isValid()){
          $path = "images/";
          if($portal->imagen_publicidad != null){
            unlink($path.$portal->imagen_publicidad);
          }
          $ext = $publicidad->getClientOriginalExtension();
          $filename = 'captiveportal-'.uniqid().'.'.$ext;
          $publicidad->move($path, $filename);
          chmod($path . "/" . $filename, 0777);
          $portal->imagen_publicidad = $filename;
        }
      }
      break;
    }

    foreach ($request->only('imagen_logo') as $logo) {
      if($logo){
        if($logo->isValid()){
          $path = "images/";
          if($portal->imagen_logo != null){
            unlink($path.$portal->imagen_logo);
          }
          $ext = $logo->getClientOriginalExtension();
          $filename = 'captiveportal-'.uniqid().'.'.$ext;

          $logo->move($path, $filename);
          chmod($path . "/" . $filename, 0777);
          $portal->imagen_logo = $filename;
        }
      }
      break;
    }

    foreach ($request->only('imagen_fondo') as $fondo) {
      if($fondo){
        if($fondo->isValid()){
          $path = "images/";
          //dd($portal->imagen_fondo);
          if($portal->imagen_fondo != null){
            unlink($path.$portal->imagen_fondo);
          }
          $ext = $fondo->getClientOriginalExtension();
          $filename = 'captiveportal-'.uniqid().'.'.$ext;

          $fondo->move($path, $filename);
          chmod($path . "/" . $filename, 0777);
          $portal->imagen_fondo = $filename;
        }
      }
      break;
    }

    $portal->save();

    // if($portal->predeterminado == 'F'){

    shell_exec('./script.sh '.$portal->id_cliente.' '.$portal->id_portal_cliente);

    // $hora_inic = new \DateTime($portal->hora_inicio);
    // $hourString = $hora_inic->format('H');

    // $minuteString = $hora_inic->format('i');

    // $fecha_inic = new \DateTime($portal->fecha_inicio);
    // $yearString = $fecha_inic->format('Y');
    // $monthString = $fecha_inic->format('m');
    // $dayString = $fecha_inic->format('d');

    // shell_exec('./script.sh'.$portal->id_cliente.' '.$minuteString.' '.$hourString.' '.$dayString.' '.$monthString.' '.$portal->id_portal_cliente);

    // $hora_fin = new \DateTime($portal->hora_fin);
    // $hourString = $hora_fin->format('H');
    // $minuteString = $hora_fin->format('i');

    // $fecha_fin = new \DateTime($portal->fecha_fin);
    // $yearString = $fecha_fin->format('Y');
    // $monthString = $fecha_fin->format('m');
    // $dayString = $fecha_fin->format('d');

    // shell_exec('./script.sh'.$portal->id_cliente.' '.$minuteString.' '.$hourString.' '.$dayString.' '.$monthString.' '.$this->getportalpordefecto());

    // }

    return redirect('portales');
  }

  public function store(Request $request){

    $newportal = new Portal($request->all());

    $newportal->id_cliente = $this->getIdcliente();

    if($request->predeterminado == 'on'){

      // recorrer todos los portales clientes y ponerlos en falso a todoso
      $portales = Portal::where('id_cliente', '=', $newportal->id_cliente)->get();

      foreach ($portales as $portal) {
        $portal->predeterminado = 'F';
        $portal->save();
      }

      $newportal->predeterminado = 'V';

      $portal->fecha_inicio = null;
      $portal->fecha_fin = null;
      $portal->hora_inicio = null;
      $portal->hora_fin = null;

    }else
    $newportal->predeterminado = 'F';

    if($request->horario_parcial == 'on')
    $newportal->horario_parcial = 'V';
    else
    $newportal->horario_parcial = 'F';

    $newportal->hora_inicio = $request->hora_inicio;
    $newportal->hora_fin = $request->hora_fin;

    foreach ($request->only('imagen_publicidad') as $publicidad) {
      if($publicidad){
        if($publicidad->isValid()){
          $ext = $publicidad->getClientOriginalExtension();
          $filename = 'captiveportal-'.uniqid().'.'.$ext;
          $path = "images/";
          $publicidad->move($path, $filename);
          chmod($path . "/" . $filename, 0777);
          $newportal->imagen_publicidad = $filename;
        }
      }
      break;
    }

    foreach ($request->only('imagen_logo') as $logo) {
      if($logo){
        if($logo->isValid()){
          $ext = $logo->getClientOriginalExtension();
          $filename = 'captiveportal-'.uniqid().'.'.$ext;
          $path = "images/";
          $logo->move($path, $filename);
          chmod($path . "/" . $filename, 0777);
          $newportal->imagen_logo = $filename;
        }
      }
      break;
    }

    foreach ($request->only('imagen_fondo') as $fondo) {
      if($fondo){
        if($fondo->isValid()){
          $ext = $fondo->getClientOriginalExtension();
          $filename = 'captiveportal-'.uniqid().'.'.$ext;
          $path = "images/";
          $fondo->move($path, $filename);
          chmod($path . "/" . $filename, 0777);
          $newportal->imagen_fondo = $filename;
        }
      }
      break;
    }

    $newportal->save();

    // if($newportal->predeterminado == 'F'){

    // $hora_inic = new \DateTime($newportal->hora_inicio);
    // $hourString = $hora_inic->format('H');

    // $minuteString = $hora_inic->format('i');

    // $fecha_inic = new \DateTime($newportal->fecha_inicio);
    // $yearString = $fecha_inic->format('Y');
    // $monthString = $fecha_inic->format('m');
    // $dayString = $fecha_inic->format('d');

    // shell_exec('./script.sh '.$newportal->id_cliente.' '.$minuteString.' '.$hourString.' '.$dayString.' '.$monthString.' '.$newportal->id_portal_cliente);

    shell_exec('./script.sh '.$newportal->id_cliente.' '.$newportal->id_portal_cliente);

    // $hora_fin = new \DateTime($newportal->hora_fin);
    // $hourString = $hora_fin->format('H');
    // $minuteString = $hora_fin->format('i');

    // $fecha_fin = new \DateTime($newportal->fecha_fin);
    // $yearString = $fecha_fin->format('Y');
    // $monthString = $fecha_fin->format('m');
    // $dayString = $fecha_fin->format('d');

    // shell_exec('./script.sh '.$newportal->id_cliente.' '.$minuteString.' '.$hourString.' '.$dayString.' '.$monthString.' '.$this->getportalpordefecto());

    // }

    return redirect('portales');
  }

  public function destroy($id_portal_cliente, Request $request){

    $portal = Portal::findOrFail($id_portal_cliente);

    $portal->delete();

    $message = 'El portal '. $portal->descripcion . " fue eliminado de nuestros registros";

    return $message;

  }

  public function predeterminado(){

    $cliente = Cliente::findOrFail($this->getIdcliente());
    $id = $this->getIdcliente();

    $portales = Portal::where('id_cliente', $id)->get();

    foreach ($portales as $portal) {
      if($portal->predeterminado == 'V')
      return $portal->id_portal_cliente;
    }

    return "false";


  }
  public function manejo_portal(){

    if($this->getIdcliente() == null ){
      return redirect('home');
    }

    $clientes = $this->getclientes();

    $cliente = Cliente::findOrFail($this->getIdcliente());
    // $manejo_portal = Manejo_Portal::where('id_cliente', $cliente->id_cliente)->get()->first();

    return view('portales/manejo_portal',compact('clientes','cliente'));
  }

  public function updatemanejo_portal(Request $request){

    $cliente = Cliente::findOrFail($this->getIdcliente());
    // $manejo_portal = Manejo_Portal::where('id_cliente', $cliente->id_cliente)->get()->first();

    $cliente->tiempo_sesion = $request->tiempo_sesion;
    $cliente->web_redir = $request->web_redir;

    $cliente->save();

    shell_exec('./modifica-portal.sh '.$cliente->id_cliente.' '.$cliente->tiempo_sesion.' '.$cliente->web_redir);

    return redirect('home');
  }

}
