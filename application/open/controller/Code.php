<?php
/**
 *
 * 用户会员
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
 

class Code extends \app\Controller
{
     
    public function send()
    {
    	$data['status'] = 1;
    	$data['code'] = 0;
    	$data['msg'] = lang('Verify Code has send,Please check your phone');

    	return return_json($data);
    }

    
}
