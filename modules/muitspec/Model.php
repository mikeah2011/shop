<?php 
/**
 *
 * 多规格逻辑操作
 * https://github.com/Skura23/goods-spec
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 * 
 */ 
namespace app\modules\muitspec;
use TForm;
use app\lib\DB;
class Model extends DB{
	/**
	 * 规格主表
	 * @var string
	 */
	public $table = 'good_spec';
	/**
	 * 规格值表
	 * @var string
	 */
	public $table_val = 'good_spec_val';
	/**
	 * 规格模板表
	 * @var string
	 */
	public $table_t = 'good_spec_template';

	/**
	 * 保存排序
	 * [尺码] => Array
     *   (
     *      [0] => 170/92A/XL
     *       [1] => 165/88A/L
     *   )
     *
     * [版本] => Array
     *   (
     *       [0] => 6GB+128GB
     *       [1] => 6GB+256GB
     *   )
	 *
     * [颜色] => Array
     *   (
     *       [0] => 白
     *       [1] => 蓝
     *   )
	 * @return [type] [description]
	 */
	public function saveSort($data,$goods_id){
		$sort = count($data)+99;
		foreach($data as $name=>$v){
				$con = [
					'wid'=>$this->wid(),
					'goods_id'=>$goods_id,
					'name'=>$name,
				];
				$res = db($this->table)->where($con)->find();
				db($this->table)->where($con)
					->update(['sort'=>$sort]);

				$spec_id = $res['id'];
				$sort--;
				$max = count($v)+99;
				foreach($v as $v1){
					db($this->table_val)->where([ 
						'spec_id'=>$spec_id,
						'val'=>$v1,
					])->update(['sort'=>$max]);
					$max--;
				}
		} 
	}

	/**
	 * 删除模板名
	 * @param  [type] $name [description]
	 * @return [type]       [description]
	 */
	public function deleteT($name){
		db($this->table_t)->where([
			'wid'=>$this->wid(),
			'name'=>$name
		])->delete();
		return true;
	}

	/**
	 * 取得模板
	 * @return [type] [description]
	 */
	public function getT(){
		$res = db($this->table_t)
				->order('id','desc')
				->where(['wid'=>$this->wid()])->select();
		if($res){
			foreach($res as $v){
				$list[$v['name']] = json_decode($v['content']);
			}
		}
		return $list?:[];
	}
	/**
	 * 保存模板
	 * @param  [type] $content [description]
	 * @param  array  $par     [description]
	 * @return [type]          [description]
	 */
	public function saveT($content,$par = []){
		$data['name'] = $par['name'];
		$data['wid'] = $this->wid();
		$data['content'] = json_encode($content);
		if(!$data['name']){
			return false;
		}
		if(db($this->table_t)->where([
			'name'=>$par['name'],
			'wid'=>$this->wid()
			])->find()){
			return false;
		}

		db($this->table_t)->insert($data);
		return true;
	}

	/**
	 * 删除goods_id下所有的规格
	 * @return [type] [description]
	 */
	public function deleteSpec($data){
		if(!$data['goods_id']){
			return;
		}
 
		$res = db($this->table)->where([
				'goods_id'=>$data['goods_id'],
				'wid'=>$this->wid()
			   ])->select();
		
		if($res){
			foreach ($res as $key => $v) {
				$in[] = $v['id'];
			} 
		}
		 
		if($in){
			db($this->table_val)->whereIn(
				'spec_id' , 'in' ,$nid
			)->delete();
		}
		db($this->table)->where(
			'id','in',$nid
		)->delete();
		return true;
	}
	/**
	 * 取得规格
	 * @return [type] [description]
	 */
	public function getSpec($goods_id){
		if(!$goods_id){
			return;
		}
		$res = db($this->table)->alias('a')
			->field('a.name,b.val')
			->leftJoin($this->table_val.' b','a.id = b.spec_id')
			->where('a.goods_id',$goods_id)
			->where('a.wid',$this->wid())
			->order('a.sort desc')
			->order('b.sort desc')
			->select();

		if($res){
			foreach($res as $v){
				$list[$v['name']][] = $v['val'];
			}
		}
		return $list;
	}

	/**
	 * 需要转入 goods_id,name,val
	 * good_spec: id name wid goods_id
	 * good_spec_val: spec_id val ext
	 * 直接传入数组，保存到对应表，支持删除规格值。
	 * 将 $_type 值改为 delete
	 * @return [type] [description]
	 */
	public function saveData($data = [] , $_type = ''){
		if(!$_type){
			$_type  = 'save';
		}
		$wid = $this->wid();
		$goods_id  = $_REQUEST['goods_id'];
		$name = $data['name'];
		$val = $data['val'];
		if(!$name || !$val || !$goods_id){
			return;
		} 
		$condition_ori = [
			'name'=>$name,
			'wid'=>$wid,
			'goods_id'=>$goods_id
		];
		$res = db($this->table)->where($condition_ori)->find();
		if(!$res){
			$spec_id = db($this->table)->insertGetId($condition_ori);
		}else{
			$spec_id = $res['id'];
		}
		/**
		 * 写入关联表
		 */
		$condition = [
			'spec_id' => $spec_id,
			'val' => $val,
		];
		if($_type == 'delete'){
			db($this->table_val)->where($condition)->delete();
			$count = db($this->table_val)->where(['spec_id'=>$spec_id])->count();
			if($count == 0){
				db($this->table)->where($condition_ori)->delete();
			}
			return true;
		}
		$res = db($this->table_val)->where($condition)->find();
		if(!$res && $_type == 'save'){
			$spec_id = db($this->table_val)->insertGetId($condition+[
				'val'=>$data['val']
			]);
		}
		return true;
	}






}