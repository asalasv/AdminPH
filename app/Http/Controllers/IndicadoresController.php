<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Cliente;
use App\RegistroPortales;
use App\Actividad_Portales;
use Request;
use DateTime;
use DB;
use Auth;

class IndicadoresController extends Controller
{
    
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


    public function index()
    {
    	if($this->getIdcliente() == null ){
            return redirect('home');
        }

        $clientes = $this->getclientes();

        return view('indicadores/indicadores', compact('clientes'));
    }

    public function conexionesprom()
    {
        if(Request::ajax()){

        	$req = Request::all();
            $req = json_encode($req);
            $req = json_decode($req);

            $req->cliente = ltrim($req->cliente);

            $cliente = Cliente::where('nombre', $req->cliente)->first();

            if($req->desde and $req->hasta){

                $req->desde = (new DateTime($req->desde))->format('Y-m-d');
                $req->hasta = (new DateTime($req->hasta))->format('Y-m-d');

                if($req->cliente == 'Todos'){

					$sql = "SELECT * 	
							FROM actividad_portales
							WHERE id_cliente != 1
							AND date_format(`fecha_actividad`,'%m-%d-%Y') between date_format( '".$req->desde."' ,'%m-%d-%Y') and date_format( '".$req->hasta."' ,'%m-%d-%Y')";

	            	$results = DB::select($sql);

	            	$registros = count($results);

	            	$clientes = Cliente::where('id_cliente','!=','1')->count();

	            	$acti = $registros/$clientes;

	            	$acti = round($acti);

                	$acti = (string)$acti." <small>por Cliente</small>";

                }else{

            		$sql = "SELECT * 	
							FROM actividad_portales
							WHERE id_cliente = ".$cliente->id_cliente."
							AND date_format(`fecha_actividad`,'%m-%d-%Y') between date_format( '".$req->desde."' ,'%m-%d-%Y') and date_format( '".$req->hasta."' ,'%m-%d-%Y')
				                GROUP BY DATE_FORMAT( fecha_actividad,  '%d-%m-%Y' ) ";

	            	$results = DB::select($sql);

	            	$dias = count($results);

            		$sql = "SELECT * 	
							FROM actividad_portales
							WHERE id_cliente = ".$cliente->id_cliente." 
							AND date_format(`fecha_actividad`,'%m-%d-%Y') between date_format( '".$req->desde."' ,'%m-%d-%Y') and date_format( '".$req->hasta."' ,'%m-%d-%Y')";

					$results = DB::select($sql);	

	            	$registros = count($results);
	            	
	            	if($dias != 0)
                		$acti = $registros/$dias;
                	else
                		$acti = 0;

                	$acti = round($acti);

                	$acti = (string)$acti." <small>por Dia</small>";
                	
                }

            }else
                if($req->desde){

                    $req->desde = (new DateTime($req->desde))->format('Y-m-d');

                    if($req->cliente == 'Todos'){

						$sql = "SELECT * 	
								FROM actividad_portales
								WHERE id_cliente != 1
								AND date_format(`fecha_actividad`,'%m-%d-%Y') > date_format( '".$req->desde."' ,'%m-%d-%Y')";

		            	$results = DB::select($sql);

		            	$registros = count($results);

		            	$clientes = Cliente::where('id_cliente','!=','1')->count();

		            	$acti = $registros/$clientes;

		            	$acti = round($acti);

                    	$acti = (string)$acti." <small>por Cliente</small>";

                	}else{

	            		$sql = "SELECT * 	
								FROM actividad_portales
								WHERE id_cliente = ".$cliente->id_cliente."
								AND date_format(`fecha_actividad`,'%m-%d-%Y') > date_format( '".$req->desde."' ,'%m-%d-%Y')
					                GROUP BY DATE_FORMAT( fecha_actividad,  '%d-%m-%Y' ) ";

		            	$results = DB::select($sql);

		            	$dias = count($results);

	            		$sql = "SELECT * 	
								FROM actividad_portales
								WHERE id_cliente = ".$cliente->id_cliente." 
								AND date_format(`fecha_actividad`,'%m-%d-%Y') > date_format( '".$req->desde."' ,'%m-%d-%Y')";

						$results = DB::select($sql);	

		            	$registros = count($results);

		            	if($dias != 0)
            				$acti = $registros/$dias;
                		else
                			$acti = 0;

                		$acti = round($acti);

                    	$acti = (string)$acti." <small>por Dia</small>";
                	
                	}

                }else
                    if($req->hasta){

                        $req->hasta = (new DateTime($req->hasta))->format('Y-m-d');

                        if($req->cliente == 'Todos'){
							
							$sql = "SELECT * 	
									FROM actividad_portales
									WHERE id_cliente != 1
									AND date_format(`fecha_actividad`,'%m-%d-%Y') < date_format( '".$req->hasta."' ,'%m-%d-%Y')";

			            	$results = DB::select($sql);

			            	$registros = count($results);

			            	$clientes = Cliente::where('id_cliente','!=','1')->count();

			            	$acti = $registros/$clientes;

			            	$acti = round($acti);

                        	$acti = (string)$acti." <small>por Cliente</small>";


		                }else{

    	            		$sql = "SELECT * 	
									FROM actividad_portales
									WHERE id_cliente = ".$cliente->id_cliente."
									AND date_format(`fecha_actividad`,'%m-%d-%Y') < date_format( '".$req->hasta."' ,'%m-%d-%Y')
						                GROUP BY DATE_FORMAT( fecha_actividad,  '%d-%m-%Y' ) ";

			            	$results = DB::select($sql);

			            	$dias = count($results);

    	            		$sql = "SELECT * 	
									FROM actividad_portales
									WHERE id_cliente = ".$cliente->id_cliente." 
									AND date_format(`fecha_actividad`,'%m-%d-%Y') < date_format( '".$req->hasta."' ,'%m-%d-%Y')";

							$results = DB::select($sql);	

			            	$registros = count($results);

    		            	if($dias != 0)
                				$acti = $registros/$dias;
                			else
                				$acti = 0;

                			$acti = round($acti);

                        	$acti = (string)$acti." <small>por Dia</small>";
		                	
		                }

                    }else{

                        if($req->cliente == 'Todos'){

                        	// $registros = Actividad_Portales::all()->count();

                        	$sql = "SELECT * FROM actividad_portales WHERE id_cliente != 1";

                        	$results = DB::select($sql);

                        	$registros = count($results);

                        	$clientes = Cliente::where('id_cliente','!=','1')->count();

			            	$acti = $registros/$clientes;

			            	$acti = round($acti);

                        	$acti = (string)$acti." <small>por Cliente</small>";

            	   //          $registros = "Cantidad de Conexiones: <b>".(string)$registros."</b>";
				            // $array = array($acti, $registros);

				            // return $registros;

		                }else{

    	            		$sql = "SELECT * 	
									FROM actividad_portales
									WHERE id_cliente = ".$cliente->id_cliente."
									GROUP BY DATE_FORMAT( fecha_actividad,  '%d-%m-%Y' ) ";

			            	$results = DB::select($sql);

			            	$dias = count($results);

    	            		$sql = "SELECT * 	
									FROM actividad_portales
									WHERE id_cliente = ".$cliente->id_cliente;

							$results = DB::select($sql);	

			            	$registros = count($results);

    		            	if($dias != 0)
		                		$acti = $registros/$dias;
		                	else
		                		$acti = 0;

		                	$acti = round($acti);

                        	$acti = (string)$acti." <small>por Dia</small>";
		                	
		                }
                    }

            $registros = "Cantidad de Conexiones: <b>".(string)$registros."</b>";
            $array = array($acti, $registros);

            return $array;
        }
    }
    
