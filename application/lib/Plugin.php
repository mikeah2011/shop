<?php  
/**
 * 加载插件
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 */ 
namespace app\lib;
use app\common\model\Log as M;

class Plugin {
	 /**
	  * [init description]
	  * @param  [type] $name [description]
	  * @return [type]       [description]
	  */
	 public function load($name){
	 	 $name = ucfirst($name);
	 	 $cls = '\app\plugin\\'.$name;
	 	 return new $cls();
	 }

}