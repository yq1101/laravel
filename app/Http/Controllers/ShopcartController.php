<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

// use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Hash;

class ShopcartController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }

    public function shop(Request $request){
        $arr=$request->input();
        $name=auth()->user();
        $uid=$name['id'];
        
        $wid=Db::select("select wid from shopcart where uid='$uid'");
        foreach ($wid as $key => $value) {
          $wid=$value->wid;
        }
        $arr=Db::select("select shopcart.id,shopcart.num,shopcart.price,s_ware.id as wid,s_ware.goods_attr_name,s_goods.g_name,s_goods.g_id from s_goods join s_ware on s_goods.g_id=s_ware.goods_id join shopcart on s_ware.id=shopcart.wid where shopcart.uid='$uid'");
        return response()->json($arr);
    }
    public function price(Request $request){
        $arr=$request->input();
        $num=$arr['num'];
        $wid=$arr['wid'];
        $arr=Db::update("update shopcart set num='$num' where wid='$wid'");
        return response()->json($arr);
    }

    public function cartTwo1(Request $request){
        $arr=$request->input();
        $spid=$arr['id'];
        // $spid=implode(',', $spid);
        $array=[];
         foreach ($spid as $key => $value) {

           $arr=Db::select("select shopcart.id,shopcart.num,shopcart.price,s_ware.id as wid,s_ware.goods_attr_name,s_goods.g_name,s_goods.g_id from s_goods join s_ware on s_goods.g_id=s_ware.goods_id join shopcart on s_ware.id=shopcart.wid where shopcart.id='$value'");
           foreach ($arr as $key1 => $value1) {
              $array[]=$value1;
           }
         }        
       // var_dump($array);
        return response()->json($array);
    }
    public function cartTwo2(Request $request){
        $arr=$request->input();
        $name=auth()->user();
        $uid=$name['id'];
        $arr=Db::select("select * from address where uid='$uid'");
        return response()->json($arr);
    }

    public function add(Request $request){
        $arr=$request->input();
        $spid=$arr['id'];

        $name=auth()->user();
        $uid=$name['id'];
        
        $array=[];
        foreach ($spid as $key => $value) {
            $arr=Db::select("select shopcart.id,shopcart.num,shopcart.price,s_ware.id as wid,s_ware.goods_attr_name,s_goods.g_name,s_goods.g_id from s_goods join s_ware on s_goods.g_id=s_ware.goods_id join shopcart on s_ware.id=shopcart.wid where shopcart.id='$value'");
           foreach ($arr as $key1 => $value1) {
              $array[]=$value1;
           }
        }

        date_default_timezone_set("PRC");
        $time=time();
        $date=date("Y-m-d H:i:s");
        var_dump($date);
        foreach ($array as $k1 => $v1) {
              $price=$v1->price;
              $wtype=$v1->goods_attr_name;
              $wname=$v1->g_name;
              $wid=$v1->id;
              $num=$v1->num;
              $arr=Db::table('orderdetails')->insert(['wid'=>$wid,'wname'=>$wname,'num'=>$num,'price'=>$price,'wtype'=>$wtype,'order_id'=>$time]);
              // var_dump($arr);
            
        }

        $arr=Db::select("select s_name,s_tel,site,detailed from address where uid='$uid'");
        $bb=[];
        foreach ($arr as $key => $value) {
            foreach ($value as $key1 => $value1) {
                  $bb[]=$value1;
            }
        }
        $address=implode('-', $bb);
        $arr=Db::table('orders')->insert(['time'=>$date,'status'=>1,'uid'=>$uid,'address'=>$address,'order_id'=>$time]);
        var_dump($arr);

    }
}