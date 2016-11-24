<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Cliente;
use App\Sector;
use Response;
use App\Tipo_cliente;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Session;
use Mail;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

      /**
     * Log the user out of the application.
     *
     * @return \Illuminate\Http\Response
     */
    public function getLogout()
    {
        $this->auth->logout();

        Session::flush();

        return redirect('/');
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function loginUsername()
    {
        return property_exists($this, 'username') ? $this->username : 'username';
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|unique:usuarios_web|max:20',
            'email' => 'required|email|unique:usuarios_web|max:255',
            'password' => 'required|confirmed|min:3',
            'cliente' => 'required|exists:clientes,alias',
            'nombre' => 'required',
            'rif' => 'required',
            'direccion' => 'required',
            'representante' => 'required',
            'email_representante' => 'required|email',
            'telefono' => 'required',
            'telefono_representante' => 'required',
            'ssid_wifi' => 'required',
            'password_portal' => 'required',
            'fecha_activacion' => 'required|date|after:tomorrow',
            // 'g-recaptcha-response' => 'required|captcha',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {

        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        Mail::send('auth.emails.userdata', ['user' => $user, 'pass' => $data['password']], function ($message) use ($user) {
            $message->from('no-reply@portalhook.com', 'PortalHook');

            $message->to($user->email, $user->name)->subject('Confirmacion Cliente PortalHook');
        });

        $cliente = Cliente::where('alias', '=', $data['cliente']);

        $cliente = $cliente->first();

        $cliente->id_usuario_web = $user->id_usuario_web;

        $cliente->nombre = $data['nombre'];
        $cliente->tax_number = $data['rif'];
        $cliente->direccion = $data['direccion'];
        $cliente->representante = $data['representante'];
        $cliente->email_rep = $data['email_representante'];
        $cliente->telefono = $data['telefono'];
        $cliente->telefono_rep = $data['telefono_representante'];
        $cliente->ssid_wifi = $data['ssid_wifi'];
        $cliente->password = $data['password_portal'];
        $cliente->id_tipo_cliente = $data['tipo'];
        $cliente->id_sector = $data['sector'];
        $cliente->fecha_activacion = $data['fecha_activacion'];
        $cliente->tipo_contrato = $data['tipo_contrato'];

        $cliente->save();

        return $user;
    }

    public function showRegistrationForm()
    {
        if (property_exists($this, 'registerView')) {
            return view($this->registerView);
        }

        $sectores = Sector::all();

        $tipo_clientes = Tipo_cliente::all();

        return view('auth.register',compact('sectores','tipo_clientes'));
    }

    public function getPremium()
    {
      $filename = 'test.pdf';
      $path = $filename;

      return Response::make(file_get_contents($path), 200, [
          'Content-Type' => 'application/pdf',
          'Content-Disposition' => 'inline; filename="'.$filename.'"'
      ]);
    }

    public function getBasic()
    {
      $filename = 'test.pdf';
      $path = $filename;

      return Response::make(file_get_contents($path), 200, [
          'Content-Type' => 'application/pdf',
          'Content-Disposition' => 'inline; filename="'.$filename.'"'
      ]);
    }

    public function verifyusername($user){

        $usuario = User::where('username', '=', $user);

        if($usuario->first()){
            return 'true';
        }
        return 'false';
    }

}
