<?php 
namespace app\facade;

use think\Facade;

class Arr extends Facade
{
    protected static function getFacadeClass()
    {
    	return 'app\lib\Arr';
    }
}