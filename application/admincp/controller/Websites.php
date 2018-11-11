<?php
/**
 * 开通网站
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 */
namespace app\admincp\controller;
use app\facade\Website as Model;

 
use think\Request;

class Websites extends Base
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
        $data = Model::grid(); 
        return return_json($data);
    }

    /**
    * 表单操作
    * @return [type] [description]
    */
    public function form(){ 
        if(is_ajax()){ 
            $ret = validate('Website',$_POST);
            if($ret){
                return $ret;
            }
            Model::save($_POST);
           
            return return_json(['status'=>1,'code'=>0,'msg'=>lang('Save Success')]);
        }
        
        $data['list'] = Model::list();
        $id = input('get.id');
        
        if($id){
            $data['row'] = Model::get($id);
        }

         
        return view('form',$data);
    }

     
}
