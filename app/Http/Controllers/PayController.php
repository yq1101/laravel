<?php

namespace App\Http\Controllers;

use Yansongda\Pay\Pay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['return','notify']]);
    }

    protected $config = [
        'alipay' => [
            'app_id' => '2016101000655077',
            'notify_url' => 'http://localhost/laravel/public/api/pay/notify',
            'return_url' => 'http://localhost/laravel/public/api/pay/return',
            'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAgrP0pXLYsEC+4LPegEDruNYyeaCZnXEBGWIA4strGNdgGOkUjfwMGC0wIB5HYiOne0MzTRgzLC7SN32GNs3jFtWe3mW4EK2FodalAcV5Lx+wFVe812dgQ62SkVZlg5CN24AFqZVjVvNzp5+vxZ70dwNprzzE8VwLn1r9DGX1qZpGcH+9rZJB6jW7KngzHDFBZF3YFlaDPCEyyAgm13gCuU1DmN3zK2OyWTYAKJIAlEvttUoG2oS/Cb5ZnDpQbReCH/bGQkDaPbijJomhrpkYrmkhl0Mm06kxEmqo/faaA5X4tlYTO1Bz+vlkRpTLAcB1UBI+jcVNau5vqOCjhu8jtwIDAQAB',
            'private_key' => 'MIIEowIBAAKCAQEAleNyvE4+AUjFuiiSCbLGRgUeFO/Hjkx8MkqUjE+LMeXohI4Ltz7XIHf33CjylXFdcW5bsuqhZR3u0lGAtJK8FJTu/Ahv+OF1HB4y2JToZdfgjlm6GnBTILQfi/+Heqp1V9UGb3uU6j1WIXT9jdbKrCIznZ6vI5lgcyEgb/mJEQeCi730cj/Xv+AZStiTJZ5p6Qst2slLeyPc04152RdCBUvjFvB3Ho9FkMItMmin8rJGowFzUrYMoSqlCCdhvXeTMUpL/ol7mF9IBJx04kCx+z/yHS9SxMS2ahW3GA61dLP02kmhBHdgsrxJS4KvHz3yw8scCaibx3EnqeOHtfuzdwIDAQABAoIBADWTwbVxulQ3MQZj7h+tWZY5yhDtzMUerd5ELmkhHb5OUhjftWxg+ADRITX/JQcqKJ6dNgX0PJCqbG2dWIYzVSt+ORa55VxvKq9MVBx6zb9ptQjtJcrBj9VGzWf7hO/h8mPc75n18LryBdGbwe5rcrKo3w5eZHgzIPjGRJQB/G6rVoI+0j5wRdCjrYdbBIWzLWVO5unjbaiX4WYyODQM7JGDI93b0PB/qsVe5de4FLQlvHWDLgc6WCT/9WTc4AyscMevWEyTMIhH98TJuBmhUHyjxiRrizOcNebIcGOFgeilMM3osXTvhnNh8IFbhHLrc4DFh6dBTLPPWFGclNX0ssECgYEAxGiikgT906axteQ8l+/ghQQwdbKH6ACRtweWS6u6mDAZ5kuW+I7dyGiHtds4izOirOm4e/5WxOYhCVYtLXEZB6izYZuflhjGSsx9Z/soA79S8tJ9Q0HCQaP5LS7uX5JWD7NEi3Jyh2S4HpEJdRS0pT9hZFFFs+qzO1mSM8KYEIcCgYEAw12DgFsXACHoRa/olo4QvQuJTZmvQ5GXIYMaA7rS63Y2Ry5yy4NWiC7gUYtyVN7E7v4R6m4XuvaBuYqnxm7PIa7sddnLWfmi6Uc6u3liqX3oBwE9ozPPRkwKq2UB8J+bOq9dCjsskWkGrnwCOPy/Cs9jyj7gzAybK6n7tn5rsZECgYBzH5na2Q4m1xhnM0bJEBOcJB57fo/mzx6aF9pitGAFAHzN3hS50JPy+kJBuCNmhHefvsch9qzJcNKAdIC6mAZB1QJ//gYGprLj+QSwxChqOeTW68X8fDju3LwbXdzfLBlBzqQo0IaNEd5SHFVcySwxh/sAIBspIDK6YQAvUqprVQKBgQCXeSDlWzrpGmEZ7vraCIpH2PL7HMZ8EBzqmdiIvcidUclhxUyyKEHmUtoPv5vE2/g7CPjhF70Ec+4+6peMzguBJTwnX9dACsLaNiT+iG4L1hgZnkepCxmRepHnM+ieJVHY3XC45wp2L8VDcdjTUHvbKNNJUxk+fCOvZhtI8poTUQKBgHhxvcuGQlWD4Mv9UtrnkkoJxCQN4je8I0aq6B8JVoQeREfzzQudu+g4EGGiwCJoHjDOmobrvKGkQ4RLhYVQAvUDwB2h6pE6AO4Q1UNYsLy12ivvyertEXyfckDoRzgag/RruoIKvK6uHN+GvFr/y/bTr6h4NjV2nuRlmm6Rbs+5',
        ],
    ];

    public function index(Request $request)
    {
        $oid=$request->input('oid');
        // var_dump($oid);die;
        $arr=Db::select("SELECT * FROM orderdetails WHERE order_id=$oid");
        $sum=0;
        foreach ($arr as $key => $value) {
            $sum+=$value->price*$value->num;
        }
        
        $config_biz = [
            'out_trade_no' => $request->input('oid'),
            'total_amount' => $sum,
            'subject'      => 'test subject',
        ];

        $pay = new Pay($this->config);

        return $pay->driver('alipay')->gateway()->pay($config_biz);
    }

    public function return(Request $request)
    {
        $pay = new Pay($this->config);

        $arr=$pay->driver('alipay')->gateway()->verify($request->all());

        var_dump($arr);
        $aa=$arr['out_trade_no'];
        $bb=$arr['total_amount'];
        $cc=$arr['timestamp'];
        header("location:http://localhost:8080/#/cartthree?order_id=$aa&price=$bb&time=$cc");
    }

    public function notify(Request $request)
    {
        $pay = new Pay($this->config);

        if ($pay->driver('alipay')->gateway()->verify($request->all())) {
            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。 
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号； 
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）； 
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）； 
            // 4、验证app_id是否为该商户本身。 
            // 5、其它业务逻辑情况
            file_put_contents(storage_path('notify.txt'), "收到来自支付宝的异步通知\r\n", FILE_APPEND);
            file_put_contents(storage_path('notify.txt'), '订单号：' . $request->out_trade_no . "\r\n", FILE_APPEND);
            file_put_contents(storage_path('notify.txt'), '订单金额：' . $request->total_amount . "\r\n\r\n", FILE_APPEND);
        } else {
            file_put_contents(storage_path('notify.txt'), "收到异步通知\r\n", FILE_APPEND);
        }

        echo "success";
    }
}