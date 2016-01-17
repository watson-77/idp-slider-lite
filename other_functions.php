<?php
if ( ! function_exists( 'remove_width_attribute_sliderimg' ) ) {
    add_filter('post_thumbnail_html', 'remove_width_attribute_sliderimg', 10);
    add_filter('image_send_to_editor', 'remove_width_attribute_sliderimg', 10);

    function remove_width_attribute_sliderimg($html)
    {
        $html = preg_replace('/(width|height)="\d*"\s/', "", $html);
        return $html;
    }
}
/* Вывести ID страницы/записи в таблицах в админке */
if (is_admin()) {
// колонка "ID" для постов и страниц в админке
    add_filter('manage_posts_columns', 'idp_slider_lite_add_col', 5);
    add_action('manage_posts_custom_column', 'idp_slider_lite_show_id', 5, 2);
    add_action('admin_print_styles-edit.php', 'idp_slider_lite_id_style');
    function idp_slider_lite_add_col($defaults) {$defaults['wps_post_id'] = __('ID'); return $defaults;}
    function idp_slider_lite_show_id($column_name, $id) {if ($column_name === 'wps_post_id') echo $id;}
    function idp_slider_lite_id_style() {print '<style>#wps_post_id{width:2em}</style>';}
}
?>