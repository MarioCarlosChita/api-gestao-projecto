<?php

namespace App\Http\Controllers;

use App\model\DashboardModel;
use App\model\MessageApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{


    private  $message = null;
    public  function __construct(){
        // $this->middleware('auth:api', ['except' => ['login', 'registro']]);
        $this->message = new  MessageApi();
    }


    public function listar(){
        $usuarios =  DB::select("select count(*) as usuarios
        from users us inner
        join tipousuario tp on tp.id_usuario = us.id inner
        join tipo tpps on tpps.id = tp.id_tipo
        where tpps.nome not like '%ADMIN%'  and tpps.nome not like '%FULL%'"
      );
        $imoveis =   DB::select('select count(*) as imoveis  from  imovel');
        $filtros =   DB::select('select count(*) as filtros  from filtro');
        $venda =  DB::select('select  count(*) as  vendas from  venda');
        $arrendamento  =  DB::select('select  count(*) as arrendamentos from arrendamento');

        $dashboard =  new  DashboardModel() ;
        $dashboard->usuarios =  $usuarios ;
        $dashboard->imoveis =    $imoveis ;
        $dashboard->filtros  = $filtros;
        $dashboard->venda  =   $venda;
        $dashboard->arrendamento  =  $arrendamento;

        $lista =  array();

        array_push($lista , $dashboard);


        return $this->message->Sucesso($lista);
    }
}
