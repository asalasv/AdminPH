<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::post('password/email','Auth\PasswordController@postEmail');

Route::get('contract/premium','Auth\AuthController@getPremium');

Route::get('contract/basic','Auth\AuthController@getBasic');

Route::get('verifyusername/{user}',[
		'as' => 'verifyusername',
		'uses' => 'Auth\AuthController@verifyusername'
]);

Route::group(['middleware' => ['web']], function () {

	/*
	|--------------------------------------------------------------------------
	| Authentication Routes
	|--------------------------------------------------------------------------
	*/

	Route::auth();

 	Route::get('ph-admin-newUserWebRegister', [
	    'as' => 'ph-admin-newUserWebRegister', 'uses' => 'Auth\AuthController@showRegistrationForm'
	]);

	Route::get('/register', function () {
		return redirect('/');
	});

	/*
	|--------------------------------------------------------------------------
	| Application Routes
	|--------------------------------------------------------------------------
	|
	| This route group applies the "web" middleware group to every route
	| it contains. The "web" middleware group is defined in your HTTP
	| kernel and includes session state, CSRF protection, and more.
	|
	*/

    Route::get('/home', 'HomeController@index');

	Route::get('/', function () {
		if (Auth::guest())
		{
		    return view('auth/login');
		}
		return redirect('/home');
	});

	Route::get('excel','ExcelController@index');

	Route::get('password/email','Auth\PasswordController@getEmail');
	Route::post('password/email','Auth\PasswordController@getEmail');

	/*
	|--------------------------------------------------------------------------
	| Sessiones Modulo Routes
	|--------------------------------------------------------------------------
	*/

	Route::get('sesiones','SessionsController@index');

	Route::post('desconectar/{sesion}',[
	    'as' => 'desconectar',
	    'uses' => 'SessionsController@desconectar'
	]);

	Route::post('bloquear/{mac}/{sesion}/{descr}',[
	    'as' => 'bloquear',
	    'uses' => 'SessionsController@bloquear'
	]);

	Route::post('desblock/{mac}/{orden}',[
	    'as' => 'desblock',
	    'uses' => 'SessionsController@desblock'
	]);

	Route::post('habilitar/{mac}',[
	    'as' => 'habilitar',
	    'uses' => 'SessionsController@habilitar'
	]);

	Route::get('gestion','SessionsController@gestionindex');

	Route::post('bloqueodesbloqueo/{mac}/{act}/{descr}/{orden}',[
	    'as' => 'bloqueodesbloqueo',
	    'uses' => 'SessionsController@bloqueodesbloqueo'
	]);

	/*
	|--------------------------------------------------------------------------
	| Usuarios Modulo Routes
	|--------------------------------------------------------------------------
	*/
	Route::get('singout', 'Auth\AuthController@getLogout');

	Route::get('/usuarios','UsuariosController@index');
	Route::post('/postusuario/{email}',[
	    'as' => 'postusuario',
	    'uses' => 'UsuariosController@add'
	]);
	Route::delete('deleteusuario/{id}',[
	    'as' => 'deleteusuario',
	    'uses' => 'UsuariosController@destroy'
	]);
	Route::get('verifyemail/{email}',[
	    'as' => 'verifyemail',
	    'uses' => 'UsuariosController@verifyemail'
	]);
	Route::post('changestatus',[
	    'as' => 'changestatus',
	    'uses' => 'UsuariosController@changestatus'
	]);

	Route::post('selectclient/{id}',[
		'as' => 'selectclient',
		'uses' => 'ClientesController@select'
	]);

	Route::post('changestatusph/{id}',[
	    'as' => 'changestatusph',
	    'uses' => 'UsuariosController@changestatusph'
	]);

	Route::post('habilitarph/{id}',[
	    'as' => 'habilitarph',
	    'uses' => 'UsuariosController@habilitarph'
	]);

	Route::post('inhabilitarph/{id}',[
	    'as' => 'inhabilitarph',
	    'uses' => 'UsuariosController@inhabilitarph'
	]);

	Route::post('asignargrupo/{id}/{group}',[
	    'as' => 'asignargrupo',
	    'uses' => 'UsuariosController@asignargrupo'
	]);

	Route::post('changestatusgroup/{group}/{status}',[
	    'as' => 'changestatusgroup',
	    'uses' => 'UsuariosController@changestatusgroup'
	]);

	Route::post('deletegroup/{group}/',[
	    'as' => 'deletegroup',
	    'uses' => 'UsuariosController@deletegroup'
	]);

	Route::post('updatehour/',[
	    'as' => 'updatehour',
	    'uses' => 'UsuariosController@updatehour'
	]);

	/*
	|--------------------------------------------------------------------------
	| Emailing Modulo Routes
	|--------------------------------------------------------------------------
	*/

	Route::get('/e-mailing','EmailingController@index');

	Route::get('/verify-email','EmailingController@getverify');

	Route::post('channge-email-verify',[
	    'as' => 'channge-email-verify',
	    'uses' => 'EmailingController@verify'
	]);

	/*
	|--------------------------------------------------------------------------
	| Indicadores Modulo Routes
	|--------------------------------------------------------------------------
	*/

	Route::get('/indicadores','IndicadoresController@index');

	Route::get('conexionesprom', 'IndicadoresController@conexionesprom');
	Route::get('registroprom', 'IndicadoresController@registroprom');
	Route::get('cantvisitantes', 'IndicadoresController@cantvisitantes');
	Route::get('cantidadregistros', 'IndicadoresController@cantidadregistros');
	Route::get('conexfraudulentas', 'IndicadoresController@conexfraudulentas');

	/*
	|--------------------------------------------------------------------------
	| Graficas Modulo Routes
	|--------------------------------------------------------------------------
	*/

	Route::get('lastweekreg', 'GraphicsController@lastweekreg');
	Route::get('lastweekreg/get', 'GraphicsController@getlastweekreg');

	Route::get('newlastweekreg', 'GraphicsController@newlastweekreg');
	Route::get('newlastweekreg/get', 'GraphicsController@getnewlastweekreg');

	Route::get('connectlastweek', 'GraphicsController@connectlastweek');
	Route::get('connectlastweek/get', 'GraphicsController@getconnectlastweek');

	Route::get('portalhookuserreg', 'GraphicsController@portalhookuserreg');
	Route::get('portalhookuserreg/get', 'GraphicsController@getportalhookuserreg');

	Route::get('sexportalhookuserreg', 'GraphicsController@sexportalhookuserreg');
	Route::get('sexportalhookuserreg/get', 'GraphicsController@getsexportalhookuserreg');

	Route::get('coneccfraudulentas', 'GraphicsController@coneccfraudulentas');
	Route::get('coneccfraudulentas/get', 'GraphicsController@getconeccfraudulentas');

	Route::get('recurrenciaporc', 'GraphicsController@recurrenciaporc');
	Route::get('recurrenciaporc/get', 'GraphicsController@getrecurrenciaporc');

	Route::get('dispmasconect', 'GraphicsController@dispmasconect');
	Route::get('dispmasconect/get', 'GraphicsController@getdispmasconect');

	/*
	|--------------------------------------------------------------------------
	| Portales Modulo Routes
	|--------------------------------------------------------------------------
	*/

	Route::get('/portales','PortalesController@index');

	Route::get('/newportal',[
	    'as' => 'newportal',
	    'uses' => 'PortalesController@newportal'
	]);
	Route::post('/newportal',[
	    'as' => 'newportal',
	    'uses' => 'PortalesController@store'
	]);

	Route::get('/editportal/{id_portal_cliente}',[
	    'as' => 'portal',
	    'uses' => 'PortalesController@editportal'
	]);
	Route::put('/editportal/{id_portal_cliente}',[
	    'as' => 'editportal',
	    'uses' => 'PortalesController@update'
	]);
	Route::delete('/deleteportal/{id_portal_cliente}',[
	    'as' => 'deleteportal',
	    'uses' => 'PortalesController@destroy'
	]);

	Route::get('/predeterminado', 'PortalesController@predeterminado');

	Route::get('/manejo_portal', 'PortalesController@manejo_portal');
	Route::put('/updatemanejo_portal',[
			'as' => 'updatemanejo_portal',
			'uses' => 'PortalesController@updatemanejo_portal'
	]);

	/*
	|--------------------------------------------------------------------------
	| Configuración Modulo Routes
	|--------------------------------------------------------------------------
	*/

	Route::get('changepass','SettingsController@changepass');
	Route::put('/changepass',[
	    'as' => 'changepass',
	    'uses' => 'SettingsController@updatepass'
	]);

	Route::get('portalpass','SettingsController@portalpass');
	Route::put('/updateportalpass',[
	    'as' => 'updateportalpass',
	    'uses' => 'SettingsController@updateportalpass'
	]);

	/*
	|--------------------------------------------------------------------------
	| Cliente Modulo Routes
	|--------------------------------------------------------------------------
	*/

	Route::get('cliente/logo', 'ClientesController@imglogo');
	Route::post('cliente/logo',[
	    'as' => 'cliente/logo', 'uses' => 'ClientesController@updateimglogo'
	]);

	/*
	|--------------------------------------------------------------------------
	| Email Certification Routes
	|--------------------------------------------------------------------------
	*/

 	Route::get('/emailcertification', 'CertificationEmailController@index');

	Route::post('changevalidate',[
	    'as' => 'changevalidate',
	    'uses' => 'CertificationEmailController@changevalidate'
	]);

	/*
	|--------------------------------------------------------------------------
	| Email Certification Routes
	|--------------------------------------------------------------------------
	*/
	// Route::get('api','CallendarController@api'); //ruta que nos devuelve los eventos en formato json

	Route::get('api',[
	    'as' => 'api',
	    'uses' => 'CallendarController@api'
	]);
});
