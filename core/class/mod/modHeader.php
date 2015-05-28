<?php
class Header extends Singleton{

	function __construct() {}


	//получает "динамическую" цитату
	public function getDinamicText () {
		Model::gi()->key 			=	'select';
		Model::gi()->table			=	'header_dynamictext';
		Model::gi()->mass			=	['dtext','autor'];
		Model::gi()->area			=	['id' => date("d")];
		Model::gi()->flag			=	'=';
		Model::gi()->select			=	'where';
		$data = Model::gi()->sigdDB();

		if (!$data['error']['connect']['code'] && !$data['error']['selectquery']['code'] && !$data['error']['getdata']['code']) {
			App::gi()->modules['HeaderTextString']  = $data['data'][0]['dtext'];
			App::gi()->modules['HeaderTextAutor'] = $data['data'][0]['autor'];
			}
		else{
			App::gi()->modules['HeaderTextString']  = 'DB NOT CONNECT';
			App::gi()->modules['HeaderTextAutor'] = '';
			}
		}
	
	//устанавливает меняет свойства заголовка
	public function run() {
		//логотип
		App::gi()->modules['urlImgLogo'] = COREIMG.'img/logo.jpg'; 
		App::gi()->modules['classImgLogo'] = 'imglogo';
		//Цитата
		$this->getDinamicText ();

		}
}