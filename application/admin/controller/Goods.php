<?php
/**
 * 商品管理
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 */
namespace app\admin\controller;

 
use app\facade\Type;
use app\facade\Goods as Model;
class Goods extends \app\AdminController
{
    /**
     *  首页
     */
    public function index()
    {
        
         
        return view('index',[]);
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
     * 上下架
     * @return [type] [description]
     */
    public function active(){
            Model::activeSave($_POST['val']);
    }

    /**
    * 表单操作
    * @return [type] [description]
    */
    public function form(){
        /**
         * 加载插件
         */
        plugin('Ckeditor',[
            'ele'=>'#content',
            'name'=>'content',
            'par'=>[

            ]
        ]);
        plugin('Sortable',[
            'ele'=>'demo_image',
            'par'=>[
                'handle'=>'.img'
            ]
        ]);
        $data['id'] = input('get.id');
        if(is_ajax()){
            $_POST['id'] = $data['id'];
            $ret = validate('Goods',$_POST);
            if($ret){
                return $ret;
            }
            Model::save($_POST); 
            return return_json(['status'=>1,'code'=>0,'msg'=>lang('Save Success')]);
        } 
        
        $data['list'] = Type::tree();
        $id = input('get.id');
        $data['status'] = Model::getStauts();
        if($id){
            $data['row'] = Model::get($id);
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
