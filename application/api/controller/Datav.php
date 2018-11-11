<?php
namespace app\api\controller;
/**
 * https://datav.aliyun.com/share/355944ac5e77813429db22ce074e9c9c?t=1
 * https://datav.aliyun.com/admin/screen/187793?spm=datav.10712463.0.0.15fb396764RGQf
 */
class Datav extends Base
{
    public function title()
    {
    	print_r($_REQUEST);
         return return_json(['value'=>'测试','query'=>file_get_contents('php://input')]);
    }

     
}
