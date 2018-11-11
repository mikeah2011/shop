<?php 
namespace app\facade;

use think\Facade;

class Plugin extends Facade
{
    protected static function getFacadeClass()
    {
    	return 'app\lib\Plugin';
    }
}