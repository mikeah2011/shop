<?php
namespace app\index\controller;

class Product extends \app\Controller
{
    public function show()
    {
        print_r(\input('get.id'));
        return view('introduction');
    }
 
}
