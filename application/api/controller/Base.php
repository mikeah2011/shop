<?php
namespace app\api\controller;
/**
 * 
 */
class Base extends \app\Controller
{
    public function init()
    {
         parent::init();
         header('Access-Control-Allow-Origin:*');
    }

     
}
