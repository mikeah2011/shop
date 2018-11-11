<?php
/**
 * 语言包，数据库操作
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 */ 
namespace app\lib;
use app\facade\Config;
class Lang extends DB{
    public $table = 'lang_translate'; 
    /**
     * 前台当前语言id
     * @return [type] [description]
     */
    public function front(){
      return cookie('lang_front_lang');
    }
    /**
     * 后台当前语言id
     * @return [type] [description]
     */
    public function admin(){
      return cookie('lang_admin_lang');
    }
    /**
     * 查看已经激活的语言
     * @return [type] [description]
     */
    public function active($field = 'key' , $value = 'val'){
    
        $lang = Config::getKey('default')['lang']; 
        if(!$lang || is_string($lang)){
          return;
        } 
        $res = db('langs') 
          ->field('id,key,val')
          ->where('id','in',$lang)
          ->select();
        if($res){
          foreach($res as $v){
            $data[$v[$field]] = $v[$value];
          }
        } 
        return $data;
    }

     

   /**
    * ajax显示列表
    * @return [type] [description]
    */
   public function grid(){
      $res = db('lang_translate')->order('id','desc')->paginate(10);
      $count = $res->total();
      foreach ($res as $key => $v) {
         $data[] = [
            'key' => $v['key'],
            'val' => $v['val'],
             
            'opt' => "<a href='".url('admin/langs/form',['id'=>$v['id']])."'>".lang('Edit')."</a>",
         ];
      }
      return [
        'data'=>$data,
        'code'=>0,
        'count'=>$count
      ];
   }
   /**
    * 生成语言包文件
    * @return [type] [description]
    */
   public function createFiles(){
      $res = db('langs')
                  ->alias('a')
                  ->leftJoin('lang_translate b','a.id = b.lang_id')
                  ->field('a.key name,b.key,b.val')
                  ->select();
      foreach($res as $k=>$v1){ 
            $data[$v1['name']][$v1['key']] = $v1['val']; 
      }
      foreach($data as $k=>$v){
         $file = APP_PATH.'/lang/'.$k.'.php';
         file_put_contents($file, "<?php\n return ".var_export($v,true).";");
      }
   }
	/**
    * 保存语言到数据库
    * @param  [type] $data [description]
    * @return [type]       [description]
    */
   public function save($data){
      $arr['lang_id'] = $data['lang'];
      $arr['key'] = $data['key'];
      $arr['val'] = $data['val']; 
      $where = [
         'lang_id'=>$arr['lang_id'],
         'key'=>$arr['key']
      ];
      $tb = 'lang_translate';
      $res = db($tb)->where($where)->find();
      if($res){
         db($tb)->where($where)->update($arr);
      }else{
         db($tb)->insert($arr);
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