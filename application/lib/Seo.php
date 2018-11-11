<?php
/**
 * Seo
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 * @date    2018年11月1日
 */ 
namespace app\lib;
 
class Seo extends DB{
     
     /**
      * 首页的SEO
      * @return [type] [description]
      */
     public function top(){
        $val = \app\facade\Config::getKey('default'); 
        $seo_keywords = $val['seo']['keywords'];
        $seo_description = $val['seo']['description'];
        $this->output($seo_keywords,$seo_description);
     }
     /**
      * 输出SEO标签
      * @param  [type] $seo_keywords    [description]
      * @param  [type] $seo_description [description]
      * @return [type]                  [description]
      */
     public function output($seo_keywords,$seo_description){
        echo "
          <meta name=\"keywords\" content=\"".$seo_keywords."\" />\n
          <meta name=\"description\" content=\"".$seo_description."\" />\n 
        ";
     }
   

}