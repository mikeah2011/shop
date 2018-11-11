<?php
/**
 *
 * 图形验证码
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
 

class Verify extends \app\Controller
{
     
    public function index()
    {
    	$config =    [
		    // 验证码字体大小
		    'fontSize'    =>    20,    
		    // 验证码位数
		    'length'      =>    4,   
		    // 关闭验证码杂点
		    'useNoise'    =>    false, 
		];
        $captcha = new Captcha($config);
        return $captcha->entry(); 
    }

    
}
