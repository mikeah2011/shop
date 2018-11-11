<?php 
namespace app\facade;

use think\Facade;

class Upload extends Facade
{
    protected static function getFacadeClass()
    {
    	return 'app\lib\Upload';
    }
}