<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use Auth; 
use Illuminate\Support\Facades\Session;
use App\Http\Requests;

class EmailingController extends Controller
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

        if($user->id_usuario_web == '1')
            $clientes = Cliente::all();
        else
            $clientes = Cliente::where('id_usuario_web', $user->id_usuario_web)->get();

        return $clientes;
    }

    public function index(){
        $user=Auth::user();

        if($this->getIdcliente() == null ){
            return redirect('home');
        }

        if($user->id_usuario_web == '1' or $user->id_usuario_web == '10')
            $clientes = Cliente::all();
        else
            $clientes = Cliente::where('id_usuario_web', $user->id_usuario_web)->get();

        $cliente = Cliente::findOrFail($this->getIdcliente());

    	return view('emailing/emailing',compact('clientes','cliente'));
    }

    public function getverify(){

        if($this->getIdcliente() == null ){
            return redirect('home');
        }

        $clientes = $this->getclientes();

        $id_cliente = $this->getIdcliente();

        $cliente = Cliente::findOrFail($id_cliente);

        return view('emailing/verify',compact('clientes','cliente'));

    }

    public function verify(){

        $id_cliente = $this->getIdcliente();
        $cliente = Cliente::findOrFail($id_cliente);

        if ($cliente->emailing_activo == 'V') 

            $cliente->emailing_activo = 'F';
        
        else

            $cliente->emailing_activo = 'V';

        $cliente->save();

        return $cliente->emailing_activo;

        //return 'hola';

    }
}
