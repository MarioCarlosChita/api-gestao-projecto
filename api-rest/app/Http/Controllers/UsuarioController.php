<?php

namespace App\Http\Controllers;

use App\model\MessageApi;
use App\model\TipoModel;
use App\model\TipoUsuarioModel;
use App\model\UsuarioModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class UsuarioController extends Controller
{
    private $message = null;

    public function __construct()
    {
        $this->message =  new MessageApi();
    }

    public  function listar()
    {
        $usuario =  DB::select("select us.* from users us
           inner join tipousuario tps on tps.id_usuario =  us.id
           inner join tipo tp on tp.id =tps.id_tipo
           where tp.nome  not like 'ADMIN%'  and tp.nome  not like '%FULL%' ");
        $listaUsuarios = array();
        for ($i = 0; $i < count($usuario); $i++) {
            $usertipo =  $usuario[$i];
            $usertipo->roles = $this->getRoles($usertipo->id);
            $usertipo->contactos =  $this->getContactos($usertipo->id);
            array_push($listaUsuarios, $usertipo);
        }

        return  $this->message->Sucesso($listaUsuarios);
    }



    public function  getAllAdmin()
    {
        $usuario =  DB::select("select us.* from users us
        inner join tipousuario tps on tps.id_usuario =  us.id
        inner join tipo tp on tp.id =tps.id_tipo
        where tp.nome   like 'ADMIN%' ");
        $listaUsuarios = array();
        for ($i = 0; $i < count($usuario); $i++) {
            $usertipo =  $usuario[$i];
            $usertipo->roles = $this->getRoles($usertipo->id);
            $usertipo->contactos =  $this->getContactos($usertipo->id);
            array_push($listaUsuarios, $usertipo);
        }
        return $this->message->Sucesso($listaUsuarios);
    }



    public function adicionar(Request $request)
    {
        if ($request !=  null) {
            $usuario = UsuarioModel::create(array_merge(
                $request->all(),
                ['password' => bcrypt($request->password)]
            ));

            $listaT =   array();
            for ($i = 0; $i < count($request->roles); ++$i) {
                $tipousuario = $this->getRolesCadastrado($request->roles[$i]);
                array_push($listaT, $tipousuario[0]);
            }

            $listatipos = array();
            $listaContactos = array();
            for ($i = 0; $i < count($listaT); ++$i) {
                $tipousuario = TipoUsuarioModel::create([
                    'nome' => $listaT[$i]->nome,
                    'descricao' => $listaT[$i]->descricao,
                    'id_usuario' => $usuario->id,
                    'id_tipo' => $listaT[$i]->id
                ]);
                array_push($listatipos, $tipousuario);
            }
            $listaContactos = $this->getContactos($usuario->id);
            $usuario->roles  = $listatipos;
            $usuario->Contactos = $listaContactos;
            return $this->message->Sucesso($usuario);
        } else {
            return $this->message->Erro('nenhum paramento enviado');
        }
    }

    public function getRolesCadastrado($id)
    {
        return DB::select('select * from  tipo where id =?', [$id]);
    }

    public function deletar($id)
    {
        if ($id  !=  null) {
            $tipo = UsuarioModel::find($id);
            if ($tipo != null) {
                $tipo->delete();
                return  $this->message->Sucesso($tipo);
            } else {
                return   $this->message->Erro('id invalido');
            }
        } else {
            return  $this->message->Erro('nenhum id passado');
        }
    }

    public function obter($id)
    {
        if ($id  !=  null) {
            $usuario = UsuarioModel::find($id);
            if ($usuario != null) {
                $usuario->contactos =  $this->getContactos($usuario->id);
                $usuario->roles = $this->getRoles($usuario->id);
                return  $this->message->Sucesso($usuario);
            } else {
                return   $this->message->Erro('id invalido');
            }
        } else {
            return  $this->message->Erro('nenhum id passado');
        }
    }

    public function Atualizar(Request $request, $id)
    {
        if ($id  !=  null) {
            $usuario = UsuarioModel::find($id);
            if ($usuario != null) {
                if ($request["password"] !=  null) {
                    $senha  = $request["password"];
                    $request["password"] = bcrypt($senha);
                }
                $usuario->update($request->all());
                $usuarioupdate  =  UsuarioModel::find($id);
                return $this->message->Sucesso($usuarioupdate);
            } else {
                return   $this->message->Erro('id invalido');
            }
        } else {
            return  $this->message->Erro('nenhum id passado');
        }
    }



    public function getRoles($id)
    {
        return  DB::select("select tp.nome, tp.descricao from tipousuario tpu  inner join tipo tp where tp.id =  tpu.id_tipo  and  tpu.id_usuario=?", [$id]);
    }



    private  function getContactos($id_usuario)
    {
        return  DB::select("select * from contactos where id_usuario=?", [$id_usuario]);
    }

    public function  getContactosUsuario($id)
    {
        return  $this->message->Sucesso(DB::select('select * from contactos  where  id_usuario=?', [$id]));
    }
}
