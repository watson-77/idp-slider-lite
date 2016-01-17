<?php
if ( ! function_exists('idp_bootstrap_slider') ) {

// Register Custom Post Type
	function idp_bootstrap_slider() {

		$labels = array(
			'name'                  => _x( 'Sliders', 'Post Type General Name', 'idp-slider' ),
			'singular_name'         => _x( 'Slider', 'Post Type Singular Name', 'idp-slider' ),
			'menu_name'             => __( 'Slider', 'idp-slider' ),
			'name_admin_bar'        => __( 'Slider', 'idp-slider' ),
			'archives'              => __( 'Slider Archives', 'idp-slider' ),
			'parent_item_colon'     => __( 'Sliders:', 'idp-slider' ),
			'all_items'             => __( 'All sliders', 'idp-slider' ),
			'add_new_item'          => __( 'Add New slider', 'idp-slider' ),
			'add_new'               => __( 'Add New', 'idp-slider' ),
			'new_item'              => __( 'New slider', 'idp-slider' ),
			'edit_item'             => __( 'Edit slider', 'idp-slider' ),
			'update_item'           => __( 'Update slider', 'idp-slider' ),
			'view_item'             => __( 'View slider', 'idp-slider' ),
			'search_items'          => __( 'Search slider', 'idp-slider' ),
			'not_found'             => __( 'Not found', 'idp-slider' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'idp-slider' ),
			'featured_image'        => __( 'Featured Image', 'idp-slider' ),
			'set_featured_image'    => __( 'Set featured image', 'idp-slider' ),
			'remove_featured_image' => __( 'Remove featured image', 'idp-slider' ),
			'use_featured_image'    => __( 'Use as featured image', 'idp-slider' ),
			'insert_into_item'      => __( 'Insert slider', 'idp-slider' ),
			'uploaded_to_this_item' => __( 'Uploaded to this slider', 'idp-slider' ),
			'items_list'            => __( 'Sliders list', 'idp-slider' ),
			'items_list_navigation' => __( 'Items list navigation', 'idp-slider' ),
			'filter_items_list'     => __( 'Filter items list', 'idp-slider' ),
		);
		$rewrite = array(
			'slug'                  => 'slider',
			'with_front'            => false,
			'pages'                 => true,
			'feeds'                 => false,
		);
		$args = array(
			'label'                 => __( 'Slider', 'idp-slider' ),
			'description'           => __( 'Beautiful sliders on Bootstrap', 'idp-slider' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'thumbnail', 'revisions', ),
			'taxonomies'            => array( '' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 20,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => false,
			'can_export'            => true,
			'has_archive'           => 'slider',
			'exclude_from_search'   => true,
			'publicly_queryable'    => true,
			//'rewrite'               => $rewrite,
			'capability_type'       => 'post',
		);
		register_post_type( 'slider', $args );

	}
	add_action( 'init', 'idp_bootstrap_slider', 0 );
}
?>