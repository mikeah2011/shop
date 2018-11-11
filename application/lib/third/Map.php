<?php 

namespace app\lib\third;
class Map{
	//百度KEY  http://lbsyun.baidu.com/apiconsole/key
	public $bkey = 'FjZckd4VhczWUrevzlCWNwKZa6uSwsnw';

	public function b($ip){
		$url = "https://api.map.baidu.com/location/ip?ip=".$ip."&ak=".$this->bkey."&coor=bd09ll"
	}


	public function bjw(){
		$url = "http://api.map.baidu.com/geoconv/v1/?coords=".$j.",".$w."&from=1&to=5&ak=".$this->bkey;
	}
}