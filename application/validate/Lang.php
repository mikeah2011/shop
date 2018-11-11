<?php 

namespace app\validate;

class Lang{

	public function rules(){
		$vali[0] = [
				'key'  => 'require',
  				'val' => 'require', 
		];
		$vali[1] = [
				//'domain.require'  =>  "tset"
		];
		return $vali;
	}


}