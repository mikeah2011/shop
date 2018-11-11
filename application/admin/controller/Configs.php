<?php
/**
 * 配置系统信息
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 */
namespace app\admin\controller;
use app\facade\Config;
use app\facade\Lang;
 
class Configs extends \app\AdminController
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {   
         
        if(is_ajax()){
            Config::save($_POST['config']);
            return return_json([
                'code'=>0,
                'status'=>1,
                'msg'=>lang('Save settings success')
            ]);
        }
       
        $list =  Lang::list(); 
        //语言列表
        $data['list'] = $list;
        //激活的语言
        $data['listActive'] = Lang::active();
        //配置信息
        $data['val'] = Config::getKey('default'); 
        //短信通道
        $data['sms_channel'] = lang_array(config('app.sms_channel'));;
        //上传渠道
        $data['upload_channel'] = lang_array(config('app.upload_channel'));

        return view('index',$data);
    }

 
     
}
