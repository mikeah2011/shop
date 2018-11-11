<?php
namespace app\index\controller;
/**
 * 测试lib下功能用的，不用上传到服务器。
 */
use app\facade\Type;
use app\facade\Notice;

class Test extends \app\Controller
{
    public function index()
    {
        $d =  Type::tree_select();
        $d = "<select>$d</select>";
        print_r($d);
    }

    public function tel()
    {
        $code = '1234';
        $data = [
            'code1'=>$code
        ];
        $content = '为您的登录验证码，请于'.$code.'分钟内填写。如非本人操作，请忽略本短信。';
        Notice::send([
            'tel'=>'13285801489',
            'tid'=>'SMS_95215022',
            'content'=>$content,
            'data'=>$data
        ]);
    }


    public function kuaidi(){
    	$res = \app\facade\Kuaidi::config([
		  	'name'=>'KuaidiNiao',
		  	'bid'=>'1290486',
		  	'akey'=>'40840fdb-85fe-4d3c-978f-69f378fa3fae', 
		])->todo('1234561','SF');

		print_r($res);
    }

    
}
