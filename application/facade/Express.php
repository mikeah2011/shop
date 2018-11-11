<?php 
namespace app\facade;

use think\Facade;
/**
 * app\facade\Express::config([
 * 	'name'=>'KuaidiNiao',
 * 	'bid'=>'',
 * 	'akey'=>'',
 * 	
 * ])->todo($number,$com);
 */
class Express extends Facade
{
    protected static function getFacadeClass()
    {
    	return 'app\lib\Express';
    }
}