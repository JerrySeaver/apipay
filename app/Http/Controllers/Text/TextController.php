<?php

namespace App\Http\Controllers\Text;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;
class TextController extends Controller
{
    public function curlOne()
    {
        $url="http://www.baidu.com";
        $ch=curl_init($url);
        $curl=curl_setopt($ch,CURLOPT_RETURNTRANSFER,false);
        curl_exec($ch);
        curl_close($ch);
    }    
    public function curlTwo()
    {
        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx1f9161f806626795&secret=e145f36cee7a9f4ffc77305520fe4a89";
        $ch=curl_init($url);
        //CURLOPT_RETURNTRANSFER 
        //1 & TRUE 获取的信息以文件流的形式返回
        //0 & FALSE 直接输出
        $curl=curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $data=curl_exec($ch);
        curl_close($ch);
        echo $data;
    }
    public function curlThree()
    {
        echo "<pre>";
        var_dump($_POST);
    }
    //接收数组格式的FORMDATA数据
    public function FormData()
    {
        echo "<pre>";
        var_dump($_POST);
    }
    //接收URL链接参数数据
    public function WwwXFormUrlencoded()
    {
        echo "<pre>";
        var_dump($_POST);
    }
    //接收xml json等数据
    public function Raw()
    {
        echo "<pre>";
        var_dump(file_get_contents('php://input'));
    }
    public function zttp()
    {
        $client = new Client();
        $response = $client->request('POST', 'WWW.api.com//zttp', [
            'form_params' => [
                'username' => 'webben',
                'password' => '123456',
                'multiple' => [
                    'row1' => 'hello'
                ]
            ]
        ]);
        dd($response);
    }
    public function upload()
    {
        var_dump($_POST);
    }
    public function encode(Request $request)
    {
        $all=$request->all();
        $str=$all['str'];
        $code=base64_encode($str);
        $url="www.api.com/decode";
        $client = new Client();
        $response = $client->request('POST', $url, ['body' => $code]);
        echo $response->getBody();
        
    }
    /**
     * AES加密
     * str 要加密的值
     * password 加密的密码
     * iv 加密添加的变量
     * code 已经被加密的值
     */
    public function encodeTwo()
    {
        $str="您好";
        $password="password";
        $iv="passwordpassword";
        $code=openssl_encrypt($str,'aes-128-cbc',$password,true,$iv);
        $client=new Client();
        $url="www.api.com/decodeTwo";
        $response=$client->request('POST',$url,['body'=>base64_encode($code)]);
        echo $response->getBody();
    }
    /**
     * openssl_pkey_get_private  已经生成的私钥路径
     * openssl_private_encrypt
     * 参1 要加密的字符串
     * 参2 加密之后赋的值
     * 参3 已经生成的私钥路径
     */
    public function asymmetric()
    {
        $path=openssl_pkey_get_private("file://".storage_path('rsa_private_key.pem'));
        $data="周红包真帅";
        openssl_private_encrypt($data,$code,$path);
        $client=new Client();
        $url="www.api.com/deasy";
        $response=$client->request("POST",$url,['body'=>$code]);
        echo $response->getbody();
    } 
    public function testEncode()
    {
        //生成签名
        $data="机密文件";
        $str="加密字符串";
        $sha=sha1($str);
        $private_key="file://".storage_path('rsa_private_key.pem');
        $pri_key_id=openssl_pkey_get_private($private_key);
        $re=openssl_sign($sha,$signatrue,$pri_key_id,OPENSSL_ALGO_SHA1);
        //对称加密
        $data="你忙吧我吃柠檬";
        $password="password";
        $iv="passwordpassword";
        $code=openssl_encrypt($data,'aes-128-cbc',$password,true,$iv);
        $url="www.api.com/testDecode?code=".urlencode($code);
        $client = new Client();
        $response=$client->request("POST",$url,['body'=>$signatrue]);
        echo $response->getbody();
    }
    public function testDeasy()
    {
        //验证标签
        $signatrue=$_POST['signatrue'];
        $iscode=$_POST['iscode'];
        $pu_key = openssl_pkey_get_public("file://".storage_path('rsa_public_key.pem'));
        $str="加密字符串";
        $sha=sha1($str);
        $verify = openssl_verify($sha, $signatrue, $pu_key, OPENSSL_ALGO_SHA1);
        if($verify==1){
            //对称解密
            $password="pass";
            $iv="1234567890123456";
            $decode=openssl_decrypt($iscode,'aes-128-cbc',$password,true,$iv);
        }
        
    }
    //支付宝
    public function alipayView()
    {
        return view('pays/alipayView');
    }
    //调用
    public function alipay()
    {
        $biz=[
            'subject'=>'AppleAriPods2',
            'out_trade_no'=>'1810'.time().rand(11111,99999),
            'total_amount'=>'16000',
            'product_code'=>'QUICK_WAP_WAY',

        ];
        $arr=[
            'app_id'=>2016092700609175,
            'method'=>'alipay.trade.wap.pay',
            'charset'=>'utf-8',
            'sign_type'=>'RSA2',
            'timestamp'=>date('Y-m-d H:i:s'),
            'version'=>'1.0',
            'biz_content'=>json_encode($biz,JSON_UNESCAPED_UNICODE),
        ];
        ksort($arr);
        $str="";
        foreach($arr as $k => $v){
            $str.=$k.'='.$v.'&';
        }
        $str0=rtrim($str,'&');
        openssl_sign($str0,$signatrue0,openssl_get_privatekey('file://'.storage_path('priva.pem')),OPENSSL_ALGO_SHA256);
        $arr['sign']=base64_encode($signatrue0);
        $is_str="?";
        foreach($arr as $k => $v){
            $is_str.=$k."=".urlencode($v)."&";
        }
        $is_str=rtrim($is_str,'&');
        // dd($is_str);
        $urls="https://openapi.alipaydev.com/gateway.do";
        $url=$urls.$is_str;
        header("Location:".$url);
    }
}
