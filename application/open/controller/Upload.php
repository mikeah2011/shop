<?php
/**
 *
 * 上传文件处理
 * 
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 * 
 */ 
namespace app\open\controller; 

class Upload  
{
     /**
      * 上传文件
      * @return [type] [description]
      */
     public function index(){
     	$name = array_keys($_FILES)[0]; 
     	// 获取表单上传文件 例如上传了001.jpg
	    $res = \app\facade\Upload::run($name);
      $res['data']['thumb'] = image($res['data']['url'],['w'=>88,'h'=>88]);
      $data = $res['data'];
      /**
       * return参数会返回内容
       * 相当于 return include ...
       */
      $res['html'] = \TForm::after_upload(['data'=>$data,'name'=>$_REQUEST['id'],'return'=>true]);
	    return return_json($res);

     }
    
}
