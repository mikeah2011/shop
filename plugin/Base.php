<?php  
/**
 *
 *  插件基类
 * 
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 * 
 */ 
namespace app\plugin;
use app\facade\File;
class Base extends \app\Base{
	/**
	 * 执行插件的元素
	 * @var [type]
	 */
	public $ele;
	/**
	 * 元素name属性
	 * @var [type]
	 */
	public $name;
	/**
	 * JS插件参数
	 * @var [type]
	 */
	public $par = [];
	/**
	 * CSS文件
	 * @var array
	 */
	public $css = [];
	/**
	 * JS文件
	 * @var array
	 */
	public $js  = [];
	/**
	 * 插件URL
	 * @var [type]
	 */
	public $baseUrl;
	/**
	 * 是否返回代码
	 * @var [type]
	 */
	public $return = false;
	 
	/**
	 * 被复制的目录
	 * @var [type]
	 */
	public $copyDir;
	/**
	 * 初始化插件
	 * @return [type] [description]
	 */
	public function init(){
		$dir = __DIR__.'/'.$this->copyDir;
		$to  =  WEB_PATH.'/assets/'.$this->copyDir;
		if(!is_dir($dir)){
			return;
		}  
		/**
		 * 首次复制目录
		 */
		 File::copy($dir,$to);
		 	
		$this->baseUrl = base_url().'/assets/'.$this->copyDir.'/';
		/**
		 * 加载必要的JS CSS
		 */
		$this->loadCSS();
		$this->loadJS(); 
	}

	/**
	 * 执行插件
	 * @return [type] [description]
	 */
	public function run($arr = []){
		$this->ele = $arr['ele'];
		$this->name = $arr['name'];
		$this->par = $arr['par'];
		$this->return = $arr['return'];
	}
	/**
	 * 提交表单时操作
	 * @param  [type] $js [description]
	 * @return [type]     [description]
	 */
	public function js_submit($js){
		code($js,'form_submit'); 
	}
	/**
	 * 加载JS代码
	 * @param  [type] $js [description]
	 * @return [type]     [description]
	 */
	public function js($js){
		code($js,'footer_jquery'); 
	}
	/**
	 * 定义JS全局变量
	 * @param  [type] $js [description]
	 * @return [type]     [description]
	 */
	public function js_top($js){
		code($js,'header_top'); 
	}

	/**
	 * 加载css
	 * @return [type] [description]
	 */
	protected function loadCSS(){
		if($this->css){
			foreach($this->css as $v){
				css_file($this->baseUrl.$v);
			}
		}
	}
	/**
	 * 加载JS
	 * @return [type] [description]
	 */
	protected function loadJS(){
		if($this->js){
			foreach($this->js as $v){
				js_file($this->baseUrl.$v);
			}
		}
	}
	 



}
 