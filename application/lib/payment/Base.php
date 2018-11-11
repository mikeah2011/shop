<?php 
/**
 * 支付基类
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @version since 5.0.1 
 */
namespace app\lib\payment;
use app\lib\Payment;
class  Base{
    /**
     * gateway object
     * @var [type]
     */
    public $gateway;
    /**
    * 支付配置信息
    * @var [type]
    */
    public $config;

    /**
     * 当前的支付方式 ID
     * 纯数字
     * @var [type]
     */
    public $current;
    /**
     * 支付端
     * //PC支付
     * 'pc'=>'Alipay_AopPage',
     * //APP支付
     * 'app'=>'Alipay_AopApp',
     * 'app1'=>'Alipay_LegacyApp',
     * //当面付
     * 'f2f'=>'Alipay_AopF2F',
     * //手机网站支付 
     * 'wap'=>'Alipay_AopWap',
     * //JSAPI
     * 'js'=>'Alipay_AopJs',
     * //即时到账
     * 'fast'=>'Alipay_LegacyExpress',
     * @var [type]
     */
    public $type;

    public function __construct($type){
        $this->current = $type;
        $this->init();
    }
    public function init(){}
    /**
     * 设置PC WAP等
     * @param  string $key [description]
     * @return [type]      [description]
     */
    public function type($key = ''){
      //返回是PC WAP APP等支付KEY，
      //如 Alipay_AopPage 
      $this->type = Payment::$type[$this->current][$key]; 
      return $this;
    }
    /**
     * 生成订单信息
     * 支付前需要调用此方法
     * [
     * 	'body'=>'test',
     * 	'num'=>'test',
     * 	'total'=>1,
     * 	'type'=>'CNY',
     * ]
     * @param  array  $order [description]
     * @return [type]        [description]
     */
    public function createOrder($order = []){
    	$this->order = [
    	    'body'  => $order['body']?:'The test order',
    	    'num'   => $order['num']?:date('YmdHis').mt_rand(1000, 9999),
    	    'total' => $order['total'], //=0.01
    	    'goods'	=> $order['goods'],
    	    'ip'    => ip(), 
    	    'type'  => $order['type']?:'CNY'
    	]; 
    	return $this;
    }
    public function todo(){}
    public function notify(){}

}