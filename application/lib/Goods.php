<?php
/**
 *
 * 商品管理 
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 * 
 */ 
namespace app\lib;


use app\common\model\Type as M;
use app\facade\File;
class Goods  extends DB{
	
   /**
    * 表名
    * @var string
    */
	 public $table = 'goods';
   /**
    * 关联图片表
    * @var string
    */
   public $ftable = 'good_file';
	 /**
     * 需要翻译的字段
     * @var array
   */
    public $lang_field = ['title','content'];
    /**
     * 多语言表
     * @var string
     */
    public $lang_table = 'good_lang';
    /**
     * 对应语言表的字段
     * @var [type]
     */
    public $lang_pk = 'goods_id';
  	
    /**
     * 获取状态
     * @return [type] [description]
     */
    public function getStauts(){
      return [
          1=>lang('On line'),
          2=>lang('Off line'),
          0=>lang('Remove'),
      ];
    }
    /**
     * 获取数据
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function get($id){
        $data = parent::get($id);
        $row = db($this->ftable)->alias('a')
          ->where('a.goods_id',$id)
          ->select();
        foreach($row as $v){
          $fid = $v['fid'];
         
          $data['image'][] = [
            'url'=> File::url($fid),
            'thumb'=>File::url($fid,['w'=>80,'h'=>80]),
            'id'=>$fid,
          ] ;
        }
        return $data;
    }

	/**
    * ajax显示列表
    * @return [type] [description]
    */
    public function grid(){
      $res = db($this->table)
        ->where('wid',$this->wid())
        ->order('id','desc')->paginate(10);
      $count = $res->total();
      foreach ($res as $key => $v) { 
         $data[] = [
            'title' => $v['title'],
            'price' => $v['price'],
            'opt' => \THtml::tag([
                     'name'=>'a',
                     'label'=>lang('Edit'), 
                     'attr'=>[ 
                         'class'=>'layui-btn layui-btn-primary layui-btn-xs',
                         'href'=>url('admin/goods/form',['id'=>$v['id']]),
                     ],
                     'close'=>'a'
              ]) 
         ];
      }
      return [
        'data'=>$data,
        'code'=>0,
        'count'=>$count
      ];
    }
    /**

    /**
    * 保存到数据库
    * @param  [type] $data [description]
    * @return [type]       [description]
    */
    public function save($data){
      $arr['title'] = $data['title']; 
      $arr['content']  = $data['content']; 
      $arr['status'] = $data['status']?:1;
      $arr['price']  = $data['price']; 
      $arr['type_id']  = $data['type_id']; 
      $arr['created']  = time(); 
      $arr['wid']  = $this->wid(); 
      $where = [
         'id'=>$data['id'], 
      ]; 
      $nid = $this->baseSave(['data'=>$arr,'where'=>$where]);

      $this->saveFile($nid,$data);
      return $nid;
    }

    /**
     * 保存图片
     * @param  [type] $nid  [description]
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function saveFile($nid,$data){
        /**
        * 写入图片关联表
        */
        $t = $this->ftable;
        $video = $data['node-video'];
        $image = $data['node-image'];
        db($t)->where(['goods_id'=>$nid])->delete();
        $insert = [];
        if($image){
          foreach($image as $fid){
            $insert[] = [
                'goods_id'=>$nid,
                'fid'=>$fid
            ];
          }
        }
        if($video){
          foreach($video as $fid){
            $insert[] = [
                'goods_id'=>$nid,
                'fid'=>$fid
            ];
          }
        }

        db($t)->insertAll($insert);
    }

	 

}