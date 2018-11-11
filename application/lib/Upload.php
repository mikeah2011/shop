<?php
/**
 * Upload 统一上传文件
 * 不区分图片、文件、视频。都在这个类完成
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 * @date    2018年11月1日
 */ 
namespace app\lib;
use app\facade\File;
use app\facade\Config;
class Upload extends DB{  
    /**
     * 使用的是 ali_bos 还是其他的
     * @var [type]
     */
    public $channel;
    /**
     * 云存储BOS OSS配置
     * @var [type]
     */
    public $yun_config;
    /**
     * 防止重复加载getConfig
     * @var [type]
     */
    static $_config;
    /**
     * 配置中与实际使用中的类对应
     * 
     * @var [type]
     */
    public $class = [
      'ali_bos'=>'\app\lib\upload\Aliyun',
      'baidu_bos'=>'\app\lib\upload\Baiduyun',
    ];
    /**
     * 直接用drive快速找到对应的驱动。
     * 配合$class一起使用
     * @var [type]
     */
    public $classFast = [
        1=>'ali_bos',
        2=>'baidu_bos',
    ];
    /**
     * 取得drive id=>value
     * @return [type] [description]
     */
    public function getClassFast(){
        return $this->classFast;
    }
    /**
     * 设置drive
     * @param array $class [description]
     */
    public function setClassFast($class = []){
        $this->classFast = array_merge($this->classFast,$class);
    }
    /**
     * 获取云存储对应class
     * @return [type] [description]
     */
    public function getClass(){
      return $this->class;
    }
    /**
     * 设置云存储对应class
     * @param array $class [description]
     */
    public function setClass($class = []){
        $this->class = array_merge($this->class,$class);
    }
    
    /**
     * 获取配置
     * @return [type] [description]
     */
    public function getConfig($channel = null){
        if(static::$_config[$channel]){
            return static::$_config[$channel];
        }
        if(is_numeric($channel)){
            $channel = $this->classFast[$channel];
        }
        $val  = Config::getKey('default');  
        if(!$channel){
            $channel = $val['upload']['channel'];
        } 

        if($channel && $yun_config = $val[$channel]){ 
            $class = $this->class[$channel];
            if(!$class){
              exit('配置错误');
            } 
        }
        static::$_config[$channel] = $class; 
        $this->channel = $channel;
        $this->yun_config = $yun_config; 
        return $class;
    }
    /**
     * 执行上传文件
     *
     * $_config 数组配置
     * uid 
     * size 上传文件的最大字节
     * ext  文件后缀，多个用逗号分割或者数组
     * type  文件MIME类型，多个用逗号分割或者数组
     * 请参考 
     * @param  [type] $name [description]
     * @param  [type] $_config [description]
     * @return [type]       [description]
     */
    public function run($name,$_config = []){
        $class = $this->getConfig();
        $yun_config = $this->yun_config;
        $channel = $this->channel; 
        $file = request()->file($name);
        /**
         * 用户ID
         * @var [type]
         */
        $uid = $_config['uid']?:0;
        unset($_config['uid']);
        $url_pre = '/upload/'.'w'.$this->wid().'u'.$uid.'/'.date('Y').'/'.date('m').'/';
        $path = WEB_PATH.$url_pre;
        if(!is_dir($path)){
          mkdir($path,0777,true);
        }
        
        /**
         * 配置文件大小
         */
        $_config['size'] = $_config['size']?:5*1024*1024;
        $_config['ext'] = $_config['ext']?:'jpg,png,gif';
        $info = $file->validate($_config)->rule('uniqid')->move($path);
        if($info){ 
            $hash = $info->hash('sha1');
            $find = File::init()->where(['hash'=>$hash])->find();
            if($hash && $find){ 
                $rt = [
                  'id'=>$find['id'],
                  'url'=>$find['url'],
                  'ext'=>$find['ext'],
                ]; 
                return [
                  'code'=>0,
                  'status'=>1,
                  'msg'=>lang('had exists'),
                  'data'=>$rt
                ]; 
            } 
            $name = $info->getSaveName(); 
            $url =  $url_pre.$name;
            /**
             * 上传到百度 阿里云
             */
            if($class && $yun_config){
               $url =  (new $class)->init($yun_config)
                    ->upload(WEB_PATH.$url, $url);
               if(!$url){ 
                    return [
                      'code'=>0,
                      'status'=>0,
                      'msg'=>lang('Upload yun failed')
                    ];
               }
            }

            $url = str_replace('\\','/',$url);   
            $insert = [];
            $insert['name'] = $info->getFilename();
            $insert['ext'] = $info->getExtension();
            $insert['url'] = $url;
            $insert['hash'] = $hash;
            $insert['yun'] = $this->channel;
            $insert['uid'] = $uid;
            $insert['created'] = time();
            $insert['size'] = $info->getSize();
            $id = File::_save($insert); 
            $msg = lang('Upload Success');
            $status = 1;
            return [
                  'code'=>0,
                  'status'=>1,
                  'msg'=> $msg,
                  'data'=>[
                    'id'=>$id,
                    'url'=>$insert['url'],
                    'ext'=>$insert['ext'], 
                   ]
             ];
        }else{
            // 上传失败获取错误信息
            $msg =  $file->getError(); 
            return ['code'=>0,'status'=>0 , 'msg'=>$msg];
        }
        
    }
     
    

   

}