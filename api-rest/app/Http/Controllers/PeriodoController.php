<?php

namespace App\Http\Controllers;
use App\model\MessageApi;
use App\model\PeridoModel;
use Illuminate\Http\Request;

class PeriodoController extends Controller
{
    private $message = null;
    public function __construct()
    {
        $this->message =  new MessageApi();
    }



    public function Listar(){
        $lista =PeridoModel::all();
        return $this->message->Sucesso($lista);
    }

    public function  Adicionar(Request $request){
        if($request != null){
             $add = PeridoModel::create($request->all());
             return $this->message->Sucesso($add);
        }else{
             return  $this->message->Erro('nenum paramentro enviando');
        }
    }


    public function  Deletar($id){
        if($id != null ){
                  $periodo = PeridoModel::find($id);
                if($periodo ==  null){
                   return $this->message->Erro('id invalido');
                } else{
                    $periodo->delete();
                    return $this->message->Sucesso($periodo);
                }
        }else{
            return $this->message->Erro('nenhum id enviado');
        }

    }


    public function Atualizar(Request  $request , $id){
        if($id != null ){
            $periodo = PeridoModel::find($id);
            if($periodo ==  null){
                return $this->message->Erro('id invalido');
            } else{
                $periodo->update($request->all());
                return $this->message->Sucesso($periodo);
            }
        }else{
            return $this->message->Erro('nenhum id enviado');
        }
    }



    public function Obter($id){
        if($id != null ){
             $periodo = PeridoModel::find($id);
            if($periodo ==  null){
                return $this->message->Erro('id invalido');
            } else{
                return $this->message->Sucesso($periodo);
            }
        }else{
            return $this->message->Erro('nenhum id enviado');
        }
    }

}
