<?php 
/**
 *
 * 配置 
 * 
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 * 
 */
namespace app\lib;

class Config extends DB {
	 public $table  = 'configs';
	 
	 /**  
	  * 获取网站配置信息，已把val的值转成数组
	  * 当key为default的时候，如果没有对应的数据库configs的val下的key.
	  * 默认使用 id = 1的配置信息。即系统默认配置信息
	  * @param  string $key [description]
	  * @return array      [description]
	  */
	 public function getKey($key = 'default'){
	 	if($key == 'default'){
	 		$data = $this->_getKey($key,1)?:[];
	 		$get = $this->_getKey($key)?:[]; 

	 		$data = \app\facade\Arr::merge($data,$get); 
	 		 
	 		return $data;
	 	}
	 	
	 	return $this->_getKey($key);
	 }
	 protected function _getKey($key = 'default' ,$wid = ''){
	 	if(!$wid){
	 		$wid = $this->wid();
	 	}
	 	$res = $this->init()->where([
	 		'wid'=>$wid, 
	 		'key'=>$key, 
	 	])->find();
	 	$val =  json_decode($res['val'],true); 
	 	/**
	 	 * configs表中的val字段以,分隔的。转成数组
	 	 * @var [type]
	 	 */
	 	$muit = [
	 		'lang','lang_page'
	 	];
	 	foreach($muit as $v){
	 		$val[$v] = explode(',', $val[$v]);
	 	} 

	 	return $val;
	 }
	 
	 /**
	  * 保存网站设置
	  * @param  [type] $data [description]
	  * @return [type]       [description]
	  */
	 public function save($data){
	 	$res = $this->init()->where([
	 		'wid'=>$this->wid(),
	 		'type'=>'config',
	 		'key'=>'default', 
	 	])->find();
	 	if(!$res){
	 		$this->init()->insert([ 
		 		'wid'=>$this->wid(),
		 		'type'=>'config',
		 		'key'=>'default',
		 		'val'=>json_encode($data,JSON_UNESCAPED_SLASHES) 
	 		]);
	 	}else{
	 		$this->init()->where([ 
		 		'wid'=>$this->wid(),
		 		'type'=>'config',
		 		'key'=>'default', 
	 		])->update(['val'=>json_encode($data,JSON_UNESCAPED_SLASHES)]);
	 	}
	 	return true;
	 }

}