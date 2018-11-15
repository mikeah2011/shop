<?php 


return [
	'name'=>'商品多规格',
	'memo'=>'支持商品发布时出现多种规格',
	'hooks'=>[
		[
			'url'=>'admin/goods/form',
			'action'=>['Hook','form'],
		]
	],  
	
];