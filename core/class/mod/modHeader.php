<?php
class Header extends Singleton{

	function __construct() {}


	//получает "динамическую" цитату
	public function getDinamicText () {
		Model::gi()->key 			=	'select';
		Model::gi()->table		=	'IDEa_Quote';
		Model::gi()->mass			=	['quoteText','quoteAutor'];
		Model::gi()->area			=	['id' => date("d")];
		Model::gi()->flag			=	'=';
		Model::gi()->select		=	'where';
		$data = Model::gi()->sigdDB();

		if (!$data['error']['connect']['code'] && !$data['error']['selectquery']['code'] && !$data['error']['getdata']['code']) {
			App::gi()->modules['HeaderTextString']  = $data['data'][0]['quoteText'];
			App::gi()->modules['HeaderTextAutor']   = $data['data'][0]['quoteAutor'];
			}
		else{
			App::gi()->modules['HeaderTextString']  = 'DB NOT CONNECT';
			App::gi()->modules['HeaderTextAutor']   = '';
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