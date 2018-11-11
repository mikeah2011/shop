<?php 

namespace app\validate;

class Menu{

	public function rules(){
		$vali[0] = [
				'name'  => 'require',
  				'url' => 'require', 
		];
		$vali[1] = [
				//'domain.require'  =>  "tset"
		];
		return $vali;
	}


}