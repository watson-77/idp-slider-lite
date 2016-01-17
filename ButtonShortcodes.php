<?php
add_filter( 'mce_external_plugins', 'idp_slider_lite_add_buttons' );
function idp_slider_lite_add_buttons( $plugin_array )
{
    $plugin_array['idp_slider_lite_shortcodes'] = plugins_url('/user_js/buttonShortcode-tinymce-button.js', __FILE__);
    return $plugin_array;
}

add_filter( 'mce_buttons', 'idp_slider_lite_register_buttons' );
function idp_slider_lite_register_buttons( $buttons )
{
    array_push( $buttons, 'separator', 'idp_slider_lite_shortcodes' );
    return $buttons;
}

?>