<?php

namespace App\Http\Controllers;
use App\model\MessageApi;
use App\model\VendaModel;
use App\model\UsuarioModel;
use App\model\ProdutoModel;
use App\model\VendaProdutoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendaController extends Controller
{
    private $message = null;

    public function __construct()
    {
        $this->message =  new MessageApi();
    }


    public function Adicionar(Request $request){
         if($request !=  null){
              $usuarioModel = UsuarioModel::find($request['id_usuario']);
              if($usuarioModel !=  null){
                   $verifica_existe_produtos = $this->VerificaProdutos($request['produtos']);
                 if($verifica_existe_produtos){
                    $adicionar_venda  = [
                         "id_usuario"  =>$request['id_usuario'],
                         "total-venda" =>$this->TotalPreco($request['produtos']),
                         "quantidade-produtos" =>count($request['produtos']),
                         "id_usuario" =>$request['id_usuario'],
                         "estado-venda" =>"VENDIDO"
                    ];

                    $vendaModel = VendaModel::create($adicionar_venda);
                    $this->VendaProduto($vendaModel->id,$request['produtos'],$request['id_usuario']);
                    return $this->message->Sucesso($vendaModel);

                 }else{
                     return  $this->message->Erro('produto nao existe verifica');
                 }
              }else{
                return $this->message->Erro('Erro nenhum usuario encontrado!');
              }
         }else{
              return $this->message->Erro('nenhum paramentro enviado!');
          }
    }

    public function Obter($id){
        if($id !=  null ){
             $venda_model = VendaModel::find($id);
              if($venda_model !=null ){

                 $lista_produtos  =  $this->ProdutosVenda($id);
                 $lista_final_produto =  Array();
                 $venda = $this->Venda($id)[0];


                for($index = 0 ;  $index < count($lista_produtos);  ++$index){
                     $cada_venda_produto =  $lista_produtos[$index];
                     $cada_venda_produto ->produto =  $this->ProdutoNaVenda($lista_produtos[$index]->id_produto);
                     $usuario = $this->UsuarioVenda($cada_venda_produto->id_usuario)[0];
                     $usuario->roles =$this->RolesUsuario($cada_venda_produto->id_usuario);
                     $cada_venda_produto->usuario = $usuario;
                     Array_push($lista_final_produto, $cada_venda_produto);
                }

                $venda->produtos =  $lista_final_produto;
                return $this->message->Sucesso($venda);

              }else{
                  return $this->message->Erro('venda nao encontrada!');
              }
         }else{
            return $this->message->Erro('nenhum  paramentro passado');
        }
    }



    private function getVenda($id){
        if($id !=  null ){
              $venda_model = VendaModel::find($id);
             if($venda_model !=null ){

                $lista_produtos  =  $this->ProdutosVenda($id);
                $lista_final_produto =  Array();
                $venda = $this->Venda($id)[0];
               for($index = 0 ;$index <count($lista_produtos);  ++$index){
                    $cada_venda_produto =  $lista_produtos[$index];
                    $cada_venda_produto ->produto =  $this->ProdutoNaVenda($lista_produtos[$index]->id_produto);
                    $usuario = $this->UsuarioVenda($cada_venda_produto->id_usuario)[0];
                    $usuario->roles =$this->RolesUsuario($cada_venda_produto->id_usuario);
                    $cada_venda_produto->usuario = $usuario;
                    Array_push($lista_final_produto, $cada_venda_produto);
               }
               $venda->produtos =  $lista_final_produto;
               return  $venda;

             }else{
                 return $this->message->Erro('venda nao encontrada!');
             }
        }else{
           return $this->message->Erro('nenhum  paramentro passado');
       }
    }






    public  function  Listar(){
        $lista_venda = $this->TodasVendas();
        $lista_completa_venda = Array();
        for($index = 0; $index <count($lista_venda); ++$index){
              $cada_venda = $this->getVenda($lista_venda[$index]->id);
              Array_push($lista_completa_venda, $cada_venda);
        }
        return  $this->message->Sucesso($lista_completa_venda);
    }

    private function ProdutosVenda($id){
        //@id => id da venda
        // return =>[]
        $sql = "select * from venda_produtos vendp  where vendp.id_venda =".$id;
        return  DB::select($sql);
    }

    private function ProdutoNaVenda($id){
        //@id => id do produto
        // return  => []
        $sql ="select * from produtos p where p.id =".$id;
        return DB::select($sql);
    }


    private  function UsuarioVenda($id){

        $sql ="select * from users us  where us.id =".$id;
        return DB::select($sql);
    }


    private function RolesUsuario($id){
        $sql ="select * from  tipousuario tpus where  tpus.id_usuario =".$id;
        return DB::select($sql);
    }

    private function Venda($id){
        $sql ="select * from venda  v where v.id=".$id;
        return DB::select($sql);
    }


    private   function VendaProduto($id_venda ,$lista , $id_usuario){

        for($index = 0;  $index < count($lista) ;  ++$index){
             $produto_model  =  ProdutoModel::find($lista[$index]['id_produto']);
             $vendaprodutomodel = [
                 'preco'=>$produto_model->preco,
                 'quantidade-produto'=>$lista[$index]['quantidade'],
                 'id_usuario'=>$id_usuario,
                 'id_venda'=>$id_venda,
                 'total'=> $lista[$index]['quantidade'] * $produto_model->preco ,
                 'id_produto'=> $lista[$index]['id_produto'],
                 'estado-produto'=>"VENDIDO"
             ];
             $vendaprodutomodel = VendaProdutoModel::create($vendaprodutomodel);
        }

        return ;
   }


   private function VerificaProdutos($lista){
    $existe_produtos =  true;
    for($index =0;  $index  < count($lista); ++$index){
           $produto_existe  = ProdutoModel::find($lista[$index]['id_produto']);
           if($produto_existe  == null){
               $existe_produtos = false;
               break;
           }
    }

    return  $existe_produtos ;
}

private function TotalPreco($lista){
    $soma_total = 0;
    for($index =0;  $index  < count($lista); ++$index){
           $produto_existe  = ProdutoModel::find($lista[$index]['id_produto']);
           $soma_total = $soma_total +  ($lista[$index]['quantidade'] *  $produto_existe->preco);
    }
    return $soma_total;
}


private function  TodasVendas(){
     $sql ="select * from  venda";
     return DB::select($sql);

}

}
