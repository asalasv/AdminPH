<?php

namespace App\Http\Controllers;

use Request;
use Auth; 
use App\Http\Controllers\Controller;
use App\User;
use App\Cliente;
use App\Manejo_mac;
use DB;
use App\Quotation;
use DateTime;
use Illuminate\Support\Facades\Session;

class GraphicsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function getIdcliente(){

        return Session::get('client.id_cliente');

    }

    public function getclientes(){
        $user=Auth::user();

        if($user->id_usuario_web == '1' or $user->id_usuario_web == '10')
            $clientes = Cliente::all();
        else
            $clientes = Cliente::where('id_usuario_web', $user->id_usuario_web)->get();

        return $clientes;
    }

    public function lastweekreg()
    {
        if($this->getIdcliente() == null ){
            return redirect('home');
        }

        $clientes = $this->getclientes();

        return view('graphics/lastweekreg',compact('clientes'));
    }

    //Registros Nuevos Ultima Semana
    public function newlastweekreg()
    {
        if($this->getIdcliente() == null ){
            return redirect('home');
        }

        $clientes = $this->getclientes();

        return view('graphics/newlastweekreg',compact('clientes'));
    }

    //Registros Nuevos Ultima Semana
    public function getnewlastweekreg()
    {
        if(Request::ajax()){

            $req = Request::all();

            $req = json_encode($req);

            $req = json_decode($req);

            $user=Auth::user();

            $id_cliente = $this->getIdcliente();

            if($req->desde and $req->hasta){

                $req->desde = (new DateTime($req->desde))->format('Y-m-d');

                $req->hasta = (new DateTime($req->hasta))->format('Y-m-d');

                $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                        FROM `primer_registro_email`
                        WHERE `id_cliente` = ".$id_cliente.
                        " AND date_format(`fecha_registro`,'%m-%d-%Y') between date_format( '".$req->desde."' ,'%m-%d-%Y') and date_format( '".$req->hasta."' ,'%m-%d-%Y')
                        GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
            }else
                if($req->desde){

                    $req->desde = (new DateTime($req->desde))->format('Y-m-d');

                    $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                            FROM `primer_registro_email`
                            WHERE `id_cliente` = ".$id_cliente.
                            " AND date_format(`fecha_registro`,'%m-%d-%Y')  > date_format( '".$req->desde."' ,'%m-%d-%Y') 
                            GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                }else
                    if($req->hasta){

                        $req->hasta = (new DateTime($req->hasta))->format('Y-m-d');

                        $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                FROM `primer_registro_email`
                                WHERE `id_cliente` = ".$id_cliente.
                                " AND date_format(`fecha_registro`,'%m-%d-%Y') < date_format( '".$req->hasta."' ,'%m-%d-%Y')
                                GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                    }else{
                        $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                FROM `primer_registro_email`
                                WHERE `id_cliente` = ".$id_cliente.
                                " AND date_format(`fecha_registro`,'%m-%d-%Y') between date_format(now()-interval 7 day,'%m-%d-%Y') and date_format(now(),'%m-%d-%Y')
                                GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                    }

            
        
            $results = DB::select($sql);

            return $results;


        }
    }

    //Conexiones al Portal Ultima Semana.
    public function connectlastweek()
    {
        if($this->getIdcliente() == null ){
            return redirect('home');
        }

        $clientes = $this->getclientes();

        return view('graphics/connectlastweek',compact('clientes'));
    }

    public function getconnectlastweek()
    {
        if(Request::ajax()){

            $req = Request::all();

            $req = json_encode($req);

            $req = json_decode($req);

            $user=Auth::user();
            
          
            $id_cliente = $this->getIdcliente();

            if($req->desde and $req->hasta){

                $req->desde = (new DateTime($req->desde))->format('Y-m-d');

                $req->hasta = (new DateTime($req->hasta))->format('Y-m-d');

                $sql = "SELECT date_format(`fecha_actividad`,'%m-%d-%Y'), count(date_format(`fecha_actividad`,'%m-%d-%Y'))
                        FROM `actividad_portales`
                        WHERE `id_cliente` = ".$id_cliente.
                        " AND date_format(`fecha_actividad`,'%m-%d-%Y') between date_format( '".$req->desde."' ,'%m-%d-%Y') and date_format( '".$req->hasta."' ,'%m-%d-%Y')
                        GROUP BY date_format(`fecha_actividad`,'%m-%d-%Y')";
            }else
                if($req->desde){

                    $req->desde = (new DateTime($req->desde))->format('Y-m-d');

                    $sql = "SELECT date_format(`fecha_actividad`,'%m-%d-%Y'), count(date_format(`fecha_actividad`,'%m-%d-%Y'))
                            FROM `actividad_portales`
                            WHERE `id_cliente` = ".$id_cliente.
                            " AND date_format(`fecha_actividad`,'%m-%d-%Y')  > date_format( '".$req->desde."' ,'%m-%d-%Y') 
                            GROUP BY date_format(`fecha_actividad`,'%m-%d-%Y')";
                }else
                    if($req->hasta){

                        $req->hasta = (new DateTime($req->hasta))->format('Y-m-d');

                        $sql = "SELECT date_format(`fecha_actividad`,'%m-%d-%Y'), count(date_format(`fecha_actividad`,'%m-%d-%Y'))
                                FROM `actividad_portales`
                                WHERE `id_cliente` = ".$id_cliente.
                                " AND date_format(`fecha_actividad`,'%m-%d-%Y') < date_format( '".$req->hasta."' ,'%m-%d-%Y')
                                GROUP BY date_format(`fecha_actividad`,'%m-%d-%Y')";
                    }else{
                        $sql = "SELECT date_format(`fecha_actividad`,'%m-%d-%Y'), count(date_format(`fecha_actividad`,'%m-%d-%Y'))
                                FROM `actividad_portales`
                                WHERE `id_cliente` = ".$id_cliente.
                                " AND date_format(`fecha_actividad`,'%m-%d-%Y') between date_format(now()-interval 7 day,'%m-%d-%Y') and date_format(now(),'%m-%d-%Y')
                                GROUP BY date_format(`fecha_actividad`,'%m-%d-%Y')";
                    }
        
            $results = DB::select($sql);

            return $results;

        }
    }

    public function getlastweekreg(Request $request)
    {
        if($request::ajax()){

            $req = Request::all();

            $req = json_encode($req);

            $req = json_decode($req);

            $user=Auth::user();
            
                $id_cliente = $this->getIdcliente();

                if($req->desde and $req->hasta){

                    $req->desde = (new DateTime($req->desde))->format('Y-m-d');

                    $req->hasta = (new DateTime($req->hasta))->format('Y-m-d');

                    $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                            FROM `registro_portales`
                            WHERE `id_cliente` = ".$id_cliente.
                            " AND date_format(`fecha_registro`,'%m-%d-%Y') between date_format( '".$req->desde."' ,'%m-%d-%Y') and date_format( '".$req->hasta."' ,'%m-%d-%Y')
                            GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                }else
                    if($req->desde){

                        $req->desde = (new DateTime($req->desde))->format('Y-m-d');

                        $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                FROM `registro_portales`
                                WHERE `id_cliente` = ".$id_cliente.
                                " AND date_format(`fecha_registro`,'%m-%d-%Y')  > date_format( '".$req->desde."' ,'%m-%d-%Y') 
                                GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                    }else
                        if($req->hasta){

                            $req->hasta = (new DateTime($req->hasta))->format('Y-m-d');

                            $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                    FROM `registro_portales`
                                    WHERE `id_cliente` = ".$id_cliente.
                                    " AND date_format(`fecha_registro`,'%m-%d-%Y') < date_format( '".$req->hasta."' ,'%m-%d-%Y')
                                    GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                        }else{
                            $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                    FROM `registro_portales`
                                    WHERE `id_cliente` = ".$id_cliente.
                                    " AND date_format(`fecha_registro`,'%m-%d-%Y') between date_format(now()-interval 7 day,'%m-%d-%Y') and date_format(now(),'%m-%d-%Y')
                                    GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                        }

                
            
                $results = DB::select($sql);

                return $results;
        }
    }

    //Registros Usuarios PortalHook
    public function portalhookuserreg()
    {
        if($this->getIdcliente() == null ){
            return redirect('home');
        }

        $clientes = $this->getclientes();

        return view('graphics/portalhookuserreg',compact('clientes'));
    }

    //Registros Usuarios PortalHook
    public function getportalhookuserreg()
    {
        if(Request::ajax()){

            $req = Request::all();

            $req = json_encode($req);

            $req = json_decode($req);

            $user=Auth::user();

                $id_cliente = $this->getIdcliente();

                if($req->desde and $req->hasta){

                    $req->desde = (new DateTime($req->desde))->format('Y-m-d');

                    $req->hasta = (new DateTime($req->hasta))->format('Y-m-d');

                    $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                            FROM `registro_usuarios_ph`
                            WHERE `id_cliente` = ".$id_cliente.
                            " AND date_format(`fecha_registro`,'%m-%d-%Y') between date_format( '".$req->desde."' ,'%m-%d-%Y') and date_format( '".$req->hasta."' ,'%m-%d-%Y') 
                            GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                    $sql1 = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                            FROM `registro_portales`
                            WHERE `id_cliente` = ".$id_cliente.
                            " AND `id_usuario_ph` IS NULL
                            AND date_format(`fecha_registro`,'%m-%d-%Y') between date_format( '".$req->desde."' ,'%m-%d-%Y') and date_format( '".$req->hasta."' ,'%m-%d-%Y') 
                            GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                }else
                    if($req->desde){

                        $req->desde = (new DateTime($req->desde))->format('Y-m-d');

                        $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                FROM `registro_usuarios_ph`
                                WHERE `id_cliente` = ".$id_cliente.
                                " AND date_format(`fecha_registro`,'%m-%d-%Y')  > date_format( '".$req->desde."' ,'%m-%d-%Y') 
                                GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                        $sql1 = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                FROM `registro_portales`
                                WHERE `id_cliente` = ".$id_cliente.
                                " AND `id_usuario_ph` IS NULL
                                AND date_format(`fecha_registro`,'%m-%d-%Y')  > date_format( '".$req->desde."' ,'%m-%d-%Y') 
                                GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                    }else
                        if($req->hasta){

                            $req->hasta = (new DateTime($req->hasta))->format('Y-m-d');

                            $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                    FROM `registro_usuarios_ph`
                                    WHERE `id_cliente` = ".$id_cliente.
                                    " AND date_format(`fecha_registro`,'%m-%d-%Y') < date_format( '".$req->hasta."' ,'%m-%d-%Y')
                                    GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                            $sql1 = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                    FROM `registro_portales`
                                    WHERE `id_cliente` = ".$id_cliente.
                                    " AND `id_usuario_ph` IS NULL
                                    AND date_format(`fecha_registro`,'%m-%d-%Y') < date_format( '".$req->hasta."' ,'%m-%d-%Y') 
                                    GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                        }else{
                            $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                    FROM `registro_usuarios_ph`
                                    WHERE `id_cliente` = ".$id_cliente.
                                    " AND date_format(`fecha_registro`,'%m-%d-%Y') between date_format(now()-interval 7 day,'%m-%d-%Y') and date_format(now(),'%m-%d-%Y')
                                    GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                            $sql1 = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                    FROM `registro_portales`
                                    WHERE `id_cliente` = ".$id_cliente.
                                    " AND `id_usuario_ph` IS NULL
                                    AND date_format(`fecha_registro`,'%m-%d-%Y') between date_format(now()-interval 7 day,'%m-%d-%Y') and date_format(now(),'%m-%d-%Y')
                                    GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                        }
            
                $results = DB::select($sql);

                $results1 = DB::select($sql1);

                $array = array($results, $results1);

                return $array;
                
        }
    }

    //Registros Usuarios PortalHook Hombres y Mujeres
    public function sexportalhookuserreg()
    {
        if($this->getIdcliente() == null ){
            return redirect('home');
        }

        $clientes = $this->getclientes();

        return view('graphics/sexportalhookuserreg',compact('clientes'));
    }

    public function getsexportalhookuserreg()
    {
        if(Request::ajax()){

            $req = Request::all();

            $req = json_encode($req);

            $req = json_decode($req);

            $user=Auth::user();

                $id_cliente = $this->getIdcliente();

                
                if($req->desde and $req->hasta){

                    $req->desde = (new DateTime($req->desde))->format('Y-m-d');

                    $req->hasta = (new DateTime($req->hasta))->format('Y-m-d');

                    $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                            FROM `registro_usuarios_ph`
                            WHERE `id_cliente` = ".$id_cliente.
                            " AND `sex` = 'M' 
                            AND date_format(`fecha_registro`,'%m-%d-%Y') between date_format( '".$req->desde."' ,'%m-%d-%Y') and date_format( '".$req->hasta."' ,'%m-%d-%Y') 
                            GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                    $sql1 = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                            FROM `registro_usuarios_ph`
                            WHERE `id_cliente` = ".$id_cliente.
                            " AND `sex` = 'F' 
                            AND date_format(`fecha_registro`,'%m-%d-%Y') between date_format( '".$req->desde."' ,'%m-%d-%Y') and date_format( '".$req->hasta."' ,'%m-%d-%Y') 
                            GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                }else
                    if($req->desde){

                        $req->desde = (new DateTime($req->desde))->format('Y-m-d');

                        $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                FROM `registro_usuarios_ph`
                                WHERE `id_cliente` = ".$id_cliente.
                                " AND `sex` = 'M' 
                                AND date_format(`fecha_registro`,'%m-%d-%Y')  > date_format( '".$req->desde."' ,'%m-%d-%Y') 
                                GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                        $sql1 = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                FROM `registro_usuarios_ph`
                                WHERE `id_cliente` = ".$id_cliente.
                                " AND `sex` = 'F' 
                                AND date_format(`fecha_registro`,'%m-%d-%Y')  > date_format( '".$req->desde."' ,'%m-%d-%Y') 
                                GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                    }else
                        if($req->hasta){

                            $req->hasta = (new DateTime($req->hasta))->format('Y-m-d');
                        
                            $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                    FROM `registro_usuarios_ph`
                                    WHERE `id_cliente` = ".$id_cliente.
                                    " AND `sex` = 'M' 
                                    AND date_format(`fecha_registro`,'%m-%d-%Y') < date_format( '".$req->hasta."' ,'%m-%d-%Y')
                                    GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                            $sql1 = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                    FROM `registro_usuarios_ph`
                                    WHERE `id_cliente` = ".$id_cliente.
                                    " AND `sex` = 'F' 
                                    AND date_format(`fecha_registro`,'%m-%d-%Y') < date_format( '".$req->hasta."' ,'%m-%d-%Y')
                                    GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                        }else{
                            $sql = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                    FROM `registro_usuarios_ph`
                                    WHERE `id_cliente` = ".$id_cliente.
                                    " AND `sex` = 'M' 
                                    AND date_format(`fecha_registro`,'%m-%d-%Y') between date_format(now()-interval 7 day,'%m-%d-%Y') and date_format(now(),'%m-%d-%Y')
                                    GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                            $sql1 = "SELECT date_format(`fecha_registro`,'%m-%d-%Y'), count(date_format(`fecha_registro`,'%m-%d-%Y'))
                                    FROM `registro_usuarios_ph`
                                    WHERE `id_cliente` = ".$id_cliente.
                                    " AND `sex` = 'F' 
                                    AND date_format(`fecha_registro`,'%m-%d-%Y') between date_format(now()-interval 7 day,'%m-%d-%Y') and date_format(now(),'%m-%d-%Y')
                                    GROUP BY date_format(`fecha_registro`,'%m-%d-%Y')";
                        }
            
                $results = DB::select($sql);

                $results1 = DB::select($sql1);

                $array = array($results, $results1);

                return $array;

        }
    }

    public function coneccfraudulentas()
    {
        if($this->getIdcliente() == null ){
            return redirect('home');
        }

        $clientes = $this->getclientes();

        $sql = "SELECT `mac`, `id_registro`, Count(`mac`) as 'Conexiones', date(`fecha_registro`) as 'fecha' 
                FROM `registro_portales` 
                WHERE `id_cliente` = ".$this->getIdcliente().
                " AND date_format(`fecha_registro`,'%m-%d-%Y') between date_format(now()-interval 7 day,'%m-%d-%Y') and date_format(now(),'%m-%d-%Y')
                GROUP BY date(`fecha_registro`),`mac` 
                HAVING ( COUNT(*) > 2)";

        $macs = DB::select($sql);     

        $conexiones = array();

        $macs_array = array();

        foreach ($macs as $mac) {

             $mc = (string) $mac->mac;
             $fech = (string) $mac->fecha;

            $sql1 = "SELECT `id_registro`, `fecha_registro`,`id_usuario_ph`,`nombre`,`apellido`,`email`,`mac`,date(`fecha_registro`) as 'fecha'  FROM `registro_portales` WHERE `mac` = '".$mc."' and date(`fecha_registro`) = '".$fech."' ORDER BY `fecha_registro` DESC";

            $datos = DB::select($sql1); 

            array_push($conexiones, $datos);
            array_push($macs_array, $mac->mac);
        }   

        shell_exec('./listado_mac.sh '.$this->getIdcliente());

        $cliente = Cliente::findOrFail($this->getIdcliente());

        // $man_mac = Manejo_mac::where('mac','=', $macs_array)->where('id_equipo','=', $cliente->id_equipo)->get();

        // return view('graphics/coneccfraudulentas',compact('clientes','macs','conexiones','man_mac'));
         return view('graphics/coneccfraudulentas',compact('clientes','macs','conexiones'));
    }

    public function recurrenciaporc(){
        if($this->getIdcliente() == null ){
            return redirect('home');
        }

        $clientes = $this->getclientes();

        return view('graphics/recurrenciaporc',compact('clientes'));

    }

    public function getrecurrenciaporc(){

        if(Request::ajax()){

            $user=Auth::user();

            $id_cliente = $this->getIdcliente();
            
            // cantidad de conexiones recurrentes por mes
            $sql1=     "SELECT sum(Conexiones) as 'Conexiones_recurrentes', Mes from (SELECT  `mac` , COUNT(  `mac` ) AS  'Conexiones', DATE_FORMAT(  `fecha_actividad` ,  '%M-%Y' ) AS  'Mes'
                    FROM  `actividad_portales` 
                    WHERE  `id_cliente` = ".$id_cliente.
                    " AND DATE_FORMAT(  `fecha_actividad` ,  '%m-%d-%Y' ) 
                    BETWEEN DATE_FORMAT( NOW( ) - INTERVAL 7 MONTH ,  '%m-%Y' ) 
                    AND DATE_FORMAT( NOW( ) - INTERVAL 1 MONTH ,  '%m-%Y' ) 
                    GROUP BY DATE_FORMAT(  `fecha_actividad` ,  '%m-%Y' ) ,  `mac` 
                    HAVING (COUNT( * ) >2)) AS t group by Mes ORDER BY `t`.`Mes` DESC";

            //cantidad de conexiones totales por mes
            $sql2 =    "SELECT COUNT(  `mac` ) AS  'Conexiones_totales', DATE_FORMAT(  `fecha_actividad` ,  '%M-%Y' ) AS  'Mes'
                    FROM  `actividad_portales` 
                    WHERE  `id_cliente` = ".$id_cliente.
                    " AND DATE_FORMAT(  `fecha_actividad` ,  '%m-%d-%Y' ) 
                    BETWEEN DATE_FORMAT( NOW( ) - INTERVAL 7 MONTH ,  '%m-%Y' ) 
                    AND DATE_FORMAT( NOW( ) - INTERVAL 1 MONTH ,  '%m-%Y' ) 
                    GROUP BY DATE_FORMAT(  `fecha_actividad` ,  '%m-%Y' ) ";

            $results1 = DB::select($sql1);
            $results2 = DB::select($sql2);

            $porcentajes = array();

            $i=0;


            foreach($results1 as $res){
                $porcentajes[$i][0] = json_decode($res->Conexiones_recurrentes);
                $porcentajes[$i][1] = $res->Mes;
                $i++;
            }

            $i=0;

            foreach($results2 as $res){
                $porcentajes[$i][0] = (float) $porcentajes[$i][0] / (float)  json_decode($res->Conexiones_totales);
                $porcentajes[$i][0] = (float) $porcentajes[$i][0] * 100;
                $porcentajes[$i][0] = round($porcentajes[$i][0], 2);
                $i++;
            }

            return $porcentajes;


        }
        
    }

    public function dispmasconect(){
        if($this->getIdcliente() == null ){
            return redirect('home');
        }

        $clientes = $this->getclientes();

        return view('graphics/dispmasconect',compact('clientes'));

    }

     public function getdispmasconect(){

        if(Request::ajax()){

            $user=Auth::user();

            $id_cliente = $this->getIdcliente();

            $sql = "SELECT  `tipo_dispositivo` , COUNT( * ) as 'Conexiones'
                    FROM actividad_portales
                    WHERE  `id_cliente` = ".$id_cliente."
                    GROUP BY  `tipo_dispositivo`";

            $sql1 = "SELECT COUNT(*) as 'Conexiones_Totales' 
                    FROM `actividad_portales` 
                    WHERE `id_cliente` = ".$id_cliente;
            
           $results = DB::select($sql); 
           $results1 = DB::select($sql1); 

           $porcentajes = array();

           $i=0;


           $os = array("Apple", "Samsung", "Nokia", "HTC", "Blu", "LG");
           $otros = 0;
           $rim = 0;

            foreach($results as $res){
                
                if (in_array($res->tipo_dispositivo, $os)) {

                    $porcentajes[$i][0] = $res->tipo_dispositivo;
                    $porcentajes[$i][1] = (float) $res->Conexiones / (float) $results1[0]->Conexiones_Totales;
                    $porcentajes[$i][1] = (float) $porcentajes[$i][1] * 100;
                    $porcentajes[$i][1] = round($porcentajes[$i][1], 2);
                    $i++;
                
                }else
                    if($res->tipo_dispositivo == "RIM" || $res->tipo_dispositivo == "Blackberry"){
                        $rim = (float) $rim + (float) $res->Conexiones;
                    }
                    else{
                        $otros = (float) $otros + (float) $res->Conexiones;
                    }
            }

            $i++;
            $porcentajes[$i][0] = "RIM";
            $porcentajes[$i][1] = (float) $rim / (float) $results1[0]->Conexiones_Totales;
            $porcentajes[$i][1] = (float) $porcentajes[$i][1] * 100;
            $porcentajes[$i][1] = round($porcentajes[$i][1], 2);

            $i++;
            $porcentajes[$i][0] = "Otros";
            $porcentajes[$i][1] = (float) $otros / (float) $results1[0]->Conexiones_Totales;
            $porcentajes[$i][1] = (float) $porcentajes[$i][1] * 100;
            $porcentajes[$i][1] = round($porcentajes[$i][1], 2);

            return $porcentajes;
        }
        
    }





}
