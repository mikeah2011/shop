<?php 

namespace app\validate;

class Type{

	public function rules(){
		$vali[0] = [
				'name'  => 'require',
  				 
		];
		$vali[1] = [
				//'domain.require'  =>  "tset"
		];
		return $vali;
	}


}