<?php
class Controller extends Singleton {

	public function __construct () {
		
	}

	//отображение (последовательно формирует переменную $data['content'])
	public function view ($file,$data="null") {
		$file = VIEW.$file.'.php';
		ob_start();
		if( file_exists($file) == false ) return false;
		else{
			include $file;
			App::gi()->data['content'] = App::gi()->data['content']."\r\n".ob_get_contents();
			ob_clean();
			ob_end_flush();
			return true;
			}
		}
}