    public function registroprom()
    {
        if(Request::ajax()){

        	$req = Request::all();
            $req = json_encode($req);
            $req = json_decode($req);

            $req->cliente = ltrim($req->cliente);

            $cliente = Cliente::where('nombre', $req->cliente)->first();

            if($req->desde and $req->hasta){

                $req->desde = (new DateTime($req->desde))->format('Y-m-d');
                $req->hasta = (new DateTime($req->hasta))->format('Y-m-d');

                if($req->cliente == 'Todos'){

					$sql = "SELECT * 	
							FROM registro_portales
							WHERE id_cliente != 1
							AND date_format(`fecha_registro`,'%m-%d-%Y') between date_format( '".$req->desde."' ,'%m-%d-%Y') and date_format( '".$req->hasta."' ,'%m-%d-%Y')";

	            	$results = DB::select($sql);

	            	$registros = count($results);

	            	$clientes = Cliente::where('id_cliente','!=','1')->count();

	            	if ($clientes != 0)
	            		$acti = $registros/$clientes;
	            	else
	            		$acti = 0;

	            	$acti = round($acti);

                	$acti = (string)$acti." <small>por Cliente</small>";

                }else{

            		$sql = "SELECT * 	
							FROM registro_portales
							WHERE id_cliente = ".$cliente->id_cliente."
							AND date_format(`fecha_registro`,'%m-%d-%Y') between date_format( '".$req->desde."' ,'%m-%d-%Y') and date_format( '".$req->hasta."' ,'%m-%d-%Y')
				                GROUP BY date_format(`fecha_registro`,'%Y-%m-%d')";

	            	$results = DB::select($sql);

	            	$dias = count($results);

            		$sql = "SELECT * 	
							FROM registro_portales
							WHERE id_cliente = ".$cliente->id_cliente." 
							AND date_format(`fecha_registro`,'%m-%d-%Y') between date_format( '".$req->desde."' ,'%m-%d-%Y') and date_format( '".$req->hasta."' ,'%m-%d-%Y')";

					$results = DB::select($sql);	

	            	$registros = count($results);

	            	if($dias != 0)
                		$acti = $registros/$dias;
                	else
                		$acti = 0;

                	$acti = round($acti);

                	$acti = (string)$acti." <small>por Dia</small>";
                	
                }

            }else
                if($req->desde){

                    $req->desde = (new DateTime($req->desde))->format('Y-m-d');

                    if($req->cliente == 'Todos'){

						$sql = "SELECT * 	
								FROM registro_portales
								WHERE id_cliente != 1
								AND date_format(`fecha_registro`,'%m-%d-%Y') > date_format( '".$req->desde."' ,'%m-%d-%Y')";

		            	$results = DB::select($sql);

		            	$registros = count($results);

		            	$clientes = Cliente::where('id_cliente','!=','1')->count();

		            	if ($clientes != 0)
		            		$acti = $registros/$clientes;
		            	else
		            		$acti = 0;

		            	$acti = round($acti);

                    	$acti = (string)$acti." <small>por Cliente</small>";

                	}else{

	            		$sql = "SELECT * 	
								FROM registro_portales
								WHERE id_cliente = ".$cliente->id_cliente."
								AND date_format(`fecha_registro`,'%m-%d-%Y') > date_format( '".$req->desde."' ,'%m-%d-%Y')
					                GROUP BY date_format(`fecha_registro`,'%Y-%m-%d')";

		            	$results = DB::select($sql);

		            	$dias = count($results);

	            		$sql = "SELECT * 	
								FROM registro_portales
								WHERE id_cliente = ".$cliente->id_cliente." 
								AND date_format(`fecha_registro`,'%m-%d-%Y') > date_format( '".$req->desde."' ,'%m-%d-%Y')";

						$results = DB::select($sql);	

		            	$registros = count($results);
                    	
		            	if($dias != 0)
		            		$acti = $registros/$dias;
		            	else
		            		$acti = 0;

		            	$acti = round($acti);

                    	$acti = (string)$acti." <small>por Dia</small>";
                	
                	}

                }else
                    if($req->hasta){

                        $req->hasta = (new DateTime($req->hasta))->format('Y-m-d');

                        if($req->cliente == 'Todos'){
							
							$sql = "SELECT * 	
									FROM registro_portales
									WHERE id_cliente != 1
									AND date_format(`fecha_registro`,'%m-%d-%Y') < date_format( '".$req->hasta."' ,'%m-%d-%Y')";

			            	$results = DB::select($sql);

			            	$registros = count($results);

			            	$clientes = Cliente::where('id_cliente','!=','1')->count();

    		            	if ($clientes != 0)
			            		$acti = $registros/$clientes;
			            	else
			            		$acti = 0;

			            	$acti = round($acti);

                        	$acti = (string)$acti." <small>por Cliente</small>";


		                }else{

    	            		$sql = "SELECT * 	
									FROM registro_portales
									WHERE id_cliente = ".$cliente->id_cliente."
									AND date_format(`fecha_registro`,'%m-%d-%Y') < date_format( '".$req->hasta."' ,'%m-%d-%Y')
						                GROUP BY date(`fecha_registro`)";

			            	$results = DB::select($sql);

			            	$dias = count($results);

    	            		$sql = "SELECT * 	
									FROM registro_portales
									WHERE id_cliente = ".$cliente->id_cliente." 
									AND date_format(`fecha_registro`,'%m-%d-%Y') < date_format( '".$req->hasta."' ,'%m-%d-%Y')";

							$results = DB::select($sql);	

			            	$registros = count($results);
                        	
			            	if($dias != 0)
		                		$acti = $registros/$dias;
		                	else
		                		$acti = 0;

		                	$acti = round($acti);

                        	$acti = (string)$acti." <small>por Dia</small>";
		                	
		                }

                    }else{

                        if($req->cliente == 'Todos'){

                        	$registros = RegistroPortales::where('id_cliente','!=','1')->count();

                        	$clientes = Cliente::where('id_cliente','!=','1')->count();

    		            	if ($clientes != 0)
			            		$acti = $registros/$clientes;
			            	else
			            		$acti = 0;

			            	$acti = round($acti);

                        	$acti = (string)$acti." <small>por Cliente</small>";

		                }else{

    	            		$sql = "SELECT * 	
									FROM registro_portales
									WHERE id_cliente = ".$cliente->id_cliente."
									GROUP BY date_format(`fecha_registro`,'%Y-%m-%d')";

			            	$results = DB::select($sql);

			            	$dias = count($results);

    	            		$sql = "SELECT * 	
									FROM registro_portales
									WHERE id_cliente = ".$cliente->id_cliente;

							$results = DB::select($sql);	

			            	$registros = count($results);

			            	if($dias != 0)
		                		$acti = $registros/$dias;
		                	else
		                		$acti = 0;

		                	$acti = round($acti);

                        	$acti = (string)$acti." <small>por Dia</small>";
		                	
		                }
                    }

            $registros = "Cantidad de Conexiones: <b>".(string)$registros."</b>";
            $array = array($acti, $registros);

            return $array;

        }
    }

