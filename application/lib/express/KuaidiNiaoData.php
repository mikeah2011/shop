<?php 
namespace app\lib\express;
/** 
 * 快递鸟所有的国内、国外、转运的code name写入相关表
 * \app\facade\Express::runInit();
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 */
use app\lib\DB;

class KuaidiNiaoData extends DB{

	 /**
	 * 物流数据表初始数据
	 * @var [type]
	 */
	protected $_data = [
		'express_api'=>[
			[
				'slug'=>'KuaidiNiao',
				//判断唯一性
				'_where'=>['slug'],
				'name'=>'快递鸟'
			],
		],
		'express_type'=>[ 
			[
				//判断唯一性
				'_where'=>['slug','express_api_id'],
				//关联的外键
				'_refences'=>[
					//express_api#0 数组中的key为express_api的第一条保存到数据库的主键值，默认id且不能修改
					'express_api_id'=>"express_api#0", 
				],
				'slug'=>'gounei', 
				
				'name'=>'国内'
			],
			[
				//判断唯一性
				'_where'=>['slug','express_api_id'],
				'slug'=>'gouwai',
				//关联的外键
				'_refences'=>[
					'express_api_id'=>"express_api#0", 
				],
				'name'=>'国外'
			],
			[
				//判断唯一性
				'_where'=>['slug','express_api_id'],
				'slug'=>'zhuyun',
				//关联的外键
				'_refences'=>[
					'express_api_id'=>"express_api#0", 
				],
				'name'=>'转运'
			],
		],
		'express_code'=>[
			[
				//判断唯一性
				'_where'=>['express_type_id','code'],
				'code'=>'SF', 
				//关联的外键
				'_refences'=>[
					'express_type_id'=>"express_type#0", 
				],
				'name'=>'顺丰'
			],
		],
	];
 
	/**
	 * 初始化快递鸟，所有国内、国外、转运的CODE 与 NAME
	 * @return [type] [description]
	 */
	public function run(){
		$type = 'Xls';
		$file = __DIR__.'/KuaidiNiaoExpressCode.xls'; 
		/**
		 * 读取xls文件
		 * @var [type]
		 */
		$data = \app\facade\Phpoffice::read($type,$file);

 		$j = 0;
 		foreach($data as $k=>$v){
 			$val = [];

 			foreach($v as $k1=>$v1){
 				$this->_data['express_code'][] = [ 
					//关联外键
					'_refences'=>[
						'express_type_id'=>"express_type#".$j,
					],					
					'code'=>$v1[0],
					'name'=>$v1[1],
					'_where'=>['express_type_id','code'],
				];
 			}
 			$j++; 
 		}
 		 
 		/**
 		 * 快速保存
 		 */
 		$this->fastSave();
 		 
	}
 

}