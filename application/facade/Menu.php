<?php 
namespace app\facade;

use think\Facade;

class Menu extends Facade
{
    protected static function getFacadeClass()
    {
    	return 'app\lib\Menu';
    }
}