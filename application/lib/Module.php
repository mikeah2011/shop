<?php 
/**
 *
 * 加载模块
 * 
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 * 
 */
namespace app\lib;

class Module extends DB{
     /**
      * 表名
      * @var string
      */
     public $table = 'modules';
     /**
      * 数据库中查寻模块列表
      * @return [type] [description]
      */
     public function rows($is_active = NULL){
        $condition = ['wid'=>$this->wid()];
        if(is_numeric($is_active)){
            $condition['status'] = $is_active;
        }
        $all = db($this->table)->where($condition)->select();
        if(!$all){
            return [];
        }
        foreach($all as $v){
            $data[$v['slug']] = $v;
        }
        return $data;
     } 
    
     /**
      * 激活模块或禁用模块
      * @param  string $slug 模块名
      * @return  
      */
     public function status($slug){
        $condition = ['slug'=>$slug,'wid'=>$this->wid()];
        $data = $this->list()[$slug];
        $data['status'] = 1;
        $data['wid'] = $this->wid();
        unset($data['hooks']);  
        $res = $this->init()->where($condition)->find();
        if(!$res){ 
            $this->init()->insert($data);
        }else{
            if($res['status'] == 1){
                $data['status'] = 0;
            }
            $this->init()->where($condition)
                ->update($data);
        }
        if($res['status'] == 0){
            return $this->activeLink($slug); 
        }
        return $this->unActiveLink($slug); 
     }
     /**
      * 已激活时显示的链接
      * @param  string $slug [description]
      * @return string
      */
     public function activeLink($slug){ 
         $par =   [ 
             'class'=>'ajax_link layui-btn layui-btn-danger layui-btn-xs', 
             'href'=>url('admin/modules/status',['slug'=>$slug]),
         ];
         return  \THtml::tag([
             'name'=>'a',
             'label'=>lang('UnActive'), 
             'attr'=>$par,
             'close'=>'a'
         ]);

     }
     /**
      * 未激活时显示的链接
      * @param  [type] $slug [description]
      * @return [type]       [description]
      */
     public function unActiveLink($slug){
         $par =   [ 
             'class'=>'ajax_link layui-badge layui-bg-blue layui-btn-xs', 
             'href'=>url('admin/modules/status',['slug'=>$slug]),
         ];
         return  \THtml::tag([
             'name'=>'a',
             'label'=>lang('Active'), 
             'attr'=>$par,
             'close'=>'a'
         ]);

     }
     /**
      * 分页显示 
      * @return [type] [description]
      */
     public function grid(){
        $list = $this->list();
        foreach($list as $k=>$info){
            $slug = $info['slug'];
            $info['tag'] = $info['name']." （".$slug."）";
            if($this->rows(1)[$slug]){
                $info['opt'] =  $this->activeLink($slug); 
            }else{
                $info['opt'] =  $this->unActiveLink($slug);
            }
            
            $list[$k] = $info;
        }
        return ['data'=>$list,'code'=>0];
     }
	 /**
      * 遍历modules目录下的模块
      * @return [type] [description]
      */
     public function list(){
        $dir = APP_PATH.'/modules/';
        $list = scandir($dir);
        foreach($list as $v){
            if(!in_array($v,['.git','.svn','.','..'])
                && is_dir($dir.$v)
            ){
                $info = include $dir.$v.'/info.php';
                $hook = $info['hooks'];
                $info['slug'] = $v;
                foreach($hook as $url=>$arr){
                    $class = "\app\modules\\".$v."\\".$arr['0'];
                    $action = $arr[1];
                    $info['hooks'][$url] = [
                        $class,$action
                    ];
                }  
                $data[$v] = $info;
            }
        }
        return $data; 
     }
	   

}