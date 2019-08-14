<?php

namespace App\Http\Controllers;

// use Illuminate\Support\Facades\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

// use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index','tree','category','gfloor','gname','findware']]);//过滤login
    }

    public function index(){
    	$arr=Db::select("select * from s_goods");
    		return response()->json($arr);
    	
    }

    public function tree(){
    	$arr=Db::select("select * from s_category");
    	$aa=$this->category($arr,0,0);
    	$josn=['code'=>'200','status'=>'ok','data'=>$aa];
    	return response()->json($aa);
    	
    }

    public function category($arr,$id,$level){
    	$bb=array();
    	foreach ($arr as $k => $v) {
    		if ($v->pid==$id) {
    			$v->level=$level;
    			$v->son = $this->category($arr,$v->id,$level+1);
    			$bb[]= $v;
    		}
    	}
    	// var_dump($bb);
    	return $bb;
    }

    public function gfloor(){

    	$arr=Db::select("select floor.id,floor.name,s_goods.g_id,s_goods.g_name from floor join goodsfloor on floor.id=goodsfloor.fid join s_goods on goodsfloor.gid=s_goods.g_id");
    	// echo "<pre>";
    	// var_dump($arr);
    	$cc=array();
		foreach ($arr as $k => $v) {
			$cc[$v->name][$v->g_id][]=$v->g_name;
			
		}
		// var_dump($cc);die;
    	return response()->json($cc);
    }

   	public function gname(Request $request){
		// echo "123";
		$aa = $request->all();
		$g_id=$aa['gid'];
		// var_dump($g_id);die;
   		$arr=Db::select("select s_goods.g_id as gid,s_goods.g_name as gname,s_attribute.name as attrb_name,s_attr_details.name as attrd_name,s_attr_details.id as attrd_id from s_goods join s_goods_attr on s_goods.g_id=s_goods_attr.goods_id join s_attr_details on s_goods_attr.attr_details_id=s_attr_details.id join s_attribute on s_goods_attr.attr_id=s_attribute.id where goods_id='$g_id'");
   		// var_dump($arr);die;
   		$newarr=[];
   		foreach ($arr as $k => $v) {
   			// $newarr[$v->gname][$v->attrb_name][]=$v->attrd_name;
   			$newarr[$v->attrb_name][]=[$v->attrd_name,$v->attrd_id];
   		}
   		$ass['name']=$arr[0]->gname;
   		$ass['data']=$newarr;
   		// var_dump($ass);
   		return response()->json($ass);
   	}

   	public function findware(Request $request){
   		// echo "12131";
   		 $bb=$request->input();
   		 $attrd_id=$bb['attrd_id'];
   		 $gid=$bb['gid'];

   		 
   		 $attrd_id=substr($attrd_id, 1);
   		 
   		 $attrd_id=str_replace('-', ',', $attrd_id);
   		 // 
   		 $attrd_id=explode(',', $attrd_id);
   		 sort($attrd_id);
   		 $length=count($attrd_id);
   		 $sort=[];
   		 for ($i=0; $i <$length ; $i++) { 
   		 	 $sort[]=$attrd_id[$i];
   		 }
   		 $attrd_id=implode('-', $sort);
   		 // var_dump($attrd_id);die;
   		 $arr=DB::select("select * from s_ware where goods_id='$gid' and goods_attr_id='$attrd_id'");
   		 return response()->json($arr);
   	}

   	public function shopcart(Request $request){
   		$arr=$request->input();
   		$num=$arr['num'];
   		$wid=$arr['wid'];
   		$price=$arr['price'];
   		$attrd_id=$arr['attrd_id'];
   		// var_dump($attrd_id);die;
   		$name=auth()->user();
        $uid=$name['id'];
   		$arr=Db::select("select * from shopcart where uid='$uid' and wid ='$wid'");
   			// return response()->json($arr);
   		if($arr){
   			foreach ($arr as $key => $value) {
   				$number=$value->num;
   			}
   			$n=$num+$number;
   			Db::update("update shopcart set num='$n' where uid='$uid' and wid='$wid'");
   			$arr=Db::select("select * from shopcart where uid='$uid' and wid ='$wid'");

   		}else{
   			$arr=Db::table('shopcart')->insert(['uid'=>$uid,'wid'=>$wid,'num'=>$num,'price'=>$price,'attrd_id'=>$attrd_id]);
   		}
   		return response()->json($arr);
   		
   	}

}