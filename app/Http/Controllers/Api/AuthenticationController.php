<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class AuthenticationController extends Controller
{
    public function __construct(){
        //Se aplica middleare de usuarios autenticados a nivel controlador
        //excluyendo la funcion login y store
        $this->middleware('auth:api',['except' => ['login','store']]);
    }


    public function index(){

        /*Obtiene  el nombre y correo de los usuarios creados */
        $data = User::select('id','name','email')->get();
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => 'listado de usuarios',
            ], 200);
    }

    public function login(Request $request){
        /*Se verifica si es valida la autenticacion*/
        if(Auth::attempt(['email' => $request->email, 'password' =>  $request->password ])){

            /*Se obtiene el usuario autenticado*/
            $user = Auth::user();

            /*Retorna nombre del usuario autenticado
            y el token generado*/
            return response()->json([
                'success' => true,
                'name' => $user->name,
                'access_token' => $user->createToken('access_token')->accessToken,
                'message' => 'Usuario autenticado correctamente!',
            ], 200);
        }
        /*Mensaje de error en caso de fallar la autenticacion*/
        return response()->json([
            'success' => false,
            'message' => 'Error al autenticar usuario!',
        ], 400);
    }

    public function logout(){
        /*Se obtiene el token del usuario autenticado y se elimina*/
        $token = auth()->user()->token();
        $token->revoke();

        /*Retorna mensaje donde cerro la sesion correctamente*/
        return response()->json([
            'success' => true,
            'message' => 'Cerro sesion correctamente!',
        ], 200);
    }

    public function store(Request $request){

        /*Obtiene el objeto request, valida los datos enviados*/
        $validate=Validator::make($request->all(),([
          'name'=>'required|string|max:255',
          'email'=>'required|string|email|max:255|unique:users',
          'password'=>'required|string'
        ]));

        /*Si falla la validacion retorna mensaje de error*/
        if($validate->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el registro!',
            ], 400);
        }
        /*Asigna el objeto a una variable para encriptar contraseña, y despues
        registra el usuario*/
        $req = $request->all();
        $req['password'] = bcrypt($req['password']);
        $user = User::create($req);

        /*Retorna mensaje de registro exitoso, asi como el token y nombre del
        usuario*/
        return response()->json([
            'success' => true,
            'name' =>$user->name,
            'token' =>$user->createToken('access_token')->accessToken,
            'message' => 'Usuario registrado correctamente!',
        ], 200);
    }

    public function show($id){

        $user = User::find($id);
        if(is_null($user)){
            return response()->json([
                'success' => false,
                'message' => 'No se encontro el usuario',
            ], 400);
        }

        /*Retorna los datos del usuario solicitado*/
        return response()->json([
            'success' => true,
            'data' => $user,
        ], 200);

    }

    public function edit($id){

        $user = User::find($id);
        //$user = User::select('id','name','email','password')->where('id', $id)->get();

        if(is_null($user)){
            return response()->json([
                'success' => false,
                'message' => 'No se encontro el usuario',
            ], 400);
        }

        /*Retorna los datos del usuario solicitado*/
        return response()->json([
            'success' => true,
            'data' => $user,
        ], 200);
    }

    public function actualiza(Request $request, $id){

        /*Obtiene el objeto request, valida los datos enviados*/
           $validate=Validator::make($request->all(),([
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255',
        ]));

        /*Si falla la validacion retorna mensaje de error*/
        if($validate->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el usuario!',
            ], 400);
        }

        /*Se crea array con los nombres de los archivos para asociarlos al objeto que se actualizara */
        $data['name'] = $request->name;
        $data['email'] = $request->email;

        /*Valido si el usuario cambio la contraseña o no, si no la cambia se respeta la anterior
        si el usuario cambia la contraseña encripta el nuevo password*/
        $password= bcrypt($request->password);
        if(is_null($request->password)){
            $password=$request->ant_password;
        }
        $data['password'] =$password;

        User::find($id)->update($data);
        //$res=User::find($id);

       /*Retorna los datos del usuario solicitado*/
       return response()->json([
            'success' => true
            ], 200);
    }

    public function elimina($id){
        //return response()->json($id);
        $res = User::find($id)->delete();
        if(!$res){

            /*Si falla al borrar usuario envia mensaje de error*/
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar usuario!',
            ], 400);
        }

         /*Si se borro correctamente retorna mensaje de confirmacion*/
         return response()->json([
            'success' => true,
            'message' => 'Usuario eliminado correctamente!',
        ], 200);

    }
}
