<?php  
/**
 * 发送短信
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 */ 

/**
 * //{1}为您的{2}验证码，{3}分钟内有效。
 * 
 *  //手机号
 *	$data['tel'] = "13285801489";
 *	//内容
 *	$data['content'] = "1234为您的注册验证码,5分钟内有效。";
 *	//模板对应的数组
 *	$data['data'] = [];
 *	//有模板时用模板ID
 *	$data['tid'] = ""; 
 *	\app\facade\SMS::send($data);
 */
namespace app\lib;
use Overtrue\EasySms\EasySms; 
use app\facade\Config;
class SMS {
	 public $obj;
	 public function __construct(){  
	 	 $val = db_config('default');
	 	 $config = [
		    // HTTP 请求的超时时间（秒）
		    'timeout' => 1,
		    'debug'=>true,
		    // 默认发送配置
		    'default' => [
		        // 网关调用策略，默认：顺序调用
		        'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

		        // 默认可用的发送网关
		        'gateways' => [
		        	'qcloud', //通过测试，本地是不能发短信的
		           // 'aliyun',
		           // 'yunpian', 
		        ],
		    ],
		    // 可用的网关配置
		    'gateways' => [
		        'errorlog' => [
		            'file' => BASE_PATH.'/runtime/sms.log',
		        ],
		        'qcloud' => [
			        'sdk_app_id' =>$val['sms']['qcloud']['sdk_app_id'], 
			        'app_key' => $val['sms']['qcloud']['app_key'], 
			        'sign_name' => $val['sms']['qcloud']['sign_name'],   
			    ], 
			    //253云通讯（创蓝）
			    //https://zz.253.com/index.html
			    'chuanglan' => [
			        'account' => 'N3144223',
			        'password' => '',

			        // \Overtrue\EasySms\Gateways\ChuanglanGateway::CHANNEL_VALIDATE_CODE  => 验证码通道（默认）
			        // \Overtrue\EasySms\Gateways\ChuanglanGateway::CHANNEL_PROMOTION_CODE => 会员营销通道
			        'channel'  => \Overtrue\EasySms\Gateways\ChuanglanGateway::CHANNEL_VALIDATE_CODE, 

			        // 会员营销通道 特定参数。创蓝规定：api提交营销短信的时候，需要自己加短信的签名及退订信息
			        'sign' => '【通讯云】',
			        'unsubscribe' => '回TD退订', 
			    ],
		        'aliyun' => [
		            'access_key_id' => $val['sms']['ali']['key_id'],
		            'access_key_secret' => $val['sms']['ali']['key_secret'],
		            'sign_name' => $val['sms']['ali']['sign_name'],
		        ],
		        'yunpian' => [
			        'api_key' => '2aea5d91acce61a0fac5292e4d8216ec',
			        'signature' => '【云片网】', // 内容中无签名时使用
			    ],
		    ],
		];
		 
		$this->obj = new EasySms($config); 
	 }


	 public function send($arr){
	 	$tel = $arr['tel'];
	 	$content = $arr['content'];
	 	$data = $arr['data'];
	 	$template_id = $arr['tid']; 

		try { 
			$this->obj->send($tel, [
			    'content'  => $content,
			    'tid' => $template_id?:'SMS_47585027',
			    'data' => $data,
			]);
		} catch (\Overtrue\EasySms\Exceptions\NoGatewayAvailableException $e) {
		   echo lang('短信发送失败');
		   
		   exit;
		}




		
	 }

}