<?php
class Header extends Singleton{

	function __construct() {}


	//получает "динамическую" цитату
	public function getDinamicText () {
		$data = Model::gi()->sigdDB('select','header_dynamictext',['dtext','autor'],['id' => date("d")] ,'=','where');
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