    public function cantvisitantes()
    {
        if(Request::ajax()){

        	$req = Request::all();
            $req = json_encode($req);
            $req = json_decode($req);

            $req->cliente = ltrim($req->cliente);

            $cliente = Cliente::where('nombre', $req->cliente)->first();

            if($req->desde and $req->hasta){

                $req->desde = (new DateTime($req->desde))->format('Y-m-d');
                $req->hasta = (new DateTime($req->hasta))->format('Y-m-d');

                if($req->cliente == 'Todos'){

			        $sql = "SELECT *, min(fecha_registro) 
			        		FROM registro_portales 
			        		WHERE id_cliente != 1 AND id_usuario_ph IS NULL  
			        		AND  fecha_registro >= '".$req->desde."' AND fecha_registro <= '".$req->hasta."'
			        		GROUP BY email";

	    			$results = DB::select($sql);

					$acti = count($results);

                }else{
                	
                	$sql = "SELECT *, min(fecha_registro) 
				        		FROM registro_portales 
				        		WHERE id_cliente = ".$cliente->id_cliente." AND id_usuario_ph IS NULL 
				        		AND  fecha_registro >= '".$req->desde."' AND fecha_registro <= '".$req->hasta."'
				        		GROUP BY email";

	    			$results = DB::select($sql);

					$acti = count($results);

                }

            }else
                if($req->desde){

                    $req->desde = (new DateTime($req->desde))->format('Y-m-d');

                    if($req->cliente == 'Todos'){
     
				        $sql = "SELECT *, min(fecha_registro) 
				        		FROM registro_portales 
				        		WHERE id_cliente != 1 AND id_usuario_ph IS NULL  
				        		AND  fecha_registro >= '".$req->desde."'
				        		GROUP BY email";

		    			$results = DB::select($sql);

						$acti = count($results);

                	}else{
				        $sql = "SELECT *, min(fecha_registro) 
				        		FROM registro_portales 
				        		WHERE id_cliente = ".$cliente->id_cliente." AND id_usuario_ph IS NULL 
				        		AND  fecha_registro >= '".$req->desde."'
				        		GROUP BY email";

		    			$results = DB::select($sql);

						$acti = count($results);
                	}

                }else
                    if($req->hasta){

                        $req->hasta = (new DateTime($req->hasta))->format('Y-m-d');

                        if($req->cliente == 'Todos'){

					        $sql = "SELECT *, min(fecha_registro) 
					        		FROM registro_portales 
					        		WHERE id_cliente != 1 AND id_usuario_ph IS NULL  
					        		AND  fecha_registro <= '".$req->hasta."' GROUP BY email";

    		    			$results = DB::select($sql);

    						$acti = count($results);

		                }else{
		                	
					        $sql = "SELECT *, min(fecha_registro) 
					        		FROM registro_portales 
					        		WHERE id_cliente = ".$cliente->id_cliente." AND id_usuario_ph IS NULL 
					        		AND  fecha_registro <= '".$req->hasta."'
					        		GROUP BY email";

    		    			$results = DB::select($sql);

    						$acti = count($results);
		                
		                }

                    }else{
                        
                        if($req->cliente == 'Todos'){

					        $sql = "SELECT *, min(fecha_registro) 
					        		FROM registro_portales 
					        		WHERE id_cliente != 1 AND id_usuario_ph IS NULL  
					        		GROUP BY email";

    		    			$results = DB::select($sql);

    						$acti = count($results);

		                }else{

					        $sql = "SELECT *, min(fecha_registro) 
					        		FROM registro_portales 
					        		WHERE id_cliente = ".$cliente->id_cliente." AND id_usuario_ph IS NULL  
					        		GROUP BY email";

    		    			$results = DB::select($sql);

    						$acti = count($results);
		                	
		                }
                    }

            return $acti;
        }
    }

