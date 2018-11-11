<?php  
/**
 * 消息通知
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 */ 
namespace app\lib;
 

class Notice {
	 /**
	  * 发送消息
	  *
	  * '验证码为'.$code.',5分钟内有效。'
	  * 
	  * @param  string $type    [description]
	  * @param  [type] $content [description]
	  * @return [type]          [description]
	  */
	 public function send($arr){
	 	  $sms = new SMS;
	 	  /*$arr['type']
	 	  $arr['tel'] ;
	 	  $arr['content'];
	 	  $arr['data'];
	 	  $arr['tid'];*/
	 	  $sms->send($arr);
	 }

}