<?php 

/**
 * Vue2.x组件 
 *  当前版本 2.4.9
 * http://element-cn.eleme.io/#/zh-CN/component/installation
 * 
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 * 
 */ 

namespace app\plugin;
class ElementUi extends Base{ 
	/**
	 * 静态资源文件
	 * @var string
	 */
	public $copyDir = 'ElementUi';
	/**
	 * CSS文件
	 * @var array
	 */
	public $css = [
		  'index.css'
	];
	/**
	 * JS文件
	 * @var array
	 */
	public $js  = [
		'index.js'
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
		$this->js_top(" ");

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