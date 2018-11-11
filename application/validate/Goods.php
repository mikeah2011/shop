<?php 

namespace app\validate;

class Goods{

	public function rules(){
		$vali[0] = [
				'title'  => 'require',
				'content'  => 'require',
				'price'  => 'require|min:1',
  				 
		];
		$vali[1] = [
				//'domain.require'  =>  "tset"
		];
		return $vali;
	}


}