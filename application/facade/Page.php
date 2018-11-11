<?php 
namespace app\facade;

use think\Facade;

class Page extends Facade
{
    protected static function getFacadeClass()
    {
    	return 'app\lib\Page';
    }
}