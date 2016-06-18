<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Hash;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return json_encode(array('status'=>'error','description'=>'token not found'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
      $password = md5(md5($request->password));
      $token = str_random(64);
      $request['password']=$password;
      $request['token']=$token;
      $request['created_at']=date("Y-m-d");
      $request['updated_at']=date("Y-m-d");

      if($data = User::where('email',$request->email)->where('username',$request->username)->count()==0){
        User::create($request->all());
        return json_encode(array('status'=>'success','token'=>$token));
        
      }
      else{
        return json_encode(array('status'=>'error','duplicate users'));
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($token)
    {
      if(User::where('token',$token)->count()==1){
        $data = User::where('token',$token)->first();
        return $data;
      }else{
        return json_encode(array('status'=>'error','description'=>'No User Found'));
      }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      if(isset($request->token)){
        $user = User::where('token',$request->token)->where('id',$id)->count();
        $password = md5(md5($request->password));
        $request['password']=$password;
        if($user>0){
          $data = User::where('id',$id);
          $data->update($request->except(['token','_method']));
          return json_encode(array('status'=>'success','description'=>'User Updated'));
        }else{
          return json_encode(array('status'=>'error','description'=>'token not found'));
        }
      }else{
        return json_encode(array('status'=>'error','description'=>'token not found'));
      } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function login(Request $request){

      $password = md5(md5($request->password));
      $username = $request->username;
      $request['password']=$password;
      $data = User::where('username',$username)->where('password',$password);
      if($data->count()==1){
        $token = str_random(64);
        $data->update(['token'=>$token]);
       return json_encode(array_add($data->get()[0],'status','success'));
      }else{
        return json_encode(array('status'=>'error','description'=>'No User Found'));
      }
      //belum kalau token telah ada
    
    }
    public function logout($id){
      $data = User::where('id',$id);
      $data->update(['token','']);
      return json_encode(array('status'=>'success','logged out'));
    }
    
    public function tokenToId($token){
      $users_id =  User::select('id')->where('token',$token)->get();
      return $users_id[0]['id'];
    }
}


