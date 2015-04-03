<?php

/*
Plugin Name: Fluid Notification Bar
Plugin URI: http://techsini.com/our-wordpress-plugins/fluid-notification-bar/
Description: Wanna say something to your website visitor? This plugin adds the cool responsive notification bar on the top of your website homepage.
Author: Shrinivas Naik
Version: 3.0
Author URI: http://techsini.com
*/

/*
Copyright (C) 2015 Shrinivas Naik

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see http://www.gnu.org/licenses/.

*/

if(!class_exists('fluid_notification_bar') && !class_exists('Fn_notibar_options')){

    class fluid_notification_bar{

        private $options;

        public function __construct(){

            //Activate the plugin for first time
            register_activation_hook(__FILE__, array($this, "activate"));

            //Load scipts and styles
            add_action('wp_enqueue_scripts', array($this, 'register_scripts'));
            add_action('wp_enqueue_scripts', array($this, 'register_styles'));
            
            //Initialize settings page
            require_once(plugin_dir_path(__FILE__) . "fnbar_options.php");
            $fn_notibar_options = new fn_notibar_options;
            
            //Run the plugin in footer
            add_action('wp_head', array($this, 'run_plugin'));

            //Store options in a variable
            $this->options = get_option( 'fluid_notification_bar_settings' );

            //Set cookie as required
            add_action( 'init', array($this,'set_fluid_notificationbar_cookie'));

        }

        public function activate(){

            //Set default options for the plugin
            $initial_settings = array(
                'fnbar_enabled'     => '1',
                'fnbar_bgcolor'     => '#5accf5',
                'fnbar_textcolor'   => '#fff',
                'fnbar_fontsize'    => '12',                
                'fnbar_animation'   => 'fadeInLeft',
                'fnbar_interval'    =>  '5'
                );
            add_option("fluid_notification_bar_settings", $initial_settings);
        }

        public function deactivate(){
                
        }
            
        public function register_scripts(){

             wp_enqueue_script('jquery');
             wp_enqueue_script('fnbar_js', plugins_url( 'js/fnbar_js.js' , __FILE__ ),array( 'jquery' ));
             wp_enqueue_script('jquery_lettering', plugins_url( 'js/jquery.lettering.js' , __FILE__ ),array( 'jquery' ));
             wp_enqueue_script('jquery_textillate', plugins_url( 'js/jquery.textillate.js' , __FILE__ ),array( 'jquery' ));
        }

        public function register_styles(){

             wp_enqueue_style( 'Fluid_notification_bar_css', plugins_url('css/fnbar_css.css', __FILE__));
             wp_enqueue_style( 'animate_css', plugins_url('css/animate.css', __FILE__));
        }

        public function run_plugin(){

            //Get notification bar settings
            if(isset($this->options["fnbar_enabled"])){
                $fn_notibar_enabled = $this->options["fnbar_enabled"];
            } else {
                $fn_notibar_enabled = 0;
            }

            $fn_notibar_text = $this->options["fnbar_text"];
            $fn_notibar_link_title = $this->options["fnbar_link_text"];
            $fn_notibar_link = $this->options["fnbar_link"];
            $fn_notibar_font_size = $this->options["fnbar_fontsize"];
            $fn_notibar_text_color = $this->options["fnbar_textcolor"];
            $fn_notibar_bg_color = $this->options["fnbar_bgcolor"];
            $fn_notibar_animation = $this->options["fnbar_animation"];


            if($fn_notibar_enabled == 1 && $this->can_show_notibar() == TRUE){

                if($fn_notibar_text == ""){
                    
                    $fn_notibar_text = 'Welcome to Fluid Notification Bar.. Go to Settings -> Fluid Notification Bar to add your notification.';
                }
                ?>

                <script type="text/javascript">
                jQuery(document).ready(function(){
                    //Show notification after 5 second

                    var notibar_delay = 1500;
                    
                    
                    function shownotibar() {
                        /*jQuery("#fluid_notification_bar_wrapper").show();*/
                        jQuery("#fluid_notification_bar_wrapper").css({"display":"block"});
                        jQuery("#fluid_notification_bar_wrapper").animate({"top": "0px"},1000, function(){
                            jQuery("#fluid_notification_bar").css({"display":"block"});
                            jQuery('.fnbar_notification').textillate({ 
                                in: { 
                                    effect: '<?php echo $fn_notibar_animation ?>',
                                    delayScale: 3.5,
                                    delay: 20,
                                    callback: function () {
                                        jQuery('.fnbar_link').animate(
                                            {
                                                "opacity": 1
                                            },0, function(){
                                                jQuery(this).addClass("bounceIn");
                                            });
                                    }
                                }

                              
                          });
                        });
                    }
                    // use setTimeout() to execute
                    setTimeout(shownotibar, notibar_delay)

                    
                });
                </script>

                <style type="text/css">

                    #fluid_notification_bar_wrapper{
                        background: <?php echo $fn_notibar_bg_color ?>;
                    }

                    #fluid_notification_bar{
                        font-size: <?php echo $fn_notibar_font_size?>px;
                        color: <?php echo $fn_notibar_text_color ?>;
                    }

                </style>

                <div id="fluid_notification_bar_wrapper">
                    <div id="fluid_notification_bar"><span class="fnbar_notification"><?php echo $fn_notibar_text; ?></span>
                    <?php if(!empty($fn_notibar_link_title) && !empty($fn_notibar_link)) { ?>
                        <span class="fnbar_link animated"><a href="<?php echo $fn_notibar_link; ?>"><?php echo $fn_notibar_link_title; ?></a></span>
                    <?php } ?>
                    </div>
                    <div id="hide_fluid_notification_bar">X</div>
                </div>

            <?php

            } //if notification is enabled

        }


        public function can_show_notibar(){


            if(!isset($_COOKIE['fluid_notificationbar_cookie'])){

                //show the popup
                return true;  

            } else {
                //Do not show the popup
                return false;
            }
        }

        public function set_fluid_notificationbar_cookie(){

            if(!isset($_COOKIE['fluid_notificationbar_cookie']) && ! is_admin()){
                $fn_notibar_interval = $this->options["fnbar_interval"];
                setcookie("fluid_notificationbar_cookie", "shown", time()+ (60 * $fn_notibar_interval) , COOKIEPATH, COOKIE_DOMAIN, false);
            }
        }


    }

}

$fluid_notification_bar = new fluid_notification_bar;


?>