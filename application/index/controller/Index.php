<?php
namespace app\index\controller;

class Index extends \app\Controller
{
    public function index()
    {
        return view('index');
    }

    public function test(){
    	print_r($_GET);
    }

    /**
     * @param  string  $name 数据名称
     * @return mixed
     * @route('hello/:name')
     */
	public function hello($name)
    {
    	return 'hello,'.$name;
    }
}
