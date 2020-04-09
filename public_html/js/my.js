




/*
     FILE ARCHIVED ON 7:20:02 Feb 20, 2016 AND RETRIEVED FROM THE
     INTERNET ARCHIVE ON 10:51:33 Apr 13, 2016.
     JAVASCRIPT APPENDED BY WAYBACK MACHINE, COPYRIGHT INTERNET ARCHIVE.

     ALL OTHER CONTENT MAY ALSO BE PROTECTED BY COPYRIGHT (17 U.S.C.
     SECTION 108(a)(3)).
*/
$(document).ready(function(){

	 $(this).bind("contextmenu", function(e) {
                e.preventDefault();
     });
    
     
            
	$('#slides').slides({
		preload: true,
		preloadImage: 'images/loading.gif',
		play: 5000,
		pause: 2500,
		hoverPause: true,
		effect: 'fade',
		crossfade: true

	}); 
	
	$('#slides2').slides({
		preloadImage: 'images/loading.gif',
		play: 5000,
		pause: 2500,
		effect: 'fade',
		crossfade: true,
		paginationClass: 'pagination2'	
	}); 
	
	
});		