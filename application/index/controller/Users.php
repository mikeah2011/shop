<?php

namespace app\index\controller;

use app\facade\User as User;

/**
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @version since 5.0.1 
 * @rzq
 */
class Users extends \app\Controller
{
    
    /**
     *  登录
     */
    public function login()
    {
        if(is_ajax()){
            $result = User::login();
            return json($result);
        } else {
            if(!$this->checkLogin()){
                return view('login');
            } else {
                return redirect('/index/users/center.html');
            }
        }
        
    }
    
    /**
     * 退出
     * @return type
     */
    public function loginout()
    {
        cookie('u',null);
        return redirect('/index/users/login.html');
    }

    /**
     * 注册
     * @return type
     */
    public function register()
    {
        if(is_ajax()){
            $result = User::register();
            return json($result);
        }
        return view('register');
    }
    
    /**
     * 收藏
     * @return type
     */
    public function collection()
    {
        
        return view('collection');
    }
    
    
    /**
     * 用户中心
     */
    public function center()
    {
        
        return view('center');
    }
    
    /**
     * 地址管理
     * @return type
     */
    public function address()
    {
        
        return view('address');
    }
    
    /**
     * 个人信息
     * @return type
     */
    public function information()
    {
        
        return view('information');
    }
    
    /**
     * 快捷支付
     * @return type
     */
    public function cardlist()
    {
        
        return view('cardlist');
    }
    
    /**
     * 账户安全
     * @return type
     */
    public function safety()
    {
        
        return view('safety');
    }
    
    /**
     * 订单管理
     * @return type
     */
    public function order()
    {
        
        return view('order');
    }
    
    /**
     * 退款退货
     * @return type
     */
    public function change()
    {
        
        return view('change');
    }
    /**
     * 评价管理
     * @return type
     */
    public function comment()
    {
        
        return view('comment');
    }
    
    /**
     * 我的积分
     * @return type
     */
    public function points()
    {
        
        return view('points');
    }
    
    /**
     * 红包
     * @return type
     */
    public function bonus()
    {
        
        return view('bonus');
    }
    
    /**
     * 优惠券
     * @return type
     */
    public function coupon()
    {
        
        return view('coupon');
    }
    
    /**
     * 账户余额
     * @return type
     */
    public function wallet()
    {
        
        return view('wallet');
    }
    
    /**
     * 账单明细
     * @return type
     */
    public function billlist()
    {
        
        return view('billlist');
    }
    
    
    /**
     * 足迹
     * @return type
     */
    public function foot()
    {
        
        return view('foot');
    }
    
    /**
     * 商品咨询
     * @return type
     */
    public function consultation()
    {
        
        return view('consultation');
    }
    
    /**
     * 意见反馈
     * @return type
     */
    public function suggest()
    {
        
        return view('suggest');
    }
    
    
    /**
     * 我的消息
     * @return type
     */
    public function news()
    {
        
        return view('news');
    }
    
    
    
    
}
