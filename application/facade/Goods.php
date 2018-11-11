<?php 
namespace app\facade;

use think\Facade;

class Goods extends Facade
{
    protected static function getFacadeClass()
    {
    	return 'app\lib\Goods';
    }
}