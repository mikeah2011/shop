<?php
/**
 * 页面输出JS CSS等，合并在一起的。
 * 看起来不会那么乱
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 */ 
namespace app\lib;

class Page {

	static $obj;

	public $name;

	public function start($name){
	    ob_start();
	    $this->name = $name;
	}

	public function end(){
	    static::$obj[$this->name]  .= ob_get_contents();
	    ob_end_clean(); 
	}


	public function view($name){
	    $var = static::$obj[$name];
	    if($var){
	    	echo $var;
	    } 
	}

}