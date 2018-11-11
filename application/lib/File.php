<?php 
/**
 *
 * File 文件操作 
 * 
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 * 
 */
namespace app\lib;
use Symfony\Component\Finder\Finder;
class File extends DB {
    /**
     * 表名
     * @var string
     */
    public $table = 'files';
    /**
     * url函数后，保存DB数据
     * @var array
     */
    public $row = [];
    /**
     * url方式的快速访问
     * @param  int|files row $id 主键或数组
     * @return string
     */
    public function id($id){
        return $this->url($id);
    }
    /**
     * 通过ID,或files row来生成图片
     * @param  int|files row $id  主键或数据
     * @param  array  $par 图片参数
     * @return string
     */
    public function url($id,$par = []){
        if(is_numeric($id)){
            $row = $this->get($id);    
        }else{
            $row = $id;
        } 
        if(!$row){
            return false;
        }
        $url = $row['url'];
        $yun = $row['yun'];
        $par['drive'] = $yun;
        $this->row = $row;
        return \app\facade\Img::run($url,$par);
    }
    /**
     * 调用url函数后再调用此方法，取得数组
     * @return array
     */
    public function getRow(){
        return $this->row;
    }
    /**
    * ajax显示列表
    * @return [type] [description]
    */
    public function grid(){
      $res = db($this->table)
          ->where('wid',$this->wid())
          ->order('id','desc')
          ->paginate(10);
      $count = $res->total();
      foreach ($res as $key => $v) {
         $data[] = [
            'name' => $v['name'],
            'url' => $v['url'], 
            'opt' => "<a href='".url('admin/uploads/form',['id'=>$v['id']])."'>".lang('Edit')."</a>",
         ];
      }
      return [
        'data'=>$data,
        'code'=>0,
        'count'=>$count
      ];
    }


    /**
     * 复制目录
     * @param  [type] $src  [description]
     * @param  [type] $dest [description]
     * @param  [type] $pre 前缀
     * @return [type]       [description]
     */
	public function copy($src, $dest )
    {
        $src = str_replace(DS,'/',$src);
        $dest = str_replace(DS,'/',$dest); 
        if(is_dir($dest)){
            return;
        }
        if(!is_dir($dest)){
            mkdir($dest,0777,true);  
        }

        $finder = new Finder();
        $finder->files()->in($src);
        foreach ($finder as $file) { 
            $fs = $file->getRealPath(); 
            $new = $dest.substr($fs,strlen($src));
            $dir_new = $this->dir($new);
            if(!is_dir($dir_new)){
                mkdir($dir_new,0777,true);
            } 
            copy($fs,$new); 
        } 
        return true;
    }
    /**
     * 取得文件名，不包含后缀
     * @param  [type] $file [description]
     * @return [type]       [description]
     */
    public function name($file){ 
        $s = strrpos($file,'/');
        $str =  substr($file,$s+1);
        $e = strrpos($str,'.');
        return  substr($str,0,$e);
    }
    /**
     * 获取不包含文件名的路径
     * @param  [type] $file [description]
     * @param  [type] $ds 
     * @return [type]       [description]
     */
    public function dir($file){
        $file = str_replace('\\','/',$file);
        $ds = '/';
        $len = strrpos($file,$ds); 
        return substr($file,0,$len);
    }
    /**
     * 后缀 jpg png jpeg 等
     * @param  [type] $file [description]
     * @return [type]       [description]
     */
    public function ext($file){ 
        return substr($file,strrpos($file,'.')+1);
    }
	   

}