<?php 
/**
 * 开通网站等管理操作
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 */
namespace app\lib;

class Website extends DB{
    public $table = 'websites'; 
    /**
     * 取得商家ID
     * @return [type] [description]
     */
    public function id(){
      if(req_arr()['m'] == 'admincp'){
          return 1;
      }
      $host = host();
      $cute = str_replace('http://','',$host);
      $cute = str_replace('http://','',$cute); 
      $res = Website::init()->where('domain',$cute)->find();
      $wid = $res['id'];
      if($wid){ 
        cookie('wid',$this->wid); 
      }else{
        cookie('wid',null);
      } 
      /**
       * 网站未开通
       */
      if(!$wid){  
          $title = lang('Website is not running');
          exit(page_render('404')); 
      }
      return $wid;
    }

   /**
    * ajax显示列表
    * @return [type] [description]
    */
   public function grid(){
      $res = db($this->table)->order('id','desc')->paginate(10);
      $count = $res->total();
      foreach ($res as $key => $v) {
         $data[] = [
            'domain' => $v['domain'],
            'endtime' => date('Y-m-d H:i:s',$v['endtime']),
             
            'opt' => "<a href='".url('admincp/websites/form',['id'=>$v['id']])."'>".lang('Edit')."</a>",
         ];
      }
      return [
        'data'=>$data,
        'code'=>0,
        'count'=>$count
      ];
   }
    
	/**
    * 保存语言到数据库
    * @param  [type] $data [description]
    * @return [type]       [description]
    */
   public function save($data){
      $arr['domain'] = $data['domain'];
      $arr['starttime'] = strtotime($data['starttime']);
      $arr['endtime'] = strtotime($data['endtime']); 
      $arr['saler_id'] = $data['saler_id']; 
      $arr['memo'] = $data['memo']; 
      $arr['created'] = time(); 
      $where = [
         'id'=>$arr['id']?:$_GET['id']
      ];
       
      $res = db($this->table)->where($where)->find();
      if($res){
         db($this->table)->where($where)->update($arr);
      }else{
         db($this->table)->insert($arr);
      } 
   }

   /**
    * 读取多语言。
    * @return [type] [description]
    */
	public function list($key = 'id'){
		 $res = db('langs')
            ->select();
         if(!$res){
         	exit(lang('Language is not setting'));
         }
         foreach($res as $k=>$v){
         	$list[$v[$key]] = $v['val'];
         }
         return $list;
	}	

}