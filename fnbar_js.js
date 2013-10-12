jQuery(document).ready(function(){
    //As our notification bar is responsive, it should be margined properly in any resolution
    
    $toolbarheight=jQuery("#mb_fluid_notibar_holder").height();
	jQuery("#mb_fluid_notibar").css({"display":"none"});
    jQuery("#mb_fluid_notibar_holder").css({"margin-top":-$toolbarheight});
    
    //Show notification after 5 second
    jQuery("#mb_fluid_notibar_holder").delay(5000).show(0);
	function shownotibar() {  
		jQuery("#mb_fluid_notibar").css({"display":"block"});
		jQuery("#mb_fluid_notibar_holder").css({"display":"block"});
   		jQuery("#mb_fluid_notibar_holder").animate({"margin-top": "0px"},1000);
	}
	 // use setTimeout() to execute
	 setTimeout(shownotibar, 5000)
	
    //close button
    jQuery("#hide_mb_fluid_notibar").bind("click", function(){
    $mytoolbarheight=jQuery("#mb_fluid_notibar_holder").height();
    jQuery("#mb_fluid_notibar_holder").animate({"margin-top": -$mytoolbarheight},1000);
    jQuery("#mb_fluid_notibar_holder").hide(0);
    });
	
	
	
});