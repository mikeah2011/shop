<?php 
/**
 *
 *  图片处理，图片缩放 水印等
 *  请使用image函数生成。
 *  image(id|url|files_row,$par)
 *  请参考  
 *  本地
 *  https://www.kancloud.cn/manual/thinkphp5_1/354123
 *  阿里
 *  https://help.aliyun.com/document_detail/44688.html
 *  百度
 *  https://cloud.baidu.com/doc/BOS/API.html#.01.EA.A9.66.20.89.9A.78.6B.6D.E8.EE.63.2A.3D.3B
 *  
 *   
 * 
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 * 
 */
namespace app\lib;
use app\facade\Upload;
use app\facade\File;
class Img {
	
	/**
	* 本地图片处理
	* @param  [type] $file [description]
	* @param  [type] $w    [description]
	* @param  [type] $h    [description]
	* @return [type]       [description]
	*/
	public function action($file, $par = []){ 
		if(!$par){
			return $file;
		}
		if(substr($file,0,1)!='/'){
			$file = '/'.$file;
		}
		$ori_file = WEB_PATH.$file;
		$new_file = WEB_PATH.'/thumb'.$file;
		$dir = File::dir($new_file);
		if(!is_dir($dir)){
			mkdir($dir,0777,true);
		}
		//文件名，不包含后缀
		$name = File::name($file);
		//后缀，不包含.
		$ext = File::ext($file); 
		$name = $name . '-'.md5(json_encode($par)).'.'.$ext;
		$new_file = $dir.'/'.$name;
		$new_url = substr($new_file,strlen(WEB_PATH));
		/**
		 * 判断图片在不在，如果存在就返回
		 */
		if(file_exists($new_file)){
			return $new_url;
		}
		/**
		 * 生成图片
		 */
		$img = \think\Image::open($ori_file);
		foreach($par as $action=>$opts){
			$img = call_user_func_array([$img,$action], $opts);
		} 
				  
		$img->save($new_file); 
		return $new_url;
	}

	/**
	* 生成缩略图
	* @param  [type] $url [description]
	* @param  array  $par [description]
	* @return [type]      [description]
	*/
	public function run($url,$par = []){
			$drive = $par['drive']?:'ali_bos'; 
			unset($par['drive']);
			if($drive){
				$class = Upload::getConfig($drive);
			}else{
				return $url;
			}
	  	if(!$class){
	  		return $url;
	  	}
		return init_class($class)->action($url,$par);
	}
	/**
	 * 取得本地地址
	 * @param  string  $content 内容
	 * @param  boolean $all     是否是所有的，默认false
	 * @return string
	 */
	public function get_local_img($content,$all=false){ 
		$preg = '/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i'; 
		preg_match_all($preg,$content,$out);
		$img = $out[2];
		if($img) { 
			$num = count($img); 
			for($j=0;$j<$num;$j++){ 
				$i = $img[$j]; 
				if( (strpos($i,"http://")!==false || strpos($i,"https://")!==false ) && strpos($i,host())===false)
				{
					unset($img[$j]);
				}
			}
		}
		if($all === true){
			return $img;
		}
		return $img[0]; 
	} 
	/**
	 * 取得图片地址,不区分是否是本地的
	 * @param  string  $content 内容
	 * @param  boolean $all     是否是所有的，默认false
	 * @return string
	 */
	public function get_img($content,$all=false){ 
		$preg = '/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i'; 
		preg_match_all($preg,$content,$out);
		$img = $out[2];  
		if($all === true){
			return $img;
		}
		return $img[0]; 
	} 
	/**
	 * 移除图片标签 
	 * @param  string  $content 内容
	 * @param  boolean $all     是否是所有的，默认false
	 * @return string
	 */
	public function remove_img($content,$all=false){  
		$preg = '/<\s*img\s+[^>]*?src\s*=\s*(\'|\")(.*?)\\1[^>]*?\/?\s*>/i';
		$out = preg_replace($preg,"",$content);
		return $out;
	} 
	/**
	 * 取得图片宽高
	 * @param  string $img 物理地址
	 * @return array       [w,h]
	 */
	public function img_wh($img){
		$a = getimagesize($img);
		return array('w'=>$a[0],'h'=>$a[1]);
	}

}



