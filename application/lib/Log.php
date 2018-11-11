<?php  
/**
 * 日志
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 */ 
namespace app\lib;
use app\common\model\Log as M;

class Log {

	 public function error($content){
	 	 M::insert([
	 	 	'created' => time(),
	 	 	'type'  => 'error',
	 	 	'content' =>$content
	 	 ]);
	 }

}