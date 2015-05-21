jQuery(document).ready(function(){
    //As our notification bar is responsive, it should be margined properly in any resolution
    
    var toolbarheight=jQuery("#fluid_notification_bar_wrapper").height();
	jQuery("#fluid_notification_bar").css({"display":"none"});
    jQuery("#fluid_notification_bar_wrapper").css({"margin-top":-toolbarheight});
    console.log(toolbarheight);
    
    //close button
    jQuery("#hide_fluid_notification_bar").bind("click", function(){
        var mytoolbarheight=jQuery("#fluid_notification_bar_wrapper").height();
        jQuery("#fluid_notification_bar_wrapper").animate({"margin-top": -mytoolbarheight},600);
        jQuery("#fluid_notification_bar_wrapper").hide(0);
    });
	
	
	
});