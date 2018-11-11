<?php
/**
 * 退出系统
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司
 * @link    www.qihewenhua.cn 
 * @version since 5.0.1 
 */
namespace app\admincp\controller;

 
use think\Request;

class Logout extends Base
{
     
    public function index()
    {
        return view('index');
    } 
}
