<?php 
namespace app\facade;

use think\Facade;

class Pinyin extends Facade
{
    protected static function getFacadeClass()
    {
    	return 'app\lib\third\Pinyin';
    }
}