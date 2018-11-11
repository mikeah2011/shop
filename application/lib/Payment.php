<?php 
/**
 *
 * 支付
 * 
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 * 
 */
namespace app\lib;

class Payment {

	public $config = [
		1=>'AliPay',
		2=>'wepay',
	];
	/**
	 * 给 app\lib\payment\getway【具体的支付方式使用】
	 * @var [type]
	 */
	static $type = [
		1=>[
			//PC支付
			//'pc'=>'Alipay_AopPage',
			//APP支付
			//'app'=>'Alipay_AopApp',
			//'app1'=>'Alipay_LegacyApp',
			//当面付
			//'f2f'=>'Alipay_AopF2F',
			//手机网站支付 
			//'wap'=>'Alipay_AopWap',
			//JSAPI
			//'js'=>'Alipay_AopJs',
			//即时到账
			'fast'=>'Alipay_LegacyExpress', 
		]
		
	];
	
	//当前支付方式 
	public $current = 1;
	/**
	 * 调用对应支付类
	 * @param  string $key [description]
	 * @return [type]      [description]
	 */
	public function init($key  = 'AliPay'){
		$num = is_numeric($key);
		if($num){
			$this->current = $key;
			$key = $this->config[$num];
		}else{
			$this->current = array_search($key,$this->config);	
		} 
		$class = "app\lib\payment\\".ucfirst($key);
		return new $class($this->current);
	}
	 
	 

}