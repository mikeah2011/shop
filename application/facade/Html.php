<?php 
namespace app\facade;

use think\Facade;

class Html extends Facade
{
    protected static function getFacadeClass()
    {
    	return 'app\lib\Html';
    }
}