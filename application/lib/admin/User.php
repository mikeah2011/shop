<?php 
namespace app\lib\admin;

use app\lib\User as Base;
use think\Validate;
/**
 *
 * 管理员
 * 
 * @master
 * 
 */
class User extends Base{
	
	/**
	 * 实际处理管理员登录逻辑
	 */
	public function login(){ 
		$user = input('post.user');
		$pwd = input('post.pwd');
		$rem = input('post.rem');

		$msg = [
		    'user.require' => '登录名必须',
		    'user.min' 		=> '登录名至少5位',
		    'user.max'     => '登录名长度最多不超过25个字符',
		    'pwd.require'   => '密码必须',
		    'pwd.min'  => '密码至少6位', 
		];

		$validate = Validate::make([
		    'user'  => 'require|min:5|max:25',
		    'pwd' => 'require|min:6'
		],$msg);

		$data = [
		    'user'  => $user,
		    'pwd'   => $pwd
		]; 

		if (!$validate->check($data)) {
		    return['status' => 0 , 'msg' => $validate->getError() ];
		}

		$data['type'] = 3; //3是平台或超级管理员
		$this->save($data);



	}
	 

}