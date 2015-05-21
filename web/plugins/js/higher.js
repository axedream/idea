//центровка с компенсацией правого скролинга
 $(function(){ wh( "#conteiner" ); }); 
 function wh( div ){ 
	$scroll = +document.body.scrollWidth-window.innerWidth;
	
	
	$heightScreen	=	window.innerHeight;
	$heightBlock	=	$(div).outerHeight();
	$delta = $heightScreen - $heightBlock;
	$pr = 98;
	if ($delta>0) $('#conteiner').css('height', ($heightScreen/100)*$pr);
	else $('#footer').css('position','relative');
	}