<?php
class Viewer {
	
	public function __construct() {}

	//$file		-	переданное начало файла отображения
	//$data		-	данные, массив ассоциативный хэш
	//$key		- 	если установить true возврат обратно в запрос а не в общую переменную
	//$flagdir	-	если ture тогда читается как конечный каталог
	public function show($file=false,$data=false,$key=false,$flagdir=false) {

		if (!$file) return false;
		if (!$flagdir) $file = VIEW.$file.'.php';
		else $file = $file.'.php';
		ob_start();
		if (!isset($file)) return false;
		else {
			if ($data) if(is_array($data)) if (count($data)>0) foreach ($data as $k => $v) $$k = $v;
			if( file_exists($file) == false ) return false;
			else{
				include $file;
				if (!$key) App::gi()->data['content'] = App::gi()->data['content']."\r\n".ob_get_contents();
				else $out = ob_get_contents();
				ob_clean();
				ob_end_flush();
				if (!$key) return true;
				else return $out;
				}
			}
		}	
}