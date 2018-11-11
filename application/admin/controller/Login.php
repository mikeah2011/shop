<?php
/**
 * 登录
 *
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 */


namespace app\admin\controller;

  
use app\facade\admin\User;

class Login extends \app\AdminController
{
    /**
     * 登录界面
     */
    public function index()
    {
        return view('index');
    }
    /**
     * 登录执行的逻辑
     */
    public function todo(){
    	$data['code'] = 0; 
        $data['status'] = 0;
    	if(!captcha_check(input('post.vercode'))){
		 	$data['msg'] = lang('Vercode error'); 
		};

        $res = User::login(); 
        if($res['status'] == 1){
            $data['status'] = 1;
            $data['msg'] = lang('Login Success');
        }else{
            $data['msg'] = $res['msg'];
        }



		return return_json($data);
    } 
}
