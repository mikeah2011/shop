<?php
/**
 *
 * github 登录
 * 
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 * 
 */ 
namespace app\open\controller;

 
use app\lib\user\oauth2\OAuth2;
use app\lib\user\oauth2\Token;

class Logingithub extends Loginbase
{
     
    public $type = 'github';
 
 	/**
 	* INIT 初始化
 	*/
	public function init(){
		parent::init(); 
	 	$row = $this->config($this->type);
		if(!$row->id){
			exit(lang('Access Deny'));
		} 
		$this->oauth_id = $row->id; 
		$this->app_key = $row->key1;
		$this->app_secret = $row->key2; 
	}
	/**
	 *  首页跳转
	 */
 	public function index()
	{
	 	$code_url = " https://github.com/login/oauth/authorize?client_id=".$this->app_key."&redirect_uri=".urlencode($this->url)."&scope=user,repo,gist"; 
 		header("location:$code_url"); 
 		exit;
	}
	/**
	 *  第三方登录成功后，跳转到这个页面 
	 */
	public function return($code){ 
		$url = "https://github.com/login/oauth/access_token?client_id=".$this->app_key."&redirect_uri=".urlencode($this->url)."&client_secret=".$this->app_secret."&code=".$_GET['code'].""; 
		$content = file_get($url);
	
		$s = $content;
	 	$s = explode('&',$s);
		$d = explode('=',$s[0]);
		$access_token = $d[1]; 	 
		if ($access_token){
			try
	        {    	
	        	$this->auth =  OAuth2::provider($this->type, array(
			    	'id' =>$this->app_key, 
	       			'secret' => $this->app_secret, 
			    ));  
			    $token = Token::factory('access', array('access_token'=>$access_token)); 
			    
	            $info = $this->auth->get_user_info($token); 	          
 				$uid = $info['uid']; 
 				$me['id'] = $uid;
 				$me['name'] = $info['name']; 
 				$me['email']  = $info['emial'];  
 				
				$r = $this->user($me,$this->oauth_id,$access_token);   
				
		 	 	flash('success',lang('Login Success'));
				return redirect(return_url());
				
			} catch (OAuthException $e) {
				flash('error',lang('Login Error'));
				return redirect(return_url());
			}
		}
		exit;
	}
    
}
