<?php 

/**
 * 消息提醒
 * https://notifyjs.jpillora.com/ 
 * 
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 * 
 */ 

namespace app\plugin;
class Notify extends Base{ 
	/**
	 * 静态资源文件
	 * @var string
	 */
	public $copyDir = 'Notify';
	/**
	 * CSS文件
	 * @var array
	 */
	public $css = [
		  
	];
	/**
	 * JS文件
	 * @var array
	 */
	public $js  = [
		'notify.js'
	];
	/**
	 * 初始化
	 * @return [type] [description]
	 */
	public function init(){
		parent::init();
		/**
		 * 加载语言JS
		 */
		
	}
	/**
	 * 执行插件
	 * @return [type] [description]
	 */
	public function run($arr = []){
		parent::run($arr);
		

		/**
		 * 定义全局变量
		 */
		$this->js_top(" 
				 var is_load_notify = false;
				function success(msg){
				   if(is_load_notify){
				   		return false;
				   }
				   $.notify(msg,\"success\");
				   is_load_notify = true;
				}
				function error(msg){
				   $.notify(msg, \"error\");
				} 
		");

		/**
		 * 在JQ中执行JS
		 */
		$this->js("");

		/**
		 * 表单提交的时候，获取到对应textarea的值 
		 */
	    $this->js_submit("");


	}

}