    public function cantidadregistros()
    {
    	if(Request::ajax()){

    		$req = Request::all();
    		$req = json_encode($req);
    		$req = json_decode($req);

    		$req->cliente = ltrim($req->cliente);

    		$cliente = Cliente::where('nombre', $req->cliente)->first();

    		if($req->desde and $req->hasta){

    			$req->desde = (new DateTime($req->desde))->format('Y-m-d');
    			$req->hasta = (new DateTime($req->hasta))->format('Y-m-d');

    			$sql = "SELECT * 	
    			FROM usuarios_ph, registro_portales
    			WHERE usuarios_ph.id_usuario_ph = registro_portales.id_usuario_ph
    			AND registro_portales.id_cliente != 1
    			AND date_format(registro_portales.fecha_registro,'%m-%d-%Y') between date_format( '".$req->desde."' ,'%m-%d-%Y') and date_format( '".$req->hasta."' ,'%m-%d-%Y') Group by usuarios_ph.id_usuario_ph";

    			$results = DB::select($sql);

    			$acti = count($results);
    		}else

	    		if($req->desde){

	    			$req->desde = (new DateTime($req->desde))->format('Y-m-d');

	    			$sql = "SELECT * 	
	    			FROM usuarios_ph, registro_portales
	    			WHERE usuarios_ph.id_usuario_ph = registro_portales.id_usuario_ph
	    			AND registro_portales.id_cliente != 1
	    			AND date_format(registro_portales.fecha_registro,'%m-%d-%Y') > date_format( '".$req->desde."' ,'%m-%d-%Y') Group by usuarios_ph.id_usuario_ph";

	    			$results = DB::select($sql);

	    			$acti = count($results);

	    		}else

		    		if($req->hasta){

		    			$req->hasta = (new DateTime($req->hasta))->format('Y-m-d');

		    			$sql = "SELECT * 	
		    			FROM usuarios_ph, registro_portales
		    			WHERE usuarios_ph.id_usuario_ph = registro_portales.id_usuario_ph
		    			AND registro_portales.id_cliente != 1
		    			AND date_format(registro_portales.fecha_registro,'%m-%d-%Y') < date_format( '".$req->hasta."' ,'%m-%d-%Y') Group by usuarios_ph.id_usuario_ph";

		    			$results = DB::select($sql);

		    			$acti = count($results);

		    		}else{

		    			$sql = "SELECT * 	
		    			FROM usuarios_ph, registro_portales
		    			WHERE usuarios_ph.id_usuario_ph = registro_portales.id_usuario_ph
		    			AND registro_portales.id_cliente != 1
		    			Group by registro_portales.id_usuario_ph";

		    			$results = DB::select($sql);

		    			$acti = count($results);

		    		}

    		return $acti;
    	}
    }

