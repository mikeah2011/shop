<?php
/**
 * 分类管理
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 */
namespace app\admin\controller;

 
use app\facade\Type;

class Types extends \app\AdminController
{
    /**
     *  首页
     */
    public function index()
    {
        $data = [];
        return view('index',$data);
    }

    /**
     * 列表AJAX显示
     * @return [type] [description]
     */
    public function grid(){
        $data = Type::grid(); 
        return return_json($data);
    }
    /**
     * 激活当前语言
     * @return [type] [description]
     */
    public function active(){
            Type::activeSave($_POST['val']);
    }

    /**
    * 表单操作
    * @return [type] [description]
    */
    public function form(){

        if(is_ajax()){
            $ret = validate('Type',$_POST);
            if($ret){
                return $ret;
            }
            Type::save($_POST); 
            return return_json(['status'=>1,'code'=>0,'msg'=>lang('Save Success')]);
        }
        
        $data['list'] = Type::tree();
        $id = input('get.id');
        
        if($id){
            $data['row'] = Type::get($id);
        }

         
        return view('form',$data);
    }
    /**
     *  生成语言文件
     */
    public function create($return = false)
    {

        Type::createFiles();
        if($return){
            return;
        }

        return return_json(['status'=>1,'msg'=>lang('Create Language Files Success')]);
    }

     
}
