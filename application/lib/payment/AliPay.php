<?php 
/**
 * AliPay支付
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @version since 5.0.1 
 */
/**
 * <code>
 * $data = [
 * 	 	'body'=>'test',
 * 	 	'num'=>'test123',
 * 	 	'total'=>1,
 * 	 	'type'=>'CNY',
 * 	 ];
 *   return Payment::init('AliPay')
 *    		->type('fast')
 *    		->createOrder($data)
 *    		->todo();
 * </code>
 */
namespace app\lib\payment;
use Omnipay\Omnipay;


class AliPay extends Base{
	 
	 

	public $order;
	/**
	 * 获取支付配置信息
	 * @return [type] [description]
	 */
	public function init(){
		$config = db_config('default');
		$this->config = $config['pay'];
		
	} 
	/**
     * 设置PC WAP等
     * @param  string $key [description]
     * @return [type]      [description]
     */
	public function type($key = ''){
		parent::type($key);
		$gateway = Omnipay::create($this->type);
 		$gateway->setSellerEmail($this->config['alipay_email']);
		$gateway->setPartner($this->config['alipay_partner']);
		$gateway->setKey($this->config['alipay_md5']); 
		$gateway->setReturnUrl(host().url('payment/alipay/return'));
		$gateway->setNotifyUrl(host().url('payment/alipay/notify'));
		$this->gateway = $gateway;
		return $this;
	}
	/**
	 * 跳转到支付页面
	 * @return [type] [description]
	 */
	public function todo(){   
		if(strpos($this->type,'Legacy')!==false){
			$request = $this->gateway->purchase([
			  'out_trade_no' => $this->order['num'],
			  'subject'      => $this->order['body'],
			  'total_fee'    => $this->order['total'],
			]);

			/**
			 * @var LegacyExpressPurchaseResponse $response
			 */
			$response = $request->send(); 
			$redirectUrl = $response->getRedirectUrl();
			return redirect($redirectUrl);
		}
		 
		$response = $this->gateway->purchase()->setBizContent([
		    'subject'      => $this->order['body'],
		    'out_trade_no' => $this->order['num'],
		    'total_amount' => $this->order['total'],
		    'product_code' => $this->order['goods']?:'FAST_INSTANT_TRADE_PAY',
		])->send();

		$url = $response->getRedirectUrl(); 
		return redirect($url); 
	}
	/**
	 * 异步通知
	 * @return [type] [description]
	 */
	public function notify(){
		$request = $this->gateway->completePurchase();
		$data = array_merge($_POST, $_GET);
		$request->setParams($data);  
		try {
		    $response = $request->send(); 
		    if($response->isPaid()){
		        /**
		         * 支付成功
		         */
		        db_log("aplipay success");
		        db_log(var_export($data));
		        die('success'); 
		    }else{ 
		    	db_log("aplipay error",'system_error');
		    	db_log(var_export($data));
		        die('fail');  
		    }
		} catch (Exception $e) {
		    /**
		     * 异常
		     */
		    db_log("aplipay error",'system_error');
		    db_log(var_export($data));
		    die('fail'); //The notify response
		}
	}


}