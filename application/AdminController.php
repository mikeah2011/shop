<?php 
/**
 *
 * 后台控制器基类
 * 
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 * 
 */ 
namespace app;
use app\facade\Module;
class AdminController extends  Controller{
	  

	 public function init(){
	 	parent::init();
	 	/**
         * 设置语言
         */
        $this->_translate('admin_lang');

        //Module::all();


	 	config('app.dispatch_success_tmpl','/public/success');
	 	if(!cookie('admin_name')){
	 		//return redirect(url('admin/login/index'));
	 	}
	 	
	 }
}