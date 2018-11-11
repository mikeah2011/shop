<?php 
/**
 *
 * HTML
 * 生成html标签
 * 加载不重复的JS CSS文件
 * 
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 * 
 */
namespace app\lib;

class Html {
	 
	 static $_files;
	 /**
	  * JS文件加载不重复
	  * @param  [type] $file [description]
	  * @return [type]       [description]
	  */
	 public function js_file($file = null){
	 	return $this->_files($file,'script',[
	 		'type'=>'text/javascript',
	 		'charset'=>'utf-8',
	 		'spec'=>'src'
	 	],'script');
	 }
	 /**
	  * CSS文件加载不重复
	  * @param  [type] $file [description]
	  * @return [type]       [description]
	  */
	 public function css_file($file = null){
	 	return $this->_files($file,'link',[
	 		'rel'=>'stylesheet',
	 		'spec'=>'href',
	 		'media'=>'all'
	 	]);
	 }	
	 /**
	  * link 
	  * @param  [type] $file [description]
	  * @param  string $type [description]
	  * @return [type]       [description]
	  */
	 protected function _files($file = null, $type = "script",$attr = [
	 	'rel'=>'stylesheet',
	 	'spec'=>'href'
	 ],$colse = ''){ 
	 	$str = '';
	    if($file){
	        $key  = md5($file);
	        if(!static::$_files[$type][$key]){
	            static::$_files[$type][$key] = $file;
	        }
	    }else{
	        if(static::$_files[$type]){
	           $spec = $attr['spec'];
	           unset($attr['spec']); 
	           foreach(static::$_files[$type] as $v){ 
	           		$attr[$spec] = $v;
	                $str .= $this->tag([
	                	'name'=>$type,
	                	'attr'=>$attr,
	                	'close'=>$colse
	                ]);
	           } 
	        }
	    }
	    return $str;
	 }
 
	 /**
	  * tag([
      *  	'name'=>'script',
      *  	'attr'=>[ 
      *  		'src'=>$v,
      *  	],
      *  	'close'=>'script'
      *  ]);
	  * @param  array  $arr [description]
	  * @param  array  $sline 在标签是非闭合的情况下，可以在>
	  * 前加内容，如img标签 /
	  * @return [type]      [description]
	  */
	 public function tag($arr = [],$sline = ''){
	 	$attr = $arr['attr'];
	 	$close = $arr['close'];
	 	$name = $arr['name'];
	 	$label = $arr['label'];
	 	$str = "<".$name;
	 	foreach($attr as $k=>$v){
	 		$str.=" $k=\"".$v."\" ";
	 	}
	 	$str = $str." ".$sline.">";
	 	if($close){
	 		if($label){
	 			$str .= $label;
	 		}
	 		$str.="</".$close.">";
	 	}
	 	return $str;
	 }

	 

}



