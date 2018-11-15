<?php 

/**
 *  拖拽排序
 *  http://rubaxa.github.io/Sortable/
 *
 *  更多参数
 *
 *  https://github.com/RubaXa/Sortable
 * 
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 * 
 */ 

namespace app\plugin;
class Sortable extends Base{ 
	/**
	 * 静态资源文件
	 * @var string
	 */
	public $copyDir = 'Sortable';
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
		'jquery.binding.js',
		'Sortable.min.js'
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
			 
		");

		/**
		 * 在JQ中执行JS
		 */
		
		$code = "  
				$('".$this->ele."').sortable(".js_encode($this->par)."); 
		";
		
		if($this->return == true){
			return $code;
		}
		$this->js($code);
		/**
		 * 表单提交的时候，获取到对应textarea的值 
		 */
	    $this->js_submit(""); 

	}

}