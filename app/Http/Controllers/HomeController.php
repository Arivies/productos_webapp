<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;


class HomeController extends Controller
{
    public function showlogin()
    {
        /*Verifica si en la session existe una variable access_toen */
        $tkn=session()->has('access_token');
        if ($tkn){
           return redirect()->route('dashboard');
        } else {
            // El usuario no está autenticado, redirige a la página de inicio de sesión
            return view('login');
        }
    }

    public function login(Request $request)
    {
        // Realizar solicitud para obtener token de acceso
        $response = Http::asForm()->post('http://productos_webapp.local:81/api/login',[
                'grant_type' => 'password',
                'client_id' => config('services.passport.client_id'),
                'client_secret' => config('services.passport.client_secret'),
                'email' => $request->email,
                'password' =>$request->password,
        ]);

        if(!$response->json('success')){
            return redirect()->route('showlogin')->with('error',$response->json('message'));
        }
            // Almacenar el token de acceso en la sesión
            $accessToken = $response->json()['access_token'];
            $usuario = $response->json()['name'];
            Session::put('usuario',$usuario);
            Session::put('access_token', $accessToken);

            return redirect()->route('dashboard');
    }

    public function logout()
    {
        // Eliminar el token de acceso de la sesión
        Session::forget('access_token');
        return redirect()->route('showlogin');
    }

    public function registraUsuario(){

        return view('registraUsuario');
    }

    public function registro(Request $request)
    {
        // Realizar solicitud para registrar usuario
        $response = Http::asForm()->post('http://productos_webapp.local:81/api/registro',[
                'grant_type' => 'password',
                'client_id' => config('services.passport.client_id'),
                'client_secret' => config('services.passport.client_secret'),
                'name' => $request->name,
                'email' => $request->email,
                'password' =>$request->password,
        ]);
        return redirect()->route('showlogin');
    }

    public function dashboard()
    {
        $tkn=session()->has('access_token');
        if ($tkn) {
            // El usuario está autenticado
          return view('dashboard',['usuario' => Session::get('usuario') ]);
        } else {
            // El usuario no está autenticado, redirige a la página de inicio de sesión
           return redirect()->route('showlogin');
        }
    }

    public function listaUsuarios(){

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' =>'Bearer '.session('access_token')
        ])
        ->get('http://productos_webapp.local:81/api/index',[
            'grant_type' => 'password',
            'client_id' => config('services.passport.client_id'),
            'client_secret' => config('services.passport.client_secret'),
        ]);
        $usuarios =$response->json(['data']);
        return view('users.index',['usuarios'=>$usuarios ]);
    }

    public function muestraUsuario($id){

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' =>'Bearer '.session('access_token')
        ])->post('http://productos_webapp.local:81/api/show/'.$id,[
            'grant_type' => 'password',
            'client_id' => config('services.passport.client_id'),
            'client_secret' => config('services.passport.client_secret'),
        ]);
        $usuario =$response->json(['data']);
        return view('users.show',['usuario'=>$usuario ]);
    }

    public function editaUsuario($id){

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' =>'Bearer '.session('access_token')
        ])->post('http://productos_webapp.local:81/api/edit/'.$id,[
            'grant_type' => 'password',
            'client_id' => config('services.passport.client_id'),
            'client_secret' => config('services.passport.client_secret'),
        ]);
        $usuario =$response->json(['data']);
      //  dd($usuario);
        return view('users.edit',['usuario'=>$usuario ]);
    }

    public function actualizaUsuario(Request $request){

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' =>'Bearer '.session('access_token')
        ])->put('http://productos_webapp.local:81/api/actualiza/'.$request->id,[
            'grant_type' => 'password',
            'client_id' => config('services.passport.client_id'),
            'client_secret' => config('services.passport.client_secret'),
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> $request->password,
            'ant_password'=> $request->ant_password,

        ]);
       // $usuario =$response->json();
       // dd($usuario);
        return redirect()->route('listaUsuarios');
    }

    public function eliminarUsuario($id){

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' =>'Bearer '.session('access_token')
        ])->delete('http://productos_webapp.local:81/api/elimina/'.$id,[
            'grant_type' => 'password',
            'client_id' => config('services.passport.client_id'),
            'client_secret' => config('services.passport.client_secret'),
        ]);
        $usuario =$response->json();
        //dd($usuario);
        return redirect()->route('listaUsuarios')->with('error','error en la captura de datos');
    }


}
