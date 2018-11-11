<?php 
namespace app\facade;

use think\Facade;

class PhpOffice extends Facade
{
    protected static function getFacadeClass()
    {
    	return 'app\lib\PhpOffice';
    }
}