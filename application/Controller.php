<?php 
/**
 *
 * 所有控制器的基类
 * 
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 * 
 */ 
namespace app;
use app\facade\Install;
use app\facade\Website;
use think\facade\Lang;
use app\facade\Config;
class Controller extends \think\Controller{
	//网站ID
	public $wid;
	protected function initialize(){  
		$this->init(); 
 		 
 		$this->wid = Website::id();
 			 
        /**
         * 多语言获取，并设置框架支持的语言包。
         * @var [type]
         */
        $lang = lang_active('key');
        if($lang){
            $lang_keys = array_keys($lang); 
            Lang::setAllowLangList($lang_keys);
        } 
        /**
         * 设置语言
         */
        $this->_translate('front_lang');
        /**
         * 加载插件
         */
        import(THEME_PATH.'/plugin.php');
        import(THEME_PATH.'/module.php');
	}
    /**
     * 取得当前页面使用的语言，并把界面翻译成对应的语言
     * @param  string $key [description]
     * @return [type]      [description]
     */
    public function _translate($key = 'front_lang'){
        $keep  = $key;
        /**
         * 多语言获取
         * @var [type]
         */
        $key = Config::getKey()[$key];
        /**
         * 取得多语言
         * 1=>zh_cn
         * @var [type]
         */
        $lang = lang_active('id','key');
        cookie('lang_'.$keep,$key);
        $current_lang = $lang[$key];
        if($current_lang){
            Lang::range($current_lang);
        } 
    }
    /**
     * 初始化
     * @return [type] [description]
     */
	public function init(){}
    
    
    /**
     * 检查登录
     * @return boolean
     */
    public function checkLogin(){
        $u = cookie('u');  
        if($u){
            return true;
        } else {
            return false;
        }
        
 
    }
}