<?php 
/**
 * 获取快递信息，统一接口
 *
 * \app\facade\Express::run('1234561','SF');
 *  
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 */
namespace app\lib;
 
class Express extends DB{
	/**
	 * 快递接口
	 * @var string
	 */
	public $express_name = 'KuaidiNiao';
	/**
	 * 初始化xls数据到表
	 * @return [type] [description]
	 */
	public function runInit(){
		$obj = "\app\\lib\\express\\".$this->express_name.'Data';
		(new $obj)->run();
	}
	/**
	 * 调用快递单号+快递公司 返回物流信息
	 * @param  [type] $numer 快递单号 
	 * @param  [type] $type  快递公司
	 * @return [type]        [description]
	 */
	public function run($numer,$type = null){
		$ns = '\app\lib\express\\'.$this->express_name;
		$obj = new $ns();
		return $obj->get($numer,$type); 
	}

	 

}