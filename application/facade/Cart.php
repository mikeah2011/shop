<?php 
namespace app\facade;

use think\Facade;

class Cart extends Facade
{
    protected static function getFacadeClass()
    {
    	return 'app\lib\Cart';
    }
}