<?php
/**
 * 菜单
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 * @date    2018年11月1日
 */ 
namespace app\lib;
use BlueM\Tree;
class Menu extends DB{
    public $table = 'menus'; 
    /**
     * 需要翻译的字段
     * @var array
     */
    public $lang_field = ['name'];
    /**
     * 多语言表
     * @var string
     */
    public $lang_table = 'menu_lang';
    /**
     * 对应语言表的字段
     * @var [type]
     */
    public $lang_pk = 'menu_id';
    /**
    * ajax显示列表
    * @return [type] [description]
    */
    public function grid(){
      $res = db($this->table)
          ->where('wid',$this->wid())
          ->order('id','desc')
          ->paginate(10);
      $count = $res->total();
      foreach ($res as $key => $v) {
         $data[] = [
            'name' => $v['name'],
            'url' => $v['url'],
             
            'opt' => \THtml::tag([
                     'name'=>'a',
                     'label'=>lang('Edit'), 
                     'attr'=>[ 
                         'class'=>'layui-btn layui-btn-primary layui-btn-xs',
                         'href'=>url('admin/menus/form',['id'=>$v['id']]),
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
      $arr['name'] = $data['name'];
      $arr['url'] = $data['url'];
      $arr['is_delete'] = $data['is_delete']?:0;
      $arr['type'] = $data['type']?:'theme';
      $arr['pid'] = $data['pid']?:0; 
      $arr['wid'] = $this->wid(); 
      $where = [
         'id'=>$data['id'], 
      ]; 
      return $this->baseSave(['data'=>$data,'where'=>$where]);
    }

   

}