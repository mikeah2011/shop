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
namespace app\lib;

class User {

	public function save($arr = []){
		$data['user']    = $arr['user'];
		$data['type']    = $arr['type']?:1;
		$data['pwd']     = $this->pwd($arr['pwd']);
		$data['created'] = time();
		$find = db('users')
			->where('user',$user)
			->find();

		if(!$find){
			$insert = db('users')->insert($data);
			$id = db('users')->getLastInsID();
			echo $id;
		}

	}

	/**
	 *  生成密码
	 */
	public function pwd($pwd){

		return password_hash($pwd, PASSWORD_DEFAULT);

	}
	/**
	 * 检查密码是否正确
	 */
	public function check_pwd($hash , $password){
		if(password_verify (  $password ,  $hash )){
			return true;
		}else{
			return false;
		}
	}


    
    public function login()
    {
        if($_GET['name']){
            cookie('u',$this->wid);
            
            $result = ['status'=>0,'msg'=>'success'];
        } else {
            $result = ['status'=>1,'msg'=>'failure'];
        }
        return $result;
    }
    
    public function register()
    {
        if($_GET['name']){
            cookie('u',$this->wid);
            
            $result = ['status'=>0,'msg'=>'success'];
        } else {
            $result = ['status'=>1,'msg'=>'failure'];
        }
        return $result;
        
    }

	 

}