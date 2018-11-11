<?php 
namespace app\facade;

use think\Facade;

class Form extends Facade
{
    protected static function getFacadeClass()
    {
    	return 'app\lib\Form';
    }
}