<?php 
/**
 * 基类,使用init代码__construct
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @version since 5.0.1 
 */
namespace app;

class Base{
	public function __construct(){
  		$this->init();
  	}
  	public function init(){}
}