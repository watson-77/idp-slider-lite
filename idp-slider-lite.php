<?php
/*
Plugin Name: Idp slider Lite
Plugin URI: https://garmoniagroup.ru
Description: Wordpress plugin "Slider" with bottom title slide. Styles and script at the Twitter bootstrap.
Author: Konstantin Milyushenko
Version: 0.1
Author URI: https://garmoniagroup.ru
Copyright: 2016
*/

/* Disallow direct access to the plugin file */
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('Sorry, but you cannot access this page directly.');
}

if (!class_exists("IDP_Slider_lite")) {

    class IDP_Slider_lite
    {

        function __construct()
        {
            add_action("admin_menu", array(&$this, "idp_slider_plugin_menu"));

            include "slider-set.php";
            include "fields/fields-slider.php";
            include "ButtonShortcodes.php";
            include "shortcodes.php";
            include "other_functions.php";
            load_plugin_textdomain('idp-slider', false, basename(dirname(__FILE__)) . '/language');
            // For User - add files .js and .css
            add_action("wp_print_scripts", array(&$this, "wppg_user_script"));
            add_action("wp_print_styles", array(&$this, "wppg_user_stylesheet"));
        }

        function idp_slider()
        {
            $this->__construct();
        }

        function idp_slider_plugin_menu()
        {
            // Creating a new top-level menu item
            if (function_exists('add_menu_page')) {
                add_menu_page(__('IDP Slider', 'idp-slider'), __('IDP Slider', 'idp-slider'), 'manage_options', basename(__FILE__), array(&$this, 'idp_slider_options_page'));
            }
            // Creation of a newly created sub-menus

        }

        function idp_slider_options_page()
        {
            echo "<h2>" . __('IDP Slider Discription', 'idp-slider') . "</h2>
            <div class='container-fluid'>
                <div class='row'>";
            $adm = cmb2_get_option('idp-slider-subpage', true);
            echo "<p style='text-align: center;'>" . __('<h3>Indicator connection plug-in scripts</h3> (if you have a problem when displaying sliders - check the plugin settings on the IDP page Slider options)', 'idp-slider') . "</p>";
            ?>
            <link rel="stylesheet" href="<?php echo plugins_url(); ?>/idp-slider/user_css/tables.css">
            <div class="table-responsive">
            <table class="table table-striped table-condensed">
                <thead>
                <tr>
                    <th><?php _e('The Google JQUERY script', 'idp-slider'); ?></th>
                    <th><?php _e('Scripts and styles from Twitter Bootstrap', 'idp-slider'); ?></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php
                        if ($adm['jquery_act'] == 'on') {
                            _e('Use the script attached in the plugin', 'idp-slider');
                        } else {
                            _e('Use the script attached in the theme or script is missing.', 'idp-slider');
                        } ?></td>
                    <td><?php
                        if ($adm['bootstrap_act'] == 'on') {
                            _e('Use the scripts and styles attached in the plugin', 'idp-slider');
                        } else {
                            _e('Use the scripts and styles attached in the theme or script is missing.', 'idp-slider');
                        } ?></td>
                </tr>
                </tbody>
            </table>
            </div>
            <hr/>

            <div class="col-sm-6 col-md-6">
                <caption><?php _e('It looks like the slider when using shortcode', 'idp-slider'); ?> <span class="img-thumbnail">[Modern-lite ids="##"]</span></caption>
                <p><img src="<?php echo plugins_url(); ?>/idp-slider/images/modern.jpg" class="img-responsive"/></p>
            </div>
            <div class="clearfix"></div>


            </div>
            </div>
            <?php

        }

        function wppg_user_script()
        {
            $adm = cmb2_get_option('idp-slider-subpage', true);
            $jquery_act = $adm['jquery_act'];
            $bootstrap_act = $adm['bootstrap_act'];
            if ($jquery_act == 'on') {
                wp_deregister_script('jquery');
                wp_register_script('jquery', "//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js", false, null);
                wp_enqueue_script('jquery');
            }
            if ($bootstrap_act == 'on') {
                wp_register_script('wppg_bootstrap_min_js', plugins_url('/user_js/bootstrap.min.js', __FILE__), false, null, true);
                wp_enqueue_script("wppg_bootstrap_min_js");
            }
            wp_register_script('wppg_npm_js', plugins_url('/user_js/npm.js', __FILE__), false, null, true);
            wp_enqueue_script("wppg_npm_js");
        }

        function wppg_user_stylesheet()
        {
            $adm = cmb2_get_option('idp-slider-subpage', true);
            $bootstrap_act = $adm['bootstrap_act'];
            if ($bootstrap_act == 'on') {
                wp_register_style('wppg_bootstrap_min_css', plugins_url('/user_css/bootstrap.min.css', __FILE__));
                wp_register_style('wppg_bootstrap-theme_min_css', plugins_url('/user_css/bootstrap-theme.min.css', __FILE__));
                wp_enqueue_style(array("wppg_bootstrap_min_css", "wppg_bootstrap-theme_min_css"));
            }
            wp_register_style('wppg_slider_css', plugins_url('/user_css/slider.css', __FILE__));
            wp_enqueue_style("wppg_slider_css");
        }

        function install()
        {
            // do not generate any output here
        }

        function idp_slider_deactivate()
        {
            // do not generate any output here
        }

    } //End Class IDP_Slider
} // end if

if (!isset($wp_idp_slider)) {
    $wp_idp_slider = new IDP_Slider_lite();
}

if (isset($wp_idp_slider)) {
    //Actions
    register_activation_hook(__FILE__, array(&$wp_idp_slider, 'install'));
    register_deactivation_hook(__FILE__, array(&$wp_idp_slider, 'idp_slider_deactivate'));
}
?>
