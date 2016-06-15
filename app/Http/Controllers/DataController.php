<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Data;
use App\User;

class DataController extends Controller
{

    public function index(Request $request)
    {
      if(isset($request->token)){
        $search = \Request::get('s'); //<-- use global request
        $dari = \Request::get('dari'); //<-- use global request
        $ke = \Request::get('ke'); //<-- use global request
        $tahun = \Request::get('tahun'); //<-- use global request
        $users_id = $this->tokenToId($request->token);

        if(isset($search)){
        $data = Data::where('users_id',$users_id)
                ->where(function($query){
                  $search = \Request::get('s');
                  $query->orWhere('desc','like','%'.$search.'%')
                  ->orWhere('value','like','%'.$search.'%')
                  ->orWhere('date','like','%'.$search.'%')
                  ->orWhere('bill','like','%'.$search.'%');
                })
                ->orderBy('date','desc');
        }
        elseif (isset($dari) and isset($ke)) { //SELESAI search date dari ke
            $dari = \Request::get('dari'); //<-- use global request
          $ke = \Request::get('ke'); //<-- use global request
          $data = Data::where('users_id',$users_id)->whereBetween('date',[$dari,$ke])->orderBy('date','desc');
        }
        elseif (isset($tahun)) { //SELESAI search tahun
          $tahun = \Request::get('tahun'); //<-- use global request
          $data = Data::where('users_id',$users_id)->where('date','like','%'.$tahun.'%')->orderBy('date','desc');
        }

        else{
          $data = Data::where('users_id',$users_id)->orderBy('date','desc');
        }
        return json_encode($data->get());
      }else{
        return json_encode(array('status'=>'error','description'=>'not found'));
      }
    }
    public function create()
    {
        return json_encode(array('status'=>'error','description'=>'not found'));
    }

    public function store(Request $request)
    {

      if(isset($request->token)){
        $users_id = $this->tokenToId($request->token);
        Data::create($request->all());
        
        return json_encode(array('status'=>'success','description'=>'Data Saved'));
      }else{
        return json_encode(array('status'=>'error','description'=>'token not found'));
      } 
    }

   
    public function show(Request $request,$id)
    {
      if(isset($request->token)){
        $users_id = $this->tokenToId($request->token);
        $data = Data::where('id',$id)->where('users_id',$users_id);
        return json_encode($data->get());
      }else{
        return json_encode(array('status'=>'error','description'=>'token not found'));
      }
        
    }
    public function edit($id)
    {
        return json_encode(array('status'=>'error','description'=>'token not found'));
    }
    public function update(Request $request, $id)
    {
      if(isset($request->token)){
        $users_id = $this->tokenToId($request->token);
        $data = Data::where('id',$id)->where('users_id',$users_id);
        $data->update(array_except($request->all(),'token'));
        return json_encode(array('status'=>'success','description'=>'Data Updated'));
      }else{
        return json_encode(array('status'=>'error','description'=>'token not found'));
      } 
    }

    public function destroy(Request $request, $id)
    {
      if(isset($request->token)){
        $users_id = $this->tokenToId($request->token);
        $data = Data::where('users_id',$users_id)->where('id',$id);
        if($data->count() > 0){
          $data->delete();
          return json_encode(array('status'=>'success','description'=>'Data deleted'));
        }else{
          return json_encode(array('status'=>'error','description'=>'Data not found!!'));
        }
      }else{
        return json_encode(array('status'=>'error','description'=>'token not found'));
      }   
    }


    public function getSaldo(){//melihatkan saldo semua
      $users_id =  Auth::user()->id;

      $in = Data::where('type','in')->where('users_id',$users_id)->select('value')->sum('value');
      $out = Data::where('type','out')->where('users_id',$users_id)->select('value')->sum('value');
      $saldo = (int)$in - (int)$out;
      return $saldo;
    }

    public function getTahunData(){
      $users_id =  Auth::user()->id;
      $arr = array();
      $tahun = Data::where('users_id',$users_id)->select('date')->groupBy('date')->get();
      foreach($tahun as $tahun_){
        $t=substr($tahun_['date'],0,4);
        array_push($arr,$t);
      }
      $r=array_values(array_unique($arr));
      return json_encode($r);
    }

    public function g(){
      $users_id =  Auth::user()->id;
      $op = \Request::get('op');
      switch ($op) {
        case 'getsaldo':
          return $this->getSaldo();
          break;
        case 'gettahundata':
          return $this->getTahunData();
          break;

        default:
          return "error";
          break;
      }
    }
    public function tokenToId($token){
      $users_id =  User::select('id')->where('token',$token)->get();
      return $users_id[0]['id'];
    }

}
