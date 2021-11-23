<?php

namespace App\model;

use Illuminate\Database\Eloquent\Model;

class MessageApi extends Model
{
     public function Erro($titulo){
        return  response()->json([
         'status'=>400,
         'message'=>$titulo,
        ],400);
     }

     public function  Sucesso($value){
          return response()->json([
               'status'=>200 ,
               'message'=>'sucesso',
               'data'=>$value
           ],200);
     }
}
