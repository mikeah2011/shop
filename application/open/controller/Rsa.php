<?php
/**
 *
 * RSA
 * 
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 * 
 */ 
namespace app\open\controller;

use think\captcha\Captcha;
 

class Rsa extends \app\Controller
{
     
    public function index()
    {
    	$data = create_rsa_key();

    	return return_json($data);
    }

    
}
