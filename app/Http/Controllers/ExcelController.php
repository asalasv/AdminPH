<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth; 
use App\Http\Requests;
use App\Cliente;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;

class ExcelController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
    }

    public function getIdcliente(){

        return Session::get('client.id_cliente');

    }
    
    public function index(){

        if($this->getIdcliente() == null ){
            return redirect('home');
        }

    	$id_cliente = $this->getIdcliente();

    	$data = array();

    	$sql = "SELECT registro_portales.email AS Email, 
				CASE WHEN registro_portales.id_usuario_ph IS NOT NULL 
				       THEN usuarios_ph.nombre
				       ELSE registro_portales.nombre
				END AS Nombre,
				CASE WHEN registro_portales.id_usuario_ph IS NOT NULL 
				       THEN usuarios_ph.apellido
				       ELSE registro_portales.apellido
				END AS Apellido,
				usuarios_ph.sex AS Sexo, 
				usuarios_ph.birthday AS Birthday
				FROM registro_portales
				LEFT JOIN usuarios_ph ON registro_portales.id_usuario_ph = usuarios_ph.id_usuario_ph
				WHERE registro_portales.id_cliente = ".$id_cliente;

		$results = \DB::select($sql);

		$results = json_decode(json_encode($results), True);

        $default = ini_get('max_execution_time');
        set_time_limit(0);
        

		Excel::create('BD_PortalHook', function($excel) use($results) {
			    // Set the title
			    $excel->setTitle('Base de datos PortalHook');

			    // Chain the setters
			    $excel->setCreator('PortalHook')
			          ->setCompany('PortalHook');

		    $excel->sheet('Sheetname', function($sheet) use($results) {

		        $sheet->fromArray($results);

		    });

		})->export('xls');

		return view('home');
        set_time_limit($default);
    }


}
