<?php 
namespace app\facade;

use think\Facade;

class Module extends Facade
{
    protected static function getFacadeClass()
    {
    	return 'app\lib\Module';
    }
}