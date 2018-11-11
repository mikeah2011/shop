<?php 
namespace app\facade;

use think\Facade;

class Order extends Facade
{
    protected static function getFacadeClass()
    {
    	return 'app\lib\Order';
    }
}