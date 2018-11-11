<?php
/**
 *
 * 订单
 * 
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 * 
 */ 
namespace app\lib;
/**
 * orders 中的 status = 1时订单完成 。
 * 
 */
class Order {
	/**
	 * order_detail
	 * 0 等待支付、1已支付、2、已退货、3已退款
	 */
	public $status = 0;
	/**
	 * 生成订单号
	 * orders主表的oder_num
	 * @return [type] [description]
	 */
	public function num(){
		//当前登录的用户
		$data['uid'] = 1;
		//网站id
		$data['wid'] = 1;
		//生成订单时间
		$data['created'] = time();
		//订单状态，0等待支付 1已完成
		$data['status'] = 0;
		//支付方式
		$data['ptype'] = 0;
	}
	 

}