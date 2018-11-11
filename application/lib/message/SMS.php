<?php 
namespace app\lib\message;
use Overtrue\EasySms\EasySms;
/**
 * 发送短信
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @version since 5.0.1 
 */
class SMS{
	protected $easySms;

	public function init(){


		$config = [
		    // HTTP 请求的超时时间（秒）
		    'timeout' => 5.0,

		    // 默认发送配置
		    'default' => [
		        // 网关调用策略，默认：顺序调用
		        'strategy' => \Overtrue\EasySms\Strategies\OrderStrategy::class,

		        // 默认可用的发送网关
		        'gateways' => [
		             'aliyun','yunpian',
		        ],
		    ],
		    // 可用的网关配置
		    'gateways' => [
		        'errorlog' => [
		           // 'file' => '/tmp/easy-sms.log',
		        ],
		        'yunpian' => [
		            'api_key' => '824f0ff2f71cab52936axxxxxxxxxx',
		        ],
		        'aliyun' => [
		            'access_key_id' => '',
		            'access_key_secret' => '',
		            'sign_name' => '',
		        ],
		        //...
		    ],
		];

		$this->easySms = new EasySms($config);

		
	}

	public function send_sms($tel,$content,$tpl_id = null,$data = []){
		$easySms->send($tel, [
		    'content'  => $content,
		    'template' => $tpl_id,
		    'data' => $data,
		]);
	}
}