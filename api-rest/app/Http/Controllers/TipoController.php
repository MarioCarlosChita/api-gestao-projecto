<?php

namespace App\Http\Controllers;
use App\model\MessageApi;
use App\model\TipoModel;
use Illuminate\Http\Request;

class TipoController extends Controller
{
    private $message = null;

    public function __construct()
    {
        $this->message =  new MessageApi();
        // $this->middleware('auth:api', ['except' => ['login','registro']]);
    }

    public  function listar()
    {
        $lista =  TipoModel::all();
        return $this->message->Sucesso($lista);
    }

    public function adicionar(Request $request)
    {
        if ($request !=  null) {
            if ($request->nome  !=  null  && $request->descricao !=  null) {
                $tipo = TipoModel::create($request->all());
                return $this->message->Sucesso($tipo);
            } else {
                return $this->message->Erro('paramentos invalidos');
            }
        } else {
            return  $this->message->Erro('nenhum parametro enviado');
        }
    }


    public function obter($id)
    {
        if ($id  !=  null) {
            $tipo = TipoModel::find($id);
            if ($tipo != null) {
                return  $this->message->Sucesso($tipo);
            } else {
                return   $this->message->Erro('id invalido');
            }
        } else {
            return  $this->message->Erro('nenhum id passado');
        }
    }

    public function  deletar($id)
    {
      if ($id  !=  null) {
            $tipo = TipoModel::find($id);
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

    public function Atualizar(Request $request, $id)
    {
        if ($id  !=  null) {
            $tipo = TipoModel::find($id);
            if ($tipo != null) {
                if ($request->nome  !=  null  && $request->descricao !=  null){
                    $tipo->update($request->all());
                    return $this->message->Sucesso($tipo);
                }else{
                    return  $this->message->Sucesso($tipo);
                }

            } else {
                return   $this->message->Erro('id invalido');
            }
        } else {
            return  $this->message->Erro('nenhum id passado');
        }
    }
}
