<?php 
namespace app\facade;

use think\Facade;

class Log extends Facade
{
    protected static function getFacadeClass()
    {
    	return 'app\lib\Log';
    }
}