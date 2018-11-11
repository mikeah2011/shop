<?php 
/**
 *
 * 数组操作
 * 
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 * 
 */
namespace app\lib;

class Arr {

	/**
	* 合并数组
	* @param  array $a 数组key更多
	* @param  array $b 会过滤没有value的数组。不支持循环过滤，只过滤第一层
	* @return array
	*/
	public function merge($a,$b){
		return array_merge($a , $this->unsetNoValue($b));
	} 
	/**
	* 过滤数组中key没有value的情况 。
	* 
	* @param  [type] $arr [description]
	* @return [type]      [description]
	*/
	protected function unsetNoValue($arr){
		foreach ($arr as $key => $v) {
			if(!$v){
				unset($arr[$key]);
				continue;
			}

			$v1 = @implode("",$v); 
			if(is_array($v) && !$v1){
				unset($arr[$key]);
				continue;
			}

		}
		return $arr;
	}


	/**
	* 判断一个数组的值，在另一个数组中。
	* array('a') in array('c','a') return true;
	* 'a' in array('c','a') return true;
	* 事例
	* <code>
	* 
	* </code> 
	* @param  [type] $a [description]
	* @param  [type] $b [description]
	* @return [type]    [description]
	*/
	public function in_array($a,$b){
		if(!is_array($b)) return false;
		if(!is_array($a)) $a = array($a);
		foreach($a as $v){
			if(!in_array($v,$b))
				return false;
		} 
		return true;
	}

}