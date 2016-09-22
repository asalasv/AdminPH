<?php

namespace App\Http\Controllers;

use Auth; 
use Illuminate\Http\Request;
use App\Cliente;

use Illuminate\Support\Facades\Session;

use Requests;


class CertificationEmailController extends Controller
{
    public function getIdcliente(){

        return Session::get('client.id_cliente');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $user=Auth::user();

        $id_cliente = $this->getIdcliente();

        if($this->getIdcliente() == null ){
            return redirect('home');
        }

        if($user->id_usuario_web == '1')
            $clientes = Cliente::all();
        else
            $clientes = Cliente::where('id_usuario_web', $user->id_usuario_web)->get();

        $cliente = Cliente::findOrFail($id_cliente);

        return view('certificateemail',compact('clientes','cliente'));
    }

    public function changevalidate(){

        $id_cliente = $this->getIdcliente();
        $cliente = Cliente::findOrFail($id_cliente);

        if ($cliente->certifica_email == 'V') 

            $cliente->certifica_email = 'F';
        
        else

            $cliente->certifica_email = 'V';

        $cliente->save();

        return $cliente->certifica_email;

    }

}
