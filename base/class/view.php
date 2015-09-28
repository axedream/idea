<?php
//общий класса для формирования отображени
class View extends Singleton {

    public $view;           //массив общего отображения
    public $out;            //полное построение html кода

    //отобразить страницу
    public function uView($file) {
        //проверяем на существование файл
        $file = mb_strtolower($file);
	    $file = UVIEW .$file.'.php';
        if( file_exists($file) == false ) return false;
	    require_once ($file);
        }//end uView


    //поспроение заголовка шаблонной страницы
    public function setHeader () {
        $this->view['header']['charset']        = '<meta http-equiv="content-type" content="text/html; charset=utf-8" />';
        $this->view['header']['description']    = '<meta name="description" content="'.Core::gi()->config['head']['description']['text'].'"/>';
        $this->view['header']['keywords']       = '<meta name="keywords" content="'.Core::gi()->config['head']['keywords']['text'].'"/>';
        $this->view['header']['ico']            = '<link type="image/gif" rel="shortcut icon" href="favicon.gif" />';
        $this->view['header']['title']          = '<title>'.Core::gi()->config['head']['title']['text'].'</title>';

        //css - внешние модули
        foreach (Core::gi()->config['head']['ext']['css'] as $cssExtName => $ext) {
            //если внутри несколько css то
            if (is_array($ext['directory'])) {
                for ($i=0;$i<count($ext['directory']);$i++)
                    $this->view['header']['css'] .= '<link rel="stylesheet" type="text/css" href='.URL.MEXT.$ext['directory'][$i].'>';
                    }
            //если один css то
            else {
                $this->view['header']['css'] .= '<link rel="stylesheet" type="text/css" href='.URL.MEXT.$ext['directory'].'>';
                }
            }//end nameCSS


        //js - внешние модули
        foreach (Core::gi()->config['head']['ext']['js'] as $jsExtName => $ext) {
            //если внутри несколько css то
            if (is_array($ext['directory'])) {
                for ($i=0;$i<count($ext['directory']);$i++)
                    $this->view['header']['js'] .= '<script type="text/javascript" src="'.URL.MEXT.$ext['directory'][$i].'"></script>';
                }
            //если один css то
            else {
                $this->view['header']['js'] .= '<script type="text/javascript" src="'.URL.MEXT.$ext['directory'].'"></script>';
                }
            }//end nameCSS

        //css - локальные модули
        if (isset(Core::gi()->config['head']['local']['css'])) {
            for ($i=0;$i<count(Core::gi()->config['head']['local']['css']);$i++) {
                $this->view['header']['css'] .= '<link rel="stylesheet" type="text/css" href='.URL.UVIEW.'css/'.Core::gi()->config['head']['local']['css'][$i].'>';
                }
            }//end CSS

        //js - локальные модули
        if (isset(Core::gi()->config['head']['local']['js'])) {
            for ($i=0;$i<count(Core::gi()->config['head']['local']['js']);$i++) {
                $this->view['header']['js'] .= '<script type="text/javascript" src="'.URL.UVIEW.'js/'.Core::gi()->config['head']['local']['js'][$i].'"></script>';
                }
            }//end JS

        //font - локальные модули
        if (isset(Core::gi()->config['head']['local']['font'])) {
            $this->view['header']['font'] .= '<style>';
            for ($i=0;$i<count(Core::gi()->config['head']['local']['font']);$i++) {
                $this->view['header']['font'] .= '@font-face {';
                $this->view['header']['font'] .= 'font-family: sh'.$i.';';
                $this->view['header']['font'] .=  'src: url('.URL.UVIEW.'font/'.Core::gi()->config['head']['local']['font'][$i].');';
                $this->view['header']['font'] .= '}';
                }
            $this->view['header']['font'] .= '</style>';
            }//end JS
        }//end setHeader


    //общее отображение данных
	//$file		-	переданное начало файла отображения
	//$data		-	данные, массив ассоциативный хэш
	//$key		- 	если установить TRUE возврат обратно в запрос а не в общую переменную
	//show("file_name","$data(array)",(если 1 получаем назад переменную))
	public function show($file=FALSE,$data=FALSE,$key=FALSE) {

        //если файл не задан, возвращаем FALSE
		if (!$file) return FALSE;

        //если директория заданная то берем заданную директорию
		else $file = UVIEW.$file.'.php';

        //буферизируем вывод
		ob_start();

		if (!isset($file)) return FALSE;
		else {
			if ($data) if(is_array($data)) if (count($data)>0) foreach ($data as $k => $v) $$k = $v;
			if( file_exists($file) == FALSE ) return FALSE;
			else{
				include $file;
				if ($key) $out = ob_get_contents();
				else $this->view['content'] = $this->view['content']."\r\n".ob_get_contents();
				ob_clean();
				ob_end_flush();
				if (!$key) return TRUE;
				else return $out;
				}
			}//end issetFILE
		return FALSE;
		}//end SHOW



}//end class view