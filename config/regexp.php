<?php
namespace idea;
//--регулярные выражения--//

return array(
    'core'      => [
        'controller' 	=>	'/^[a-zA-Z0-9+_\-]{2,20}$/',
        'action' 		  =>	'/^[a-zA-Z0-9+_\-]{2,20}$/',
		'id' 			    =>	'/^[a-zA-Z0-9+_\-\:\?\=\/]{1,40}$/',
        ],
    
);