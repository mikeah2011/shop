<?php 
namespace app\lib\third;

use Overtrue\Pinyin\Pinyin as PY;
/**
 *  https://github.com/overtrue/pinyin
 *  汉字转拼音
 */
class Pinyin  
{
	public $obj;
	function __construct()
	{
		 $this->obj = new PY('Overtrue\Pinyin\MemoryFileDictLoader');
		 return  $this->obj;
	}
	/**
	 * 返回汉字首字母连接起来的字符串
	 * @param  [type] $str [description]
	 * @return [type]      [description]
	 */
	public function abbr($str){
		$res =  $this->obj->abbr($str);
		return $res;
	}
}


// 小内存型
//$pinyin = new Pinyin(); // 默认
// 内存型
// $pinyin = new Pinyin('Overtrue\Pinyin\MemoryFileDictLoader');
// I/O型
// $pinyin = new Pinyin('Overtrue\Pinyin\GeneratorFileDictLoader');

//$pinyin->convert('带着希望去旅行，比到达终点更美好');