<?php
/**
 * 数据库备份等操作
 *
 * @master
 * @license 版权所有，商用请获取软件使用授权！
 * @author  上海起合文化传播有限公司 
 * @link    www.qihewenhua.cn
 * @version since 5.0.1 
 */
namespace app\admincp\controller; 


class Database extends Base
{
    
    protected $dir;
    protected $bin;

    public function init(){
        parent::init();
        $this->dir = BASE_PATH.'/data/db_backup';

        if(!is_dir($this->dir)){
            mkdir($this->dir, 0777,true);
        }
        $sql = "SHOW VARIABLES LIKE  '%basedir%'";
        $row = db()->query($sql); 

        $val = $row[0]['Value']?:$row[0]['value'];

        $this->bin = $val.'/bin/'; 
         
        return parent::init(); 

    }
    public function index()
    {
        return view('index');
    }

    public function backup(){ 
         
        $file = $this->dir.'/'.date('Ymd-H-i-s',time()).'.sql';  
        $query = $this->bin."mysqldump  -u".config('database.username')."  -p".config('database.password') ."    ".config('database.database')."  > ".$file;  

        trace('backup sql:'.$query,'system');

        exec($query);
        
        return return_json(['code'=>0,'status'=>1,'msg'=>lang('Backup Success')]);


    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function ajax()
    { 
        $list = glob($this->dir.'/*.sql'); 
        foreach($list as $v){
            $arr[] = [
                'name' => substr($v,strrpos($v,'/')+1),
                'file' =>$v,
                'size' => \app\facade\Str::size(filesize($v))
            ];
        }  

        $arr = array_reverse($arr);
         $data['code'] = 0;
         $data['count'] = count($arr);
         $data['data'] = $arr;
         return return_json($data);
    }

     
}
