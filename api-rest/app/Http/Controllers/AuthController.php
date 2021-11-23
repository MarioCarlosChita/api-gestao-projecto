<?php

namespace App\Http\Controllers;

use App\model\MessageApi;
use Illuminate\Http\Request;
use Validator;
use App\User;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{


    private $messageApi;
    private $usuariocontroller;
    public function __construct()
    {
        $this->messageApi =  new MessageApi();
        $this->usuariocontroller =  new UsuarioController();
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:5',
        ]);
        if ($validator->fails()) {
            return  $this->messageApi->Erro($validator->messages());
        }
        if (!$token = auth()->attempt($validator->validated())) {
            return  $this->messageApi->Erro("Credencias invalidas");
        }
        return  $this->createNewToken($token);
    }

    public function registro(Request $request)
    {
        return $this->usuariocontroller->adicionar($request);
    }

    public function logout()
    {
        auth()->logout();
        return  $this->messageApi->Sucesso('Logout com Sucesso');
    }
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }


    protected function createNewToken($token)
    {
        $usuario =  auth()->user();
        $usuario->contactos = $this->getContactos($usuario->id);
        $usuario->roles =  $this->getTipoUsuario($usuario->id);
        return response()->json([
            'status' => 200,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'data' => $usuario,
            'message' => 'sucesso'
        ]);
    }

    public function perfil()
    {
        $usuario = auth()->user();
        if ($usuario !=  null) {
            $usuario->contactos = $this->getContactos($usuario->id);
            $usuario->roles =  $this->getTipoUsuario($usuario->id);
            return  $this->messageApi->Sucesso($usuario);
        }
        return  $this->messageApi->Erro('erro de autenticacao de usuario');
    }
    private  function getContactos($id_usuario)
    {
        return  DB::select("select * from contactos where id_usuario=?", [$id_usuario]);
    }

    public function getTipoUsuario($id_usuario)
    {
        return DB::select("select tp.nome, tp.descricao from tipousuario tpu  inner join tipo tp where tp.id =  tpu.id_tipo  and  tpu.id_usuario=?", [$id_usuario]);
    }
}
