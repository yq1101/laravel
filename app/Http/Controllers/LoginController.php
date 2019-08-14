<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LoginController extends Controller
{

	public function login(){
        return view('login');
	}

    public function index(Request $request)
    {
    	$name= Input::get('name');
    	$password=Input::get('password');
    	$arr=Db::select("select * from admin1 where name='$name' and password='$password'");
    	if (empty($arr)) {
    		$arr=['code'=>'1','status'=>'error','data'=>'账号,密码错误'];
			echo json_encode($arr);
    	}else{
    		$request->session()->put('name', $name);
    		$arr=['code'=>'0','status'=>'ok','data'=>'登陆成功'];
			echo json_encode($arr);
    	}
    }

    public function show(Request $request){
    	$value=$request->session()->get('name');
    	// var_dump($value);
    	if (empty($value)) {
    		return redirect('login/login');
    	}else{
    		return view('show');
    	}
    	
    }

    public function showa(){
    	$arr=Db::select("select * from admin1");
    	$json=['code'=>'0','status'=>'ok','data'=>$arr];
        echo json_encode($json);
        // return response()->json($arr);
    }

    public function addaction(){
    	$name= Input::get('name');
    	$password=Input::get('password');
    	$arr=Db::table('admin1')->insert(['name'=>$name,'password'=>$password]);
    	if ($arr==true) {
    		$json=['code'=>'0','status'=>'ok','data'=>$arr];
        	echo json_encode($json);
    	}else{
    		$json=['code'=>'1','status'=>'error','data'=>'添加失败'];
        	echo json_encode($json);
    	}
    }

    public function delete(){
    	$id=Input::get('id');
    	$arr=Db::table('admin1')->where('id', '=', $id)->delete();
    	$json=['code'=>'0','status'=>'ok','data'=>$arr];
        echo json_encode($json);
    }

    public function update(){
    	$id=Input::get('id');
    	$name=Input::get('name');
    	$password=Input::get('password');
    	$arr = DB::table('admin1')->where('id', '=', $id)->update(['name' =>$name,'password'=>$password ]);
        if ($arr==true){
            $arr=['status'=>'ok'];
            $json=json_encode($arr);
            echo $json;
        }else{
            $arr=['status'=>'error'];
            $json=json_encode($arr);
            echo $json;
        }
    
    }

    public function tuichu(Request $request){
    	$value=$request->session()->forget('name');
    	// $value=$request->session()->get('name');    	
    	if (empty($value)) {
    		return redirect('login/login');
    	}
    	
    }
}