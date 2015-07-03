<?php
return array (
	'layouts'	=>								//класс
			[
				'link'		=>	'layouts/main',	//сслыка на файл отображения
				'class'		=>	false,			//загружат одноименный класс
				'file'		=>	true			//признак загрузки данного модуля как основного
			],
	'header'	=>
			[
				'link'		=>	'layouts/header',
				'class'		=>	true
			],
	'footer'	=>
			[	
				'link'		=>	'layouts/footer',
				'class'		=>	false
			]
);