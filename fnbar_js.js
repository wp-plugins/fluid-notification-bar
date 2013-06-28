jQuery(document).ready(function(){
    <!--As our notification bar is responsive, it should be margined properly in any resolution-->
    
    $toolbarheight=jQuery("#toolbar").height();
    jQuery("#toolbar").css({"margin-top":-$toolbarheight-10});
    jQuery("#hidetoolbar").css({"visibility":"hidden"});
    
    <!--Show notification after 1 second-->
    jQuery("#toolbar").delay(5000).show(0);
	jQuery("#toolbar").css({"visibility":"visible"});
    jQuery("#hidetoolbar").css({"visibility":"visible"});
    jQuery("#toolbar").animate({"margin-top": "0px"},1000);
    
    
    <!--close button-->
    jQuery("#hidetoolbar").bind("click", function(){
    $mytoolbarheight=jQuery("#toolbar").height();
    jQuery("#toolbar").animate({"margin-top": -$mytoolbarheight-10},1000);
    jQuery("#toolbar").hide(0);
    });
});