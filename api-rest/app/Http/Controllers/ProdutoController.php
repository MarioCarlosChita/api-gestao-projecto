<?php

namespace App\Http\Controllers;
use App\model\MessageApi;
use App\model\ProdutoModel;
use App\model\HistoricoProdutoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdutoController extends Controller
{
    private $messageApi;
    public function __construct()
    {
        $this->messageApi =  new MessageApi();
    }


    public function Adicionar(Request $request){
          if($request !=  null){

             try{
                $produto = ProdutoModel::create($request->all());
             }catch(\PDOException $error){
                 if($error->getCode()== 23000){
                   return $this->messageApi->Erro('ja existe um produto  com o mesmo nome!');
                 }
             }
               // criando o historico dos dados
               $produto_historico =  Array();
               $produto_historico['id_usuario']=  $produto->id_usuario;
               $produto_historico['nome'] = $produto->nome;
               $produto_historico['descricao'] = $produto->descricao;
               $produto_historico['imagem'] =  $produto->imagem;
               $produto_historico['preco'] = $produto->preco;
               $produto_historico['quantidade'] = $produto->quantidade;
               $historico_produto_adicionar = HistoricoProdutoModel::create($produto_historico);
               if($produto !=  null && $historico_produto_adicionar  != null){
                   return $this->messageApi->Sucesso($produto);
               }else{
                   return $this->$messageApi->Erro('erro de cadastro de produto');
               }
          }else{
             $this->message->Erro('nenhum paramentro inviado!');
          }
    }

    public function  deletar($id){
          if($id != null){
                $produto  = ProdutoModel::find($id);
            if($produto != null){
                $produto_historico =  Array();
                $produto_historico['id_usuario']=  $produto->id_usuario;
                $produto_historico['nome'] = $produto->nome;
                $produto_historico['descricao'] = $produto->descricao;
                $produto_historico['imagem'] =  $produto->imagem;
                $produto_historico['quantidade'] = $produto->quantidade;
                $produto_historico['preco']= $produto->preco;
                $produto_historico['historico-estado']= "DELETADO";
                $historico_produto_adicionar = HistoricoProdutoModel::create($produto_historico);
                $produto->delete();
                return $this->messageApi->Sucesso('Deletado com Sucesso!');
            }else{
                return $this->messageApi->Erro('este produto nao existe');
            }
          }else{
                return $this->messageApi->Erro('nenhum paramentro passado');
          }
    }

    public function  atualizar(Request $request ,$id){
          if($request !=  null){
            if($id != null){
                $produto =  ProdutoModel::find($id);
                if($produto  !=  null){
                    $produto->update($request->all());
                    $produto_historico =  Array();
                    $produto_historico['id_usuario']=  $produto->id_usuario;
                    $produto_historico['nome'] = $produto->nome;
                    $produto_historico['descricao'] = $produto->descricao;
                    $produto_historico['imagem'] =  $produto->imagem;
                    $produto_historico['quantidade'] = $produto->quantidade;
                    $produto_historico['preco'] = $produto->preco;
                    $produto_historico['historico-estado']= "ATUALIZADO";
                    $historico_produto_adicionar = HistoricoProdutoModel::create($produto_historico);
                    return  $this->messageApi->Sucesso($produto);
                }else{
                    return $this->messageApi->Erro('este produto nao existe');
                }
          }else{
             return $this->messageApi->Erro('nenhum paramentro passado!');
           }

           }else{
             return $this->messageApi->Erro('nenhum paramentro passado');
           }
    }


    public  function obter($id){
        if($id != null){
            $produto =  ProdutoModel::find($id);
            if($produto  !=  null){
                return  $this->messageApi->Sucesso($produto);
            }else{
                return $this->messageApi->Erro('este produto nao existe');
            }
    }}

    public function  listar(){
        $lista_produto = ProdutoModel::all();
        $lista_final =  Array();
        for($index  = 0 ; $index < count($lista_produto); ++$index){
             $cada_produto = $lista_produto[$index];
             $usuario_cadastro_produto =  $this->UsuarioCadastraProduto($cada_produto->id_usuario);
             $usuario_cadastro_produto->roles =$this->RolesUsuaio($cada_produto->id_usuario);
             $cada_produto->usuario = $usuario_cadastro_produto;
             Array_push($lista_final,$cada_produto);
        }
        return $lista_final;
    }

    private function UsuarioCadastraProduto($id){
        $sql = "select  us.nome,us.email,us.foto_url
                  from  users us  inner join tipousuario tps
                  on tps.id_usuario = us.id
                  where  us.id = ".$id;

        $usuario =DB::select($sql);
        return  $usuario[0];
    }


    public function  RolesUsuaio($id){
        $sql = "select * from tipousuario tp   where tp.id_usuario = ".$id;
        $lista_roles= DB::select($sql);
        return  $lista_roles;
    }

}
