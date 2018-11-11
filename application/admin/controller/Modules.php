<?php
/**
 * 模块管理
 * 
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 */
namespace app\admin\controller;
use app\facade\Menu;
use app\facade\Module;
use think\Request;

class Modules extends \app\AdminController
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {

        return view('index');
    }

    /**
     * 列表AJAX显示
     * @return [type] [description]
     */
    public function grid(){
        $data = Module::grid(); 
        
        return return_json($data);
    }
    /**
     * 改变状态，删除操作
     * @return [type] [description]
     */
    public function status(){
       $html = Module::status(input('get.slug'));
       $data = [
            'code'=>1,
            'status'=>1,
            'msg'=>lang('Change Success'),
            'js'=>"obj.parent('.layui-table-cell').html('".$html."');"
        ];
         
        
       return return_json($data);
    }

    /**
    * 表单操作
    * @return [type] [description]
    */
    public function form(){
        $id = input('get.id');
        if(is_ajax()){
            $data = $_POST;
            $data['id'] = $id;
            $ret = validate('Menu',$_POST);
            if($ret){
                return $ret;
            }
            Menu::save($data);
           
            return return_json(['status'=>1,'code'=>0,'msg'=>lang('Save Success')]);
        }   

        $data['list']  = Menu::tree();
        if($id){
            $data['row'] = Menu::get($id);
        }  
         
        return view('form',$data);
    }

     
}
