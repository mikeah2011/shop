<?php 
/**
 * 微信支付
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @version since 5.0.1 
 */
namespace app\lib\payment;
use Omnipay\Omnipay;

class WechatPay extends Base{
	//gateways: WechatPay_App, WechatPay_Native, WechatPay_Js, WechatPay_Pos, WechatPay_Mweb
	public $method = 'Native';
	public $pre = 'WechatPay_';
	/*
	 app_id
	 mch_id
	 api_key
	 */
	public $config = [];

	public $order;

	public function init($config = []){
		$this->config = $config; 
	}

	public function createOrder($order = []){
		$this->order = [
		    'body'              => $order['body']?:'The test order',
		    'out_trade_no'      => $order['num']?:date('YmdHis').mt_rand(1000, 9999),
		    'total_fee'         => $order['total'], //=0.01
		    'spbill_create_ip'  => ip(),
		    'fee_type'          => $order['type']?:'CNY'
		]; 
	}


	public function todo($type = 'Native'){ 
		$gateway    = Omnipay::create($this->pre.ucfirst($type)); 
		$gateway->setAppId($this->config['app_id']);
		$gateway->setMchId($this->config['mch_id']);
		$gateway->setApiKey($this->config['api_key']); 
		$order = $this->order;
		/**
		 * @var Omnipay\WechatPay\Message\CreateOrderRequest $request
		 * @var Omnipay\WechatPay\Message\CreateOrderResponse $response
		 */
		$request  = $gateway->purchase($order);
		$response = $request->send(); 


		exit;
		//available methods
		$response->isSuccessful();
		$response->getData(); //For debug
		$response->getAppOrderData(); //For WechatPay_App
		$response->getJsOrderData(); //For WechatPay_Js
		$response->getCodeUrl(); //For Native Trade Type
	}

	public function notify(){
		$gateway    = Omnipay::create('WechatPay');
		$gateway->setAppId($this->config['app_id']);
		$gateway->setMchId($this->config['mch_id']);
		$gateway->setApiKey($this->config['api_key']);

		$response = $gateway->completePurchase([
		    'request_params' => file_get_contents('php://input')
		])->send();

		if ($response->isPaid()) {
		    //pay success
		    var_dump($response->getRequestData());
		}else{
		    //pay fail
		}
	}


}