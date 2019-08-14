<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

// use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Hash;

class AddressController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }

    public function province(Request $request){
        $arr=$request->input();
        $p_id=$arr['p_id'];
        $arr=Db::select("select * from area where parent_id='$p_id'");
        return response()->json($arr);

    }
    public function city(Request $request){
        $arr=$request->input();
        $p_id=$arr['p_id'];
        // var_dump($p_id);
        $arr=Db::select("select * from area where parent_id='$p_id'");
        return response()->json($arr);

    }
    public function area(Request $request){
        $arr=$request->input();
        $p_id=$arr['p_id'];
        // var_dump($p_id);
        $arr=Db::select("select * from area where parent_id='$p_id'");
        return response()->json($arr);

    }
    public function add1(Request $request){
        $arr=$request->input();
        $p_name=$arr['p_name'];
        $c_name=$arr['c_name'];
        $a_name=$arr['a_name'];
        $s_name=$arr['s_name'];
        $s_tel=$arr['s_tel'];
        $s_address=$arr['s_address'];

        $aa=["$p_name","$c_name","$a_name"];
        $aa=implode('-', $aa);
        $name=auth()->user();
        $uid=$name['id'];
        $arr=Db::table('address')->insert(['uid'=>$uid,'s_name'=>$s_name,'s_tel'=>$s_tel,'site'=>$aa,'detailed'=>$s_address]);
        
        return response()->json($arr);
    }
    public function show(Request $request){
        $arr=$request->input();
        $name=auth()->user();
        $uid=$name['id'];
        $arr=Db::select("select * from address where uid='$uid' and status='1'");
        return response()->json($arr);
    }
}