<?php 
namespace app\facade;

use think\Facade;

class Website extends Facade
{
    protected static function getFacadeClass()
    {
    	return 'app\lib\Website';
    }
}