<?php 
namespace app\facade;

use think\Facade;

class Payment extends Facade
{
    protected static function getFacadeClass()
    {
    	return 'app\lib\Payment';
    }
}