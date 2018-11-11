<?php 
namespace app\lib\upload;
/** 
 * https://github.com/thephpleague/flysystem
 * 
 * 上传文件到 Aliyun bos
 * 
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 */
use League\Flysystem\Filesystem;
use Xxtime\Flysystem\Aliyun\OssAdapter;

class Aliyun {
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
		$this->filesystem = new Filesystem(new OssAdapter([
		    'access_id'     =>  $config['access_key'],
		    'access_secret' =>  $config['secret_key'],
		    'bucket'        =>  $config['bucket_name'], 
		    'endpoint'       => $endpoint,
		    'timeout'        => 3600,
		    'connectTimeout' => 10,
		]));
		return $this;
	}
	/**
	 * 上传内容到BOS
	 * @param  [type] $online_file [description]
	 * @param  [type] $content     [description]
	 * @return [type]              [description]
	 */
	public function write($online_file,$content){
		$this->filesystem->write($online_file,$content);
	}
	/**
	 * 上传文件到BOS
	 * @param  [type] $local_file  [description]
	 * @param  [type] $online_file [description]
	 * @return [type]              [description]
	 */
	public function upload($local_file,$online_file){ 
		$stream = fopen($local_file, 'r+');
		$res = $this->filesystem->writeStream($online_file, $stream);
		if (is_resource($stream)) {
		    fclose($stream);
		}
		if($res){
			return $this->url.$online_file;
		}
		return false;
	}
	/** 
	 * 图片处理，图片缩放 水印等
	 *  请参考  
	 *  https://help.aliyun.com/document_detail/44688.html
	 *  https://help.aliyun.com/document_detail/44957.html
	 *  ?x-oss-process=image/resize,m_pad,h_100,w_100,color_FF0000
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
		$ext = '?x-oss-process=image/'.$type;
		foreach($par as $k=>$v){
			$str .= ','.$k."_".$v;
		}
		if(!$str){
			return $url;
		}
		return $url.$ext.$str;
	}

}