jQuery(function($){
	console.log('jQuery working!');

	jQuery('.main-navigation ul.nav-menu').supersubs({
		minWidth:	12,	 // minimum width of submenus in em units
		maxWidth:	27,	 // maximum width of submenus in em units
		extraWidth:	1
	}).superfish({
		delay:       100,                            // one second delay on mouseout
		animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation
		speed:       'fast',
	});
});