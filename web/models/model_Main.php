<?php
class model_Main extends Model {
	function __construct (){
		parent::__construct();
	}
	
	public function getTestData($data=""){
		return ['test1' => 'КЛАС КОНТРОЛЛЕРА: '.$data, 'test2' => "КЛСАС МОДЕЛИ: ".__CLASS__];
	}	
}