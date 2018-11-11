<?php 
namespace app\facade;

use think\Facade;

class File extends Facade
{
    protected static function getFacadeClass()
    {
    	return 'app\lib\File';
    }
}