<?php
/**
 *
 * 无限分类管理
 *
 * 生成包： https://github.com/BlueM/Tree
 * 
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 * 
 */ 
namespace app\lib;


use app\common\model\Type as M;
use app\facade\Pinyin;
class Type  extends DB{
	
	public $table = 'types';
	/**
     * 需要翻译的字段
     * @var array
     */
    public $lang_field = ['name'];
    /**
     * 多语言表
     * @var string
     */
    public $lang_table = 'type_lang';
    /**
     * 对应语言表的字段
     * @var [type]
     */
    public $lang_pk = 'type_id';
  	 

	/**
    * ajax显示列表
    * @return [type] [description]
    */
    public function grid(){
 
      $res = db($this->table)->order('id','desc')->select();
      
      foreach ($res as $key => $v) { 
          $data[] = [
            'id'   => $v['id'],
            'name' => $v['name'],
            'pid'  => $v['pid'],
            
            'uni'  => $v['uni'],
           
            'opt' => "<a class='layui-btn layui-btn-primary layui-btn-xs' href='".url('admin/types/form',['id'=>$v['id']])."'>".lang('Edit')."</a>",
          ];
      }
      return [
        'data'=>$data,
        'code'=>0,
        'count'=>count($res)
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
      $arr['uni']  =  Pinyin::abbr($data['name'][1]); 
      $arr['type'] = $data['type']?:'goods';
      $arr['pid']  = $data['pid']?:0; 
      $arr['wid']  = $this->wid();
       
      $where = [
         'id'=>$data['id'], 
      ]; 
      return $this->baseSave(['data'=>$arr,'where'=>$where]);
    }

	 

}