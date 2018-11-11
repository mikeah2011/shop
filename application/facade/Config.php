<?php 
namespace app\facade;

use think\Facade;

class Config extends Facade
{
    protected static function getFacadeClass()
    {
    	return 'app\lib\Config';
    }
}