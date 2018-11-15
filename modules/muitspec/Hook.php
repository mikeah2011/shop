<?php 
/**
 *
 * 多规格
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
use app\facade\Arr;
class Hook{
	/**
	 * 规格排序
	 * @return [type] [description]
	 */
	public function sortSpec(){
		$data = $_REQUEST['data'];
		$goods_id = $_REQUEST['goods_id'];
		if(!$data || !$goods_id){
			return return_json(['status'=>0]);
		} 
		foreach($data as $v){
				$v = str_replace('spec_name','',$v);
				$v = str_replace('][','|',$v);
				$v = str_replace('[','',$v);
				$v = str_replace(']','',$v);
				$arr = explode('|', $v);
				$list[$arr[0]][] = $arr[1];  
		}
		$model = new Model;
		$model->saveSort($list,$goods_id);
		$data = $model->getSpec($goods_id);

		return return_json(['status'=>1,'ori'=>$data]);
		 
	}
	/**
	 * 规格模板管理
	 * @return [type] [description]
	 */
	public function deleteT(){
		$name = trim($_REQUEST['item']);
		if(!$name){
			return ;
		}
		$model = new Model;
		$res = $model->deleteT($name); 

		/**
		 * 取得模板
		 */
		$data = $this->defaultSpec();
		
		return $data; 
	}
	/**
	 * 保存模板
	 * @return [type] [description]
	 */
	public function template(){ 
		$name = trim($_REQUEST['val'])?:"模板—".date('Ymd')."-".mt_rand(0,9999);
		$model = new Model;
		$goods_id = $_REQUEST['goods_id'];
		$content = $model->getSpec($goods_id);
		if($content){
			$res = $model->saveT($content,['name'=>$name]);
			return return_json(['status'=>$res,'name'=>$name]);
		}
		return return_json(['status'=>0]); 
	}
	/**
	 * 官方默认推荐规格
	 * @return [type] [description]
	 */
	public function defaultSpec(){
		$data = import(__DIR__.'/data.php',true); 
		$model = new Model;
		$de = $model->getT()?:[];
		$data = $de+$data;
		$val = trim($_REQUEST['val']); 
		if($val){
			$data_1 = $data[$val];
			$goods_id = $_REQUEST['goods_id']; 
			$model->deleteSpec(['goods_id'=>$goods_id]); 
			foreach($data_1 as $k=>$v){
				foreach($v as $v1){
					$insert = [
						'goods_id'=>$goods_id,
						'name'=>$k,
						'val'=>$v1
					];
					$model->saveData($insert);
				}
			}
			$data = (array)$data_1; 
		} 
		$key = array_keys($data); 
		if($de){
			$de = array_keys($de); 	
		}		
		$res = $this->common($data);
		return return_json([
			'key' => $key, 
			'key_admin' => $de,
		]+$res);
	}

	/**
	 * 添加规格或删除
	 */
	public function action(){
		$data = $_POST;
		$type = $data['type'];
		unset($data['type']);
		$res = (new Model)->saveData($data,$type);  
		return $this->table();
	}
	/**
	 * 加载规格
	 * @return [type] [description]
	 */
	public function load(){
		$data = return_include (__DIR__.'/view.php'); 
		return return_json(['html'=>$data]);
	}
	/**
	 * 显示规格table
	 * @return [type] [description]
	 */
	public function table(){ 
		$goods_id = $_REQUEST['id'];
		$model = new Model;  
	 	$type = $_GET['type']?true:false;
	 	if($type == 'removeSpec'){
	 		$name = $_GET['key1'];
	 		$val = $_GET['key2'];
	 		$model->saveData([
	 				'goods_id'=>$goods_id,
	 				'name'=>$name,
	 				'val'=>$val,
	 		],'delte'); 
	 	}
	 	$data = $model->getSpec($goods_id); 
	 	if(!$data){
	 		return return_json(['lists'=>[],'title'=>[]]);
	 	}
	 	$res = $this->common($data); 
		return return_json($res);
	}
	/**
	 * vue需要的共同参数 
	 */
	protected function common($data){
		$title = array_keys($data);
		$ori = $data;
	 	$data  =  array_values($data); 
	 	$d = Arr::spec($data); 
	 	$more = [
	 		'sprice'=>'市场价',
	 		'jprice'=>'进货价',
	 		'price'=>'销售价',
	 		'store'=>'库存'
	 	];
	 	$key = array_keys($more); 
	 	$title = array_merge($title,$more);
	 	if($d){
	 		foreach($d as $k=>$v){ 
	 			$d[$k] = array_merge($d[$k] , $key);
	 		}
	 	}

	 	return [
	 		'more'=>$key,
			'settings'=>$more,
			'lists'=>$d,
			'title'=>$title,
			'ori'=>$ori
	 	];

	}
	/**
	 * 在表单上做HOOK
	 * @return [type] [description]
	 */
	public function form(){
		plugin('ElementUi');
		include __DIR__.'/assets.php';
		$li = "<li>".lang('Goods Spec')."</li>";
		$spec = "<div class=\"layui-tab-item loading-sp\">";

		$spec .= "loading..."; 
		$spec .="</div>"; 
		code("
			$('.tabs li:first').after('".$li."');
			$('.tab-content div:first').after('".$spec."');
			$.get('".module_url('muitspec','Hook','load')."',function(res){
					$('.loading-sp').html(res.html);
					load_spec(); 
			},'json');
		",'footer_jquery'); 
	}


}