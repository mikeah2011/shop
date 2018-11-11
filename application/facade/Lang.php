<?php 
namespace app\facade;

use think\Facade;

class Lang extends Facade
{
    protected static function getFacadeClass()
    {
    	return 'app\lib\Lang';
    }
}