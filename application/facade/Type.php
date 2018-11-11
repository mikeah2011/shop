<?php 
namespace app\facade;

use think\Facade;

class Type extends Facade
{
    protected static function getFacadeClass()
    {
    	return 'app\lib\Type';
    }
}