<?php 
namespace app\facade;

use think\Facade;

class Img extends Facade
{
    protected static function getFacadeClass()
    {
    	return 'app\lib\Img';
    }
}