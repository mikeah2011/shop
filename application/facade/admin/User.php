<?php 
namespace app\facade\admin;

use think\Facade;

class User extends Facade
{
    protected static function getFacadeClass()
    {
    	return 'app\lib\admin\User';
    }
}