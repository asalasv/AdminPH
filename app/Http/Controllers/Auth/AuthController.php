<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Cliente;
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
            $message->from('alosalasv@gmail.com', 'PortalHook');

            $message->to($user->email, $user->name)->subject('Confirmacion Cliente PortalHook');
        });

        $cliente = Cliente::where('alias', '=', $data['cliente']);

        $cliente = $cliente->first();

        $cliente->id_usuario_web = $user->id_usuario_web;

        $cliente->save();

        return $user;
    }
}