    public function conexfraudulentas()
    {
        if(Request::ajax()){

        	$req = Request::all();
            $req = json_encode($req);
            $req = json_decode($req);

            $req->cliente = ltrim($req->cliente);

            $cliente = Cliente::where('nombre', $req->cliente)->first();

            if($req->desde and $req->hasta){

                $req->desde = (new DateTime($req->desde))->format('Y-m-d');
                $req->hasta = (new DateTime($req->hasta))->format('Y-m-d');

                if($req->cliente == 'Todos'){
        			$sql = "SELECT `mac`, `id_registro`, Count(`mac`) as 'Conexiones', date(`fecha_registro`) as 'fecha' 
				                FROM `registro_portales` 
				                WHERE registro_portales.id_cliente != 1
				                AND date_format(`fecha_registro`,'%m-%d-%Y') between date_format( '".$req->desde."' ,'%m-%d-%Y') and date_format( '".$req->hasta."' ,'%m-%d-%Y')
				                GROUP BY `mac` 
				                HAVING ( COUNT(*) > 2)";

                	$results = DB::select($sql);

                	$acti = count($results);

                }else{

                	$sql = "SELECT `mac`, `id_registro`, Count(`mac`) as 'Conexiones', date(`fecha_registro`) as 'fecha' 
				                FROM `registro_portales` 
				                WHERE `id_cliente` = ".$cliente->id_cliente."
				                AND date_format(`fecha_registro`,'%m-%d-%Y') between date_format( '".$req->desde."' ,'%m-%d-%Y') and date_format( '".$req->hasta."' ,'%m-%d-%Y')
				                GROUP BY `mac` 
				                HAVING ( COUNT(*) > 2)";

                	$results = DB::select($sql);

                	$acti = count($results);
                	
                }

            }else
                if($req->desde){

                    $req->desde = (new DateTime($req->desde))->format('Y-m-d');

                    if($req->cliente == 'Todos'){

                			$sql = "SELECT `mac`, `id_registro`, Count(`mac`) as 'Conexiones', date(`fecha_registro`) as 'fecha' 
						                FROM `registro_portales`
						                WHERE registro_portales.id_cliente != 1 
						                AND date_format(`fecha_registro`,'%m-%d-%Y') > date_format( '".$req->desde."' ,'%m-%d-%Y')
						                GROUP BY `mac` 
						                HAVING ( COUNT(*) > 2)";

		                	$results = DB::select($sql);

		                	$acti = count($results);

                	}else{

	                	$sql = "SELECT `mac`, `id_registro`, Count(`mac`) as 'Conexiones', date(`fecha_registro`) as 'fecha' 
					                FROM `registro_portales` 
					                WHERE `id_cliente` = ".$cliente->id_cliente."
					                AND date_format(`fecha_registro`,'%m-%d-%Y') > date_format( '".$req->desde."' ,'%m-%d-%Y')
					                GROUP BY `mac` 
					                HAVING ( COUNT(*) > 2)";

	                	$results = DB::select($sql);

	                	$acti = count($results);
                	
                	}

                }else
                    if($req->hasta){

                        $req->hasta = (new DateTime($req->hasta))->format('Y-m-d');

                        if($req->cliente == 'Todos'){
        			      	$sql = "SELECT `mac`, `id_registro`, Count(`mac`) as 'Conexiones', date(`fecha_registro`) as 'fecha' 
						                FROM `registro_portales` 
						                WHERE registro_portales.id_cliente != 1
						                AND date_format(`fecha_registro`,'%m-%d-%Y') < date_format( '".$req->hasta."' ,'%m-%d-%Y')
						                GROUP BY `mac` 
						                HAVING ( COUNT(*) > 2)";

		                	$results = DB::select($sql);

		                	$acti = count($results);

		                }else{

		                	$sql = "SELECT `mac`, `id_registro`, Count(`mac`) as 'Conexiones', date(`fecha_registro`) as 'fecha' 
						                FROM `registro_portales` 
						                WHERE `id_cliente` = ".$cliente->id_cliente."
						                AND date_format(fecha_registro,'%m-%d-%Y') < date_format( '".$req->hasta."' ,'%m-%d-%Y')
						                GROUP BY `mac` 
						                HAVING ( COUNT(*) > 2)";

		                	$results = DB::select($sql);

		                	$acti = count($results);
		                	
		                }

                    }else{
                        
                        if($req->cliente == 'Todos'){

		                	 $sql = "SELECT `mac`, `id_registro`, Count(`mac`) as 'Conexiones', date(`fecha_registro`) as 'fecha' 
						                FROM `registro_portales`
						                WHERE registro_portales.id_cliente != 1
						                GROUP BY `mac` 
						                HAVING ( COUNT(*) > 2)";
		                	$results = DB::select($sql);

		                	$acti = count($results);

		                }else{

		                	$sql = "SELECT `mac`, `id_registro`, Count(`mac`) as 'Conexiones', date(`fecha_registro`) as 'fecha' 
						                FROM `registro_portales` 
						                WHERE `id_cliente` = ".$cliente->id_cliente."
						                GROUP BY `mac` 
						                HAVING ( COUNT(*) > 2)";

		                	$results = DB::select($sql);

		                	$acti = count($results);
		                	
		                }
                    }
            return $acti;
        }
    }

}
