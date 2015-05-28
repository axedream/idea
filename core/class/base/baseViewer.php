<?php
class Viewer {
	
	public function __construct() {}

	//$file		-	переданное начало файла отображения
	//$data		-	данные, массив ассоциативный хэш
	//$key		- 	если установить true возврат обратно в запрос а не в общую переменную
	//$flagdir	-	если ture тогда читается как конечный каталог
	// show("file_name","$data(array)",(если 1 получаем назад контент),(если 1 строим свой путь))
	public function show($file=false,$data=false,$key=false,$flagdir=false) {

		/*
		if ($file=="W:/domains/localhost/core/views/layouts/header"){
			echo "<pre>";
			var_dump($data['urlImgLogo']);
			}
		echo $file."<br>";
		*/
		
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
				if ($key) $out = ob_get_contents();
				else App::gi()->data['content'] = App::gi()->data['content']."\r\n".ob_get_contents();
				ob_clean();
				ob_end_flush();
				if (!$key) return true;
				else return $out;
				}
			}
		}	
}