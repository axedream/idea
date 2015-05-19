//центровка с компенсацией правого скролинга
 $(function(){ centrir( "#conteiner" ); }); 
 function centrir( div ){ 
	$( div ).css({"position":"static","float":"left"});
	$w1 = +document.body.scrollWidth;
	$w2 = +window.innerWidth;
	$delta = $w1-$w2;
	if ( $delta <= 0 ) {
		// появился скролл
		var w = Math.ceil( ((  ($(window).width()-$delta) / 2 ) - ( $(div).outerWidth() / 2 )) )   ;
		}	
	else {
		var w = Math.ceil( ( $(window).width() / 2 ) - ( $(div).outerWidth() / 2 ) ) ; 
		}
	
	$( div ).css({ "position":"absolute", "left": w + "px"}); 
	}