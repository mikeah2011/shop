<?php 
namespace app\facade;

use think\Facade;

class Seo extends Facade
{
    protected static function getFacadeClass()
    {
    	return 'app\lib\Seo';
    }
}