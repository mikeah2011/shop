<?php
/**
 * 字符串处理
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 */
namespace app\lib;

class Str{


	static $size = ['B', 'KB', 'MB', 'GB', 'TB'];
	/**
	 * 生成不重复字符串　
	 *
	 * @link http://docs.mongodb.org/manual/reference/object-id/
	 * @return string 24 hexidecimal characters
	 */
	public function id()
	{
	    static $i = 0;
	    $i OR $i = mt_rand(1, 0x7FFFFF);
	 
	    return sprintf("%08x%06x%04x%06x",
	        /* 4-byte value representing the seconds since the Unix epoch. */
	        time() & 0xFFFFFFFF,
	 
	        /* 3-byte machine identifier.
	         *
	         * On windows, the max length is 256. Linux doesn't have a limit, but it
	         * will fill in the first 256 chars of hostname even if the actual
	         * hostname is longer.
	         *
	         * From the GNU manual:
	         * gethostname stores the beginning of the host name in name even if the
	         * host name won't entirely fit. For some purposes, a truncated host name
	         * is good enough. If it is, you can ignore the error code.
	         *
	         * crc32 will be better than Times33. */
	        crc32(substr((string)gethostname(), 0, 256)) >> 16 & 0xFFFFFF,
	 
	        /* 2-byte process id. */
	        getmypid() & 0xFFFF,
	 
	        /* 3-byte counter, starting with a random value. */
	        $i = $i > 0xFFFFFE ? 1 : $i + 1
	    );
	}  
	 
	/**
	* 生成不重复订单ID
	*/
	public function order_id()
	{
		mt_srand((double) microtime() * 1000000);  
        return date('Ymdhis') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);   
	}
	/**
	* 折扣 100 1 0.1折
	* @param string $size 
	* @return string　 
	*/
    public function discount($price,$nowprice) 
	{
		  return round(10 / ($price / $nowprice), 1); 
	} 
	/**
	* 多少岁
	* @return string　 
	*/
    public function age($bornUnix) 
	{
		if(strpos($bornUnix,' ')!==false || strpos($bornUnix,'-')!==false){
			$bornUnix = strtotime($bornUnix); 
		}
		return ceil((time()-$bornUnix)/86400/365);	
	 	
	} 
	/**
	* 计算时间剩余　２天３小时２８分钟１０秒
	* 返回　　[d h m s]
	* @return string　 
	*/
    public function less_time($a ,$b = null) 
	{
			if(!$b) $time = $a;
			else $time = $a-$b;
			if($time<=0) return -1;
			$days = intval($time/86400);
			$remain = $time%86400;
			$hours = intval($remain/3600);
			$remain = $remain%3600;
			$mins = intval($remain/60);
			$secs = $remain%60;
			return ["d" => $days,"h" => $hours,"m" => $mins,"s" => $secs]; 
	} 
	/**
	* 点击链接 字段值加减到地址栏
	* @return string　 
	*/
	public function url($type,$value){
		$mi = false;
		if(strpos($type,'[]')) {
			$type = str_replace('[]','',$type);
			$mi = true;
		}
		$get = $_GET;
		$v = $get[$type]; 
		if(is_array($v)){
			if(in_array($value,$v))
				unset($get[$type][array_search($value,$v)]);
			else{
				$get[$type][] = $value; 
			}
		}else{
			if($v == $value)
				unset($get[$type]);
			else{ 
				if(!$v && $mi==true) {
					$get[$type.'[]'] = $value; 
				}else{
					$get[$type] = $value; 
				}
			}
		} 
		return $get;
	}
	/**
	* 字节单位自动转换 显示1GB MB等
	* @param string $size 
	* @return string　 
	*/
    public function size($size) 
	{
		 $units = static::$size; 
		 for ($i = 0; $size >= 1024 && $i < 4; $i++) {
		 		$size /= 1024; 
		 }
		 return round($size, 2).' '.$units[$i]; 
	}
	/**
	* 字节单位自动转换到指定的单位
	* @param string $size 　 
	* @param string $to 　
	* @return string
	*/
	public function size_to($size,$to = 'GB'){
		 $size = strtoupper($size);
		 $to = strtoupper($to);
		 $arr = explode(' ',$size);
		 $key = $arr[1];
		 $size = $arr[0]; 
		 $i = array_search($key,static::$size);
		 $e = array_search($to,static::$size);
		 $x = 1;
		 if($i < $e ){
			 for($i;$i<$e;$i++){
				$x *= 1024;
			 }  
			 return round($size/$x,2); 
		 }
		 for($e;$e<$i;$e++){
			$x *= 1024;
		 }  
		 return $size*$x; 
	} 
    
	 
	/**
	* 随机数字
	* @param string $j 位数 　 
	* @return nubmer
	*/
	public function rand_number($j = 4 ){
		$str = null;
		for($i=0;$i<$j;$i++){
			$str .= mt_rand(0,9);
		}
		return $str;
	} 
    /**
	* 随机字符
	* @param string $j 位数 　 
	* @return string
	*/
	public function rand($j = 8){
		$string = "";
	    for($i=0;$i < $j;$i++){
	        srand((double)microtime()*1234567);
	        $x = mt_rand(0,2);
	        switch($x){
	            case 0:$string.= chr(mt_rand(97,122));break;
	            case 1:$string.= chr(mt_rand(65,90));break;
	            case 2:$string.= chr(mt_rand(48,57));break;
	        }
	    }
		return strtoupper($string); //to uppercase
	}
	/**
	* 组织URL query string,没有问号的
	* @param array $arr 
	* @return string		
	*/
	public function query_build($arr = []){
		if(!is_array($arr) || !implode('',$arr)) return;
		foreach($arr as $k=>$v){
			$str .="$k=$v&";
		}
		return substr($str,0,-1);
	}

	
	/**
	 * 内容 批量替换
	 *
	 * 
	 * @param  string $body    HTML内容
	 * @param  array  $replace 数组替换
	 * @return string
	 */
	public function new_replace($body,$replace=array()){ 
		foreach($replace as $k=>$v){
			$body = str_replace($k,$v,$body);
		}
	 	return $body;
	}
	  
	/**
	 * 截取后，用 ...代替被截取的部分
	 * @param  string $string 字符串
	 * @param  int $length 截取长度
	 * @return string
	 */
	public function cut($string, $length) {
	    preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $string, $info);
	    for($i=0; $i<count($info[0]); $i++) {
	        $wordscut .= $info[0][$i];
	        $j = ord($info[0][$i]) > 127 ? $j + 2 : $j + 1;
	        if ($j > $length - 3) {
	            return $wordscut." ...";
	        }
	    }
	    return join('', $info[0]);
	}

	/**
	 * 判断字符串是否为utf8编码，
	 * 英文和半角字符返回ture 
	 */
	public function is_utf8($string) {
		return preg_match('%^(?:
		[\x09\x0A\x0D\x20-\x7E] # ASCII
		| [\xC2-\xDF][\x80-\xBF] # non-overlong 2-byte
		| \xE0[\xA0-\xBF][\x80-\xBF] # excluding overlongs
		| [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} # straight 3-byte
		| \xED[\x80-\x9F][\x80-\xBF] # excluding surrogates
		| \xF0[\x90-\xBF][\x80-\xBF]{2} # planes 1-3
		| [\xF1-\xF3][\x80-\xBF]{3} # planes 4-15
		| \xF4[\x80-\x8F][\x80-\xBF]{2} # plane 16
		)*$%xs', $string);
	}
	 
	
}