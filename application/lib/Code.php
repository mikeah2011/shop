<?php 
/**
 *
 * 购物车 
 * 
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 * 
 */
namespace app\lib;

class Code {

	 /**
	 * 压缩HTML
	 */
	public function minify($value) {
		 if(!config('app.minify')){
		 	return $value;
		 }
	     $replace = array(
            '/<!--[^\[](.*?)[^\]]-->/s' => '',
            "/<\?php/"                  => '<?php ',
            "/\n([\S])/"                => ' $1',
            "/\r/"                      => '',
            "/\n/"                      => '',
            "/\t/"                      => ' ',
            "/ +/"                      => ' ',
        );
        return preg_replace(
            array_keys($replace), array_values($replace), $value
        );
    }
	   

}