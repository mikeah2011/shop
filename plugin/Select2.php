<?php 

/**
 * select 选择框
 * 
 * https://select2.org/
 * 
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 * 
 */ 

namespace app\plugin;
class Select2 extends Base{ 
	/**
	 * 静态资源文件
	 * @var string
	 */
	public $copyDir = 'Select2';
	/**
	 * CSS文件
	 * @var array
	 */
	public $css = [
		  'css/select2.min.css'
	];
	/**
	 * JS文件
	 * @var array
	 */
	public $js  = [
		'js/select2.min.js'
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
		$this->js_top("");

		if(!$this->ele){
			$this->ele = '.select';
		}
		/**
		 * 在JQ中执行JS
		 */
		$this->js(" 
			$('".$this->ele."').select2(".js_encode($this->par).");	 
		");
		/**
		 * 表单提交的时候，获取到对应textarea的值 
		 */
	    $this->js_submit("");


	}

}