<?php 
namespace app\lib\upload;
/** 
 *  
 * 
 * 上传文件到 百度 bos
 * 
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 */
import(__DIR__.'/BaiduBce.phar');
use BaiduBce\BceClientConfigOptions;
use BaiduBce\Util\Time;
use BaiduBce\Util\MimeTypes;
use BaiduBce\Http\HttpHeaders;
use BaiduBce\Services\Bos\BosClient;
use BaiduBce\Services\Bos\BosOptions; 

class Baiduyun {
	/**
	 * League\Flysystem\Filesystem
	 * @var [type]
	 */
	public $filesystem;
	/**
	 * URL 带http:// 或 htps://
	 * @var [type]
	 */
	public $url;

	public $bucket_name;
	/**
	 * 初始化
	 * @param  [type] $config [description]
	 * @return [type]         [description]
	 */
	public function init($config){   
		$endpoint = $config['endpoint'];
		$cdn = $config['cdn'];
		$endpoint = replace(['http://','https://'],'', $endpoint);
		$ori = "https://".$config['bucket_name'].'.'.$endpoint;  
		$this->url = $cdn?:$ori;

		$this->filesystem = new BosClient([ 
				'credentials' => [
		            'accessKeyId' => $config['access_key'],
		            'secretAccessKey' =>$config['secret_key'] ,
		        ],
		    	'endpoint' => $endpoint,  
		]);
		$this->bucket_name = $config['bucket_name'];
		return $this;
	}

	public function get_bucket($bucketName){
		$exist = $this->filesystem->doesBucketExist($bucketName);
		if(!$exist){
			return false;
		    //$this->filesystem->createBucket($bucketName);
		}
		return $bucketName;
	}

	/**
	 * 上传内容到BOS
	 * @param  [type] $online_file [description]
	 * @param  [type] $content     [description]
	 * @return [type]              [description]
	 */
	public function write($online_file,$content){
		$this->filesystem->putObjectFromString($this->bucket_name,$online_file,$content);
	}
	/**
	 * 上传文件到BOS
	 * @param  [type] $local_file  [description]
	 * @param  [type] $online_file [description]
	 * @return [type]              [description]
	 */
	public function upload($local_file,$online_file){ 

		try {
		   	$res = $this->filesystem->putObjectFromFile($this->bucket_name, $online_file , $local_file); 
			 
			if($res){
				return $this->url.$online_file;
			}

		} catch (\BaiduBce\Exception\BceBaseException $e) {
		     return false;
		}
 
		return false;
	}
	/** 
	 * 图片处理，图片缩放 水印等
	 *  请参考  
	 *   https://cloud.baidu.com/doc/BOS/API.html#.01.EA.A9.66.20.89.9A.78.6B.6D.E8.EE.63.2A.3D.3B
	 *  
	 * @param  [type] $url [description]
	 * @param  array  $par [description]
	 * @return [type]      [description]
	 */
	public function action($url,$par = [
		'type'=>'resize',
		'h'=>100,
		'm'=>'pad',
		'color'=>'FF0000'
	]){
		$type = $par['type']?:'resize';
		/**
		 * 需要 base64_encode  的数据
		 * @var [type]
		 */
		$be4 = [
			'text'
		];
		foreach($be4 as $v){
			if($par[$v]){
				$par[$v] = base64_encode($par[$v]);
			}
		} 
		unset($par['type']);
		$ext = '@';
		foreach($par as $k=>$v){
			$str .= $k."_".$v.',';
		}
		$str = substr($str,0,-1);
		if(!$str){
			return $url;
		}
		return $url.$ext.$str;
	}

}