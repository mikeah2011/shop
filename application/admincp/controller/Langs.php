<?php
/**
 * 语言包管理
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 */
namespace app\admincp\controller;

 
use app\facade\Lang;

class Langs extends Base
{
    /**
     *  首页
     */
    public function index()
    {
        $list[0] = lang('Please Choice');
        $list = $list+Lang::list();

        $data['list'] = $list;
        $data['listActive'] = Lang::active();
        return view('index',$data);
    }

    /**
     * 列表AJAX显示
     * @return [type] [description]
     */
    public function grid(){
        $data = Lang::grid(); 
        return return_json($data);
    }
 

    /**
    * 表单操作
    * @return [type] [description]
    */
    public function form(){

        if(is_ajax()){
            $ret = validate('Lang',$_POST);
            if($ret){
                return $ret;
            }
            Lang::save($_POST);
            $this->create(true);
            return return_json(['status'=>1,'code'=>0,'msg'=>lang('Save Success')]);
        }
        
        $data['list'] = Lang::list();
        $id = input('get.id');
        
        if($id){
            $data['row'] = Lang::get($id);
        }

         
        return view('form',$data);
    }
    /**
     *  生成语言文件
     */
    public function create($return = false)
    {

        Lang::createFiles();
        if($return){
            return;
        }

        return return_json(['status'=>1,'msg'=>lang('Create Language Files Success')]);
    }

     
}
