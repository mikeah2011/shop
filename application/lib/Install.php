<?php 
namespace app\lib;

class Install{

	public function __construct(){
		$this->lock = BASE_PATH.'/data/install';
		if(!is_dir($this->lock)){
			mkdir($this->lock,0777,true);
		}	
		$this->lock = $this->lock.'/rc.lock';
		if(file_exists($this->lock)){

		}
	}


	public function run(){

		 
	}



	

}