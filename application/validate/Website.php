<?php 

namespace app\validate;

class Website{

	public function rules(){
		$vali[0] = [
				'domain'  => 'require|max:25',
  				'starttime' => 'require',
  				'endtime' => 'require',
		];
		$vali[1] = [
				//'domain.require'  =>  "tset"
		];
		return $vali;
	}


}