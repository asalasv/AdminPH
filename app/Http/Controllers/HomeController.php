<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.2/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Cliente;
use Auth; 
use App\User;

use Illuminate\Support\Facades\Session;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getIdcliente(){

        return Session::get('client.id_cliente');

    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $user=Auth::user();

        if($user->id_usuario_web == '1' or $user->id_usuario_web == '10')
            $clientes = Cliente::all();
        else
            $clientes = Cliente::where('id_usuario_web', $user->id_usuario_web)->get();

        // $users = User::all();

        // foreach ($users as $user) {
        //     if($user->username == 'asdasdasd'){
        //         $user->password = bcrypt($user->password);
        //         $user->save();
        //     }

        // }

        $cliente = Cliente::findOrFail($this->getIdcliente());

        return view('home', compact('clientes','cliente'));
    }
}