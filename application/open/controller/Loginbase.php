<?php 
 
/**
 *
 * 第三方登录 基础类
 * 
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 * 
 */ 
namespace app\open\controller;
 
class Loginbase extends \app\Controller
{
    public $url;
	public $app_key;
	public $app_secret;
	public $oauth_id; 
	public $auth;

	public function init(){
		parent::init();
		set_return_url();
		$this->url = host().url('open/login'.$this->type.'/return');  
	}
    /**
     * 读取第三方登录配置信息。
     */
    public function config($name){ 
		$row = db('oauth_config')->where([
			'slug'=>$name,
			'display'=>1
		])->find();
		return (object)$row;
	}
	/**
	 * 第三方登录成功后
	 * 设置用户信息，并写入相关数据表
	 */
	public function user($me,$oauth_id,$token){
		$me['email'] = $me['email']?:'info';
		$uniqid = md5(uniqid(microtime()));
	 
		if(!$me['id']){
			flash('error',lang('login failed'));
			return redirect(return_url());
		}
		$one = db('oauth_users')->where(
			[
				'uid'=>$me['id'],
				'oauth_id'=>$oauth_id 
			]
		)->find();
		if($one){
			db('oauth_users')->where([
				'id'=>$one['id']
			])->update([
				'name'=>$me['name'],
				'email'=>$me['email'], 
				'token'=>$token,
				'uuid'=>$uniqid, 
			]);
		}else{
			db('oauth_users')->insert([
				'uid'=>$me['id'],
				'name'=>$me['name'],
				'email'=>$me['email'],
				'oauth_id'=>$oauth_id, 
				'token'=>$token,
				'uuid'=>$uniqid, 
			]);
		}
		$one = db('oauth_users')->where([ 
			'uuid'=>$uniqid,
			'oauth_id'=>$oauth_id,  
		]);
		if($one){
			$value = array(
				'id'=>$one['id'],
				'name'=>$one['name'],
				'email'=>$one['email'],
				'oauth'=>true
			);
			cookie('user',json_encode($value),0);
		}
		
	}
}
