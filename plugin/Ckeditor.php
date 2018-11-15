<?php 

/**
 *
 *  https://ckeditor.com/
 * 
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 * 
 */ 

namespace app\plugin;
class Ckeditor extends Base{ 
	/**
	 * 静态资源文件
	 * @var string
	 */
	public $copyDir = 'Ckeditor';
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
		'ckeditor5-classic/ckeditor.js'
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
			var  textEditor = new Array();
		");
		/**
		 * 执行JS
		 */
		$this->js("
		ClassicEditor
	    .create( document.querySelector( '".$this->ele."' ))
	    .then( editor => {  
	    	textEditor['".$this->name."'] = editor;  
	        console.log( 'Editor was initialized', textEditor ); 
	    } )
	    .catch( err => {
	        console.error( err.stack );
	    } );");
		/**
		 * 表单提交的时候，获取到对应textarea的值 
		 */
	    $this->js_submit("
			for(i in textEditor){
		          var val = textEditor[i].getData(); 
		          data[i] = val; 
		    }
	    ");


	}

}