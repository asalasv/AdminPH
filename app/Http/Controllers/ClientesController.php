<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Portal;
use Auth; 
use Illuminate\Support\Facades\Session;

use App\Http\Requests;

class ClientesController extends Controller
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

    public function select($id){

        Session::forget('client.logo');

        $portal = Portal::where('id_cliente', $id)->where('predeterminado', 'V')->first();

        $cliente = Cliente::findOrFail($id);

        // if($portal){
        //     if($portal->imagen_logo){
        //         Session::put('portal.logo',"/images/".$portal->imagen_logo);
        //     }
        // }

        if($cliente->logo){
            $logo = base64_encode($cliente->logo);
            $logo = 'data:image/png;base64,'.$logo;

            Session::put('client.logo',$logo);   
        }


        Session::put('client.id_cliente',$id);
        Session::put('client.name',$cliente->nombre);
        Session::put('activo','1');
        return 'Cliente seleccionado';
    }   

    public function imglogo()
    {
        Session::forget('client.logo');

        $clientes = $this->getclientes();

        $id_cliente = $this->getIdcliente();

        $cliente = Cliente::findOrFail($id_cliente);

        $logo = base64_encode($cliente->logo);

        $logo = 'data:image/png;base64,'.$logo;

        if($cliente->logo)
            Session::put('client.logo',$logo); 
 
        return view('cliente/logo',compact('logo','clientes'));
    }

   public function updateimglogo(Request $request)
    {

        $id_cliente = $this->getIdcliente();

        foreach ($request->only('logo') as $logo) {
        
            if($logo){
                $fp      = fopen($logo->getRealPath(), 'r');
                $image = fread($fp, filesize($logo->getRealPath()));
                $image = addslashes($image);
                fclose($fp);
                $sql = "UPDATE clientes 
                        SET logo = '".$image."' 
                        WHERE  id_cliente = ".$id_cliente;
                $result = \DB::statement($sql);

                return redirect('cliente/logo');
            }else
                 return redirect('cliente/logo');
        }

         return redirect('cliente/logo');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
