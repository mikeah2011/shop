<?php 
namespace app\facade;

use think\Facade;

class Notice extends Facade
{
    protected static function getFacadeClass()
    {
    	return 'app\lib\Notice';
    }
}