<?php

namespace App\Http\Controllers;
use App\model\MessageApi;
use App\model\UsuarioModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class FuncionarioController extends Controller
{

    private $messageApi;
    public function __construct()
    {
        $this->messageApi =  new MessageApi();
    }

    public function listar(){
      $lista  =  Array();
      $lista_funcionario = $this->allUsers();
      for($index = 0; $index < count($lista_funcionario) ; ++$index){
          $funcionario  = $lista_funcionario[$index];
          $funcionario->contactos =$this->funcionarioContactos($funcionario->id);
          $funcionario->roles =  $this->RolesFuncionario($funcionario->id);
          Array_push($lista, $funcionario);
      }
      return $this->messageApi->Sucesso($lista);
    }


    public function allUsers(){
        $lista =   DB::select('select us.id,us.nome,us.email,us.foto_url from users  us
                              inner join tipousuario tps on
                              us.id =  tps.id_usuario
                              inner join tipo tp
                              on tp.id = tps.id_tipo
                              where tp.nome = "FUNCIONARIO"');

       return $lista;

    }

  // pegando contactos  de um usuario
    public function funcionarioContactos($id_usuario){
         $sql="select * from contactos con where con.id_usuario=".$id_usuario;
         $contactos = DB::select($sql);
         return $contactos;
    }

    // pegando as roles do usuario
    public function RolesFuncionario($id_usuario){
         $sql ="select * from tipo tp  inner join tipousuario tps
           on tps.id_tipo=tp.id where tps.id_usuario=".$id_usuario;
         $lista_roles =  DB::select($sql);
         return $lista_roles;
    }

    public function funcionarioVendas($id_usuario){
      if($id_usuario != null){
            $funcionario = UsuarioModel::find($id_usuario);
            if($funcionario !=  null){

                 // lista das minhas vendas
                 $listavenda = $this->Venda($funcionario->id);
                 // lista final de saida
                 $listaVendaFinal  = Array();

                 for($index = 0 ; $index  < count($listavenda); ++$index){
                       $cada_venda = $listavenda[$index];
                       $cada_venda->produtos = $this->VendaProdutos($cada_venda->id);
                       Array_push(listaVendaFinal ,$cada_venda);
                 }

                 $funcionario->vendas = $listaVendaFinal;
                 return $this->messageApi->Sucesso($funcionario);


            }else{
                return $messageApi->Erro("id invalido");
            }

      }else{
        return $messageApi->Erro("nenhum paramentro passado");
      }
    }

    public function Venda($id_usuario){
        $sql= "select * from venda ven where ven.id_usuario =".$id_usuario;
        $listaVendas =  DB::select($sql);
        return  $listaVendas;
    }

    public function VendaProdutos($id_venda){
         $sql = "select * from venda-produtos  vendp where vendp.id_venda=".$id_venda;
         $vendaProdutos = DB::select($sql);
         return $vendaProdutos;
    }


}
