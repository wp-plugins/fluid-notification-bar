<?php 
class fn_notibar_options {

    //Holds the values to be used in the fields callbacks
    private $options;

    public function __construct(){

        add_action("admin_menu", array($this,"add_plugin_menu_fnbar"));
        add_action("admin_init", array($this,"page_init_fnbar"));

        add_action('admin_enqueue_scripts', array($this, 'register_admin_scripts'));
        //add_action('admin_enqueue_styles', array($this, 'register_admin_styles'));
    }

    public function add_plugin_menu_fnbar (){
        
        add_options_page( "Fluid Notification Bar", //page_title 
                         "Fluid Notification Bar", //menu_title
                         "administrator", //capability
                         "fluid-notification-bar-settings", //menu_slug
                         array($this, "create_admin_page_fnbar")); //callback function
        
    }

    public function register_admin_scripts(){
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'Fnbar_admin', plugins_url('js/fnbar_admin.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
    }

    public function create_admin_page_fnbar (){

        $this->options = get_option ( 'fluid_notification_bar_settings' );
        
        ?>
            <div class="wrap">
                
                <div id="poststuff">
                    <div id="post-body" class="metabox-holder columns-2">
                        
                        
                        <div id="post-body-content">
                            <div class="meta-box-sortables ui-sortable">
                                <div class="postbox">
                                    <h3><span class="dashicons dashicons-admin-generic"></span>Fluid Notification Bar Settings</h3>
                                    <div class="inside">
                                        <form method="post" action="options.php">
                                            <?php 
                                            // This prints out all hidden setting fields 
                                            settings_fields( 'fluid_notification_bar_settings_group' ); //option group
                                            do_settings_sections( 'fluid-notification-bar-settings' ); //settings page slug
                                            submit_button(); ?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div> <!--post-body-content-->
                        
                        
                        <!-- sidebar -->
                        <div id="postbox-container-1" class="postbox-container">
                            <div class="meta-box-sortables">
                                <div class="postbox">
                                    <h3><span>About</span></h3>
                                    <div class="inside">
                                        Author: Shrinivas Naik <br>
                                        Plugin Homepage: <a href="http://www.techsini.com" target="_blank">Techsini.com</a> <br>
                                        Thank you for installing this plugin.
                                    </div> <!-- .inside -->
                                </div> <!-- .postbox -->
                            </div> <!-- .meta-box-sortables -->
                        </div> <!-- #postbox-container-1 .postbox-container -->
                        
                        
                    </div>
                </div>
            </div>
        <?php

    }

    public function page_init_fnbar(){

        register_setting(
        'fluid_notification_bar_settings_group', // Option group
        'fluid_notification_bar_settings' // Option name
        );
        
        add_settings_section(
            'section1', // ID
            '', // Title
            array( $this, 'section_1_callback' ), // Callback
            'fluid-notification-bar-settings' // Page
        );

        add_settings_field(
            'fnbar_enabled', // ID
            'Show Notification Bar', // Title 
            array( $this, 'fnbar_enabled_callback' ), // Callback
            'fluid-notification-bar-settings', // Page
            'section1' // Section           
        );

        add_settings_field(
            'fnbar_text', // ID
            'Notification Bar Text', // Title 
            array( $this, 'fnbar_text_callback' ), // Callback
            'fluid-notification-bar-settings', // Page
            'section1' // Section           
        );

        add_settings_field(
            'fnbar_link_text', // ID
            'Notification Bar Link Title (Button Caption)', // Title 
            array( $this, 'fnbar_link_text_callback' ), // Callback
            'fluid-notification-bar-settings', // Page
            'section1' // Section           
        );

        add_settings_field(
            'fnbar_link', // ID
            'Notification Bar Link (Button URL)', // Title 
            array( $this, 'fnbar_link_callback' ), // Callback
            'fluid-notification-bar-settings', // Page
            'section1' // Section           
        );

        add_settings_field(
            'fnbar_fontsize', // ID
            'Font Size', // Title 
            array( $this, 'fnbar_fontsize_callback' ), // Callback
            'fluid-notification-bar-settings', // Page
            'section1' // Section           
        );

        add_settings_field(
            'fnbar_textcolor', // ID
            'Text Color', // Title 
            array( $this, 'fnbar_textcolor_callback' ), // Callback
            'fluid-notification-bar-settings', // Page
            'section1' // Section           
        );

        add_settings_field(
            'fnbar_bgcolor', // ID
            'Background Color', // Title 
            array( $this, 'fnbar_bgcolor_callback' ), // Callback
            'fluid-notification-bar-settings', // Page
            'section1' // Section           
        );

        /*add_settings_field(
            'fnbar_showonpagepost', // ID
            'Show on Pages', // Title 
            array( $this, 'fnbar_showonpagepost_callback' ), // Callback
            'fluid-notification-bar-settings', // Page
            'section1' // Section           
        );*/

        add_settings_field(
            'fnbar_animation', // ID
            'Text Animation', // Title 
            array( $this, 'fnbar_animation_callback' ), // Callback
            'fluid-notification-bar-settings', // Page
            'section1' // Section           
        );

        add_settings_field(
            'fnbar_interval', // ID
            'Do not Disturb for (interval)', // Title 
            array( $this, 'fnbar_interval_callback' ), // Callback
            'fluid-notification-bar-settings', // Page
            'section1' // Section           
        );

    }

    public function section_1_callback(){
        
    }

    

    public function fnbar_enabled_callback(){
        if(isset($this->options['fnbar_enabled'])){
            $fnbarenabled = $this->options['fnbar_enabled'];
        } else {
            $fnbarenabled = 0;
        }

        printf ('<label for="fnbar_enabled">
                <input type = "checkbox"
                    id = "fnbar_enabled"
                    name= "fluid_notification_bar_settings[fnbar_enabled]"
                    value = "1"' . checked(1, $fnbarenabled, false) . '/>'.
                ' Yes</label>');

    }

    public function fnbar_text_callback(){
        printf('<input type="text" class="large-text" id="fnbar_text" name="fluid_notification_bar_settings[fnbar_text]" value="%s" />',  isset( $this->options['fnbar_text'] ) ? esc_attr( $this->options['fnbar_text']) : '');
    }

    public function fnbar_link_text_callback(){
        printf('<input type="text" id="fnbar_link_text" name="fluid_notification_bar_settings[fnbar_link_text]" value="%s" />',  isset( $this->options['fnbar_link_text'] ) ? esc_attr( $this->options['fnbar_link_text']) : '');
    }

    public function fnbar_link_callback(){
        printf('<input type="text" id="fnbar_link" name="fluid_notification_bar_settings[fnbar_link]" value="%s" /> example:www.example.com',  isset( $this->options['fnbar_link'] ) ? esc_attr( $this->options['fnbar_link']) : '');
    }

    public function fnbar_fontsize_callback(){
        printf('<input type="text" class="small-text" id="fnbar_fontsize" name="fluid_notification_bar_settings[fnbar_fontsize]" value="%s" /> px',  isset( $this->options['fnbar_fontsize'] ) ? esc_attr( $this->options['fnbar_fontsize']) : '');
    }

    public function fnbar_textcolor_callback(){
        printf('<input id="fnbar_textcolor" name="fluid_notification_bar_settings[fnbar_textcolor]" type="text" value="%s" />',  isset( $this->options['fnbar_textcolor'] ) ? esc_attr( $this->options['fnbar_textcolor']) : '');
    }

    public function fnbar_bgcolor_callback(){
        printf('<input id="fnbar_bgcolor" name="fluid_notification_bar_settings[fnbar_bgcolor]" type="text" value="%s" />',  isset( $this->options['fnbar_bgcolor'] ) ? esc_attr( $this->options['fnbar_bgcolor']) : '');
    }

    /*public function fnbar_showonpagepost_callback(){
        if(isset($this->options['fnbar_showonpages'])){
            $showonpages = $this->options['fnbar_showonpages'];
        } else {
            $showonpages = 0;
        }

        if(isset($this->options['fnbar_showonposts'])){
            $showonposts = $this->options['fnbar_showonposts'];
        } else {
            $showonposts = 0;
        }

        printf ('<fieldset>
                <label for="fnbar_showonpages">
                <input type = "checkbox"
                    id = "fnbar_showonpages"
                    name= "fluid_notification_bar_settings[fnbar_showonpages]"
                    value = "1"' . checked(1, $showonpages, false) . '/>'.
                'Pages</label> ' .
                '<label for="fnbar_showonposts">
                <input type = "checkbox"
                    id = "fnbar_showonposts"
                    name= "fluid_notification_bar_settings[fnbar_showonposts]"
                    value = "1"' . checked(1, $showonposts, false) . '/>'.
                'Posts</label>'.
                '</fieldset>');
    }*/

    public function fnbar_animation_callback(){

        if(isset($this->options['fnbar_animation'])){
            $textanimation = $this->options['fnbar_animation'];
        } else {
            $textanimation = "flash";
        }
        echo ('<select id="fnbar_animation" name="fluid_notification_bar_settings[fnbar_animation]">
                    <option value="flash" ' . selected($textanimation, "flash", false) .' >flash</option>
                    <option value="bounce" ' . selected($textanimation, "bounce", false) .'>bounce</option>
                    <option value="shake" ' . selected($textanimation, "shake", false) .'>shake</option>
                    <option value="tada" ' . selected($textanimation, "tada", false) .'>tada</option>
                    <option value="swing" ' . selected($textanimation, "swing", false) .'>swing</option>
                    <option value="wobble" ' . selected($textanimation, "wobble", false) .'>wobble</option>
                    <option value="pulse" ' . selected($textanimation, "pulse", false) .'>pulse</option>
                    <option value="flip" ' . selected($textanimation, "flip", false) .'>flip</option>
                    <option value="flipInX" ' . selected($textanimation, "flipInX", false) .'>flipInX</option>
                    <option value="flipInY" ' . selected($textanimation, "flipInY", false) .'>flipInY</option>
                    <option value="fadeIn" ' . selected($textanimation, "fadeIn", false) .'>fadeIn</option>
                    <option value="fadeInUp" ' . selected($textanimation, "fadeInUp", false) .'>fadeInUp</option>
                    <option value="fadeInDown" ' . selected($textanimation, "fadeInDown", false) .'>fadeInDown</option>
                    <option value="fadeInLeft" ' . selected($textanimation, "fadeInLeft", false) .'>fadeInLeft</option>
                    <option value="fadeInRight" ' . selected($textanimation, "fadeInRight", false) .'>fadeInRight</option>
                    <option value="fadeInUpBig" ' . selected($textanimation, "fadeInUpBig", false) .'>fadeInUpBig</option>
                    <option value="fadeInDownBig" ' . selected($textanimation, "fadeInDownBig", false) .'>fadeInDownBig</option>
                    <option value="fadeInLeftBig" ' . selected($textanimation, "fadeInLeftBig", false) .'>fadeInLeftBig</option>
                    <option value="fadeInRightBig" ' . selected($textanimation, "fadeInRightBig", false) .'>fadeInRightBig</option>
                    <option value="bounceIn" ' . selected($textanimation, "bounceIn", false) .'>bounceIn</option>
                    <option value="bounceInDown" ' . selected($textanimation, "bounceInDown", false) .'>bounceInDown</option>
                    <option value="bounceInUp" ' . selected($textanimation, "bounceInUp", false) .'>bounceInUp</option>
                    <option value="bounceInLeft" ' . selected($textanimation, "bounceInLeft", false) .'>bounceInLeft</option>
                    <option value="bounceInRight" ' . selected($textanimation, "bounceInRight", false) .'>bounceInRight</option>
                    <option value="rotateIn" ' . selected($textanimation, "rotateIn", false) .'>rotateIn</option>
                    <option value="rotateInDownLeft" ' . selected($textanimation, "rotateInDownLeft", false) .'>rotateInDownLeft</option>
                    <option value="rotateInDownRight" ' . selected($textanimation, "rotateInDownRight", false) .'>rotateInDownRight</option>
                    <option value="rotateInUpLeft" ' . selected($textanimation, "rotateInUpLeft", false) .'>rotateInUpLeft</option>
                    <option value="rotateInUpRight" ' . selected($textanimation, "rotateInUpRight", false) .'>rotateInUpRight</option>
                    <option value="rollIn" ' . selected($textanimation, "rollIn", false) .'>rollIn</option>
                </select>'
            );
    }

    public function fnbar_interval_callback(){

        if(isset($this->options['fnbar_interval'])){
            $fnbarinterval = $this->options['fnbar_interval'];
        } else {
            $fnbarinterval = "5";
        }

        echo ('<select id="fnbar_interval" name="fluid_notification_bar_settings[fnbar_interval]">' .
                '<option value="5" ' . selected($fnbarinterval, "5", false) . '>5</option>' . 
                '<option value="10" ' . selected($fnbarinterval, "10", false) . '>10</option>' . 
                '<option value="20" ' . selected($fnbarinterval, "20", false) . '>30</option>' .
                '<option value="40" ' . selected($fnbarinterval, "40", false) . '>30</option>' .
                '<option value="60" ' . selected($fnbarinterval, "60", false) . '>30</option>' .
                '</select> Minutes'
            );
    }

}

?>