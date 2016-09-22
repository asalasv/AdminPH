<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth; 
use App\Cliente;
use App\Actividad_Portales;
use App\Manejo_mac;
use App\Sesion;
use App\Quotation;
use DB;
use Illuminate\Support\Facades\Session;


class SessionsController extends Controller
{


    public function getIdcliente(){

        return Session::get('client.id_cliente');

    }

    public function index(){
        $user=Auth::user();

        if($this->getIdcliente() == null ){
            return redirect('home');
        }

        $salida = shell_exec('./vivo.sh '.$this->getIdcliente());
        
        $vivo = $salida[0];
        
        shell_exec('./sesiones.sh '.$this->getIdcliente());

        shell_exec('./listado_mac.sh '.$this->getIdcliente());

        if($user->id_usuario_web == '1' or $user->id_usuario_web == '10')
            $clientes = Cliente::all();
        else
            $clientes = Cliente::where('id_usuario_web', $user->id_usuario_web)->get();


        $cliente = Cliente::findOrFail($this->getIdcliente());

        $sesiones = Sesion::where('id_equipo', $cliente->id_equipo)->get();

        $macs = array();

        foreach ($sesiones as $sesion) {
            array_push($macs, $sesion->mac);
        }

        $macs = array_unique($macs);

        $man_mac = Manejo_mac::whereIn('mac', $macs)->get();

        $acti_portales = Actividad_Portales::whereIn('mac', $macs)->get();

    	return view('sessions',compact('clientes','cliente', 'sesiones','acti_portales','man_mac','cliente','vivo'));
    }

    public function desconectar($sesion, Request $request){

    	shell_exec('./desconexion.sh '.$this->getIdcliente().' '.$sesion);

    	return 'ok';
    }

    public function bloquear($mac, $sesion, $descr, Request $request){

        if($sesion == '1'){

            $cliente = Cliente::findOrFail($this->getIdcliente());

            $sesiones = Sesion::where('id_equipo', $cliente->id_equipo)->get();

            shell_exec('./sesiones.sh '.$this->getIdcliente());

            //si viene de conexiones fraudulentas revisar si esta conectado, y si esta conectado se hacen las dos cosas desconexion y bloqueo

            $conexion = Sesion::where('id_equipo', '=', $cliente->id_equipo)->where('mac', '=', $mac);

            if($conexion->first()){
                shell_exec('./desconexion.sh '.$this->getIdcliente().' '.$conexion->first()->sesion);
            }

            shell_exec('./bloqueo-desbloqueo.sh '.$this->getIdcliente().' block '.$mac.' '.$descr);

            return 'ok';

        }else{

            shell_exec('./desconexion.sh '.$this->getIdcliente().' '.$sesion);

            shell_exec('./bloqueo-desbloqueo.sh '.$this->getIdcliente().' block '.$mac.' '.$descr);

            return 'ok';
        }
    }

    public function desblock($mac, $orden, Request $request){

        shell_exec('./borrado_mac.sh '.$this->getIdcliente().' '.$orden);

        return 'ok';
    
    }

    public function bloqueodesbloqueo($mac, $act, $descr, Request $request){

        shell_exec('./bloqueo-desbloqueo.sh '.$this->getIdcliente().' '.$act.' '.$mac.' '.$descr);

        return 'ok';
    
    }


    public function habilitar($mac, Request $request){

        $cliente = Cliente::findOrFail($this->getIdcliente());

        $man_mac = Manejo_mac::where('mac', '=', $mac)->where('id_equipo', '=', $cliente->id_equipo)->get();

        return "shell_exec('./bloqueo-desbloqueo.sh '.$this->getIdcliente().' pass '.$mac.' '.);";

        //return 'ok';
    }


    public function gestionindex(){
         $user=Auth::user();

        if($this->getIdcliente() == null ){
            return redirect('home');
        }

        $salida = shell_exec('./vivo.sh '.$this->getIdcliente());
        
        $vivo = $salida[0];

        shell_exec('./listado_mac.sh '.$this->getIdcliente());

        $cliente = Cliente::findOrFail($this->getIdcliente());

        if($user->id_usuario_web == '1' or $user->id_usuario_web == '10')
            $clientes = Cliente::all();
        else
            $clientes = Cliente::where('id_usuario_web', $user->id_usuario_web)->get();

        $macs = Manejo_mac::where('id_equipo', $cliente->id_equipo)->get();

        return view('sesiones/gestion',compact('clientes','cliente','macs','vivo'));
    }

    
}
