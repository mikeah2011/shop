<?php
/**
 * 登录后首页
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 */
namespace app\admin\controller;

 
use think\Request;

class Index extends \app\AdminController
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
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function welcome()
    {
        return view('welcome');
    }

     
}
