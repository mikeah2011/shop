<?php
/**
 * 根据模块选择对应的主题模板
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 */
namespace app\lib; 
use think\App;
use think\exception\TemplateNotFoundException;
use think\Loader;
use think\Template;

class Think extends \think\view\driver\Think
{
    // 模板引擎实例
    private $template;
    private $app;

    // 模板引擎参数
    protected $config = [
        // 默认模板渲染规则 1 解析为小写+下划线 2 全部转换小写
        'auto_rule'   => 1,
        // 视图基础目录（集中式）
        'view_base'   => '',
        // 模板起始路径
        'view_path'   => 'templates',
        // 模板文件后缀
        'view_suffix' => 'html',
        // 模板文件名分隔符
        'view_depr'   => DIRECTORY_SEPARATOR,
        // 是否开启模板编译缓存,设为false则每次都会重新编译
        'tpl_cache'   => true,
    ];

    public function __construct(App $app, $config = [])
    {
        $name = 'templates';
        $m = req_arr()['m']; 
        /**
         * 依赖数据库configs表中的type为theme
         * key为theme_当前模块名，对应的val值。来判断使用的主题。
         * @var [type]
         */
        $res = db('configs')
            ->where('type','theme')
            ->where('key', 'module_'.$m) 
            ->find();
        $theme = $res['val'];
        if($theme){

        }else{
            $theme = 'default';
        } 
        /**
         * 定义主题常量  THEME_ROOT
         */
        define('THEME_ROOT',WEB_PATH.'/'.$name);
        /**
         * THEME_ROOT/theme_name
         */
        define('THEME_PATH',THEME_ROOT.'/'.$theme);
        /**
         * theme url
         */
        define('THEME_URL',base_url().'/'.$name.'/'.$theme);

        $config['view_path'] = THEME_PATH.'/'.$m.'/';  
        config('module._theme_url_',THEME_URL);
        return parent::__construct($app, $config);
    }

     
}
