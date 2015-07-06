<?php
return array (
	'uri'	=> [											//system
		'controller' 	=>	'/^[a-zA-Z0-9+_\-]{2,20}$/',                                    //controllers
		'action' 		=>	'/^[a-zA-Z0-9+_\-]{2,20}$/',                                    //actions
		'id' 			=>	'/^[a-zA-Z0-9+_\-\:\?\=\/]{1,40}$/',                            //ids
		'short_ulr'		=>	'/^([0-9])([0-9a-zA-Z]{1,5})$/',                                 //short links
		'full_url'		=>	'/^(https?:\/\/)?([\w\.]+)\.([a-z]{2,16}\.?)(\/[\w\.]*)*\/?$/'  //full links
	]
);