<?php
/**
 * @category IDP Slider
 * @package  CMB2
 */

if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/init.php';
}

add_action( 'cmb2_init', 'idpsliderlite_metabox' );
function idpsliderlite_metabox() {

	$prefix = 'idpsliderlite_';

	$cmb_group = new_cmb2_box( array(
		'id'           => $prefix . 'slider',
		'title'        => __( 'Slider', 'idp-slider' ),
		'object_types' => array( 'slider' ),
		'context'      => 'normal',
		'priority'     => 'high',
	) );

	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_group->add_field( array(
		'id'          => $prefix . 'slide',
		'type'        => 'group',
		'options'     => array(
			'group_title'   => __( 'Slide №{#}', 'idp-slider' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add slide', 'idp-slider' ),
			'remove_button' => __( 'Delite slide', 'idp-slider' ),
			'sortable'      => true, // beta
			'closed'     => true, // true to have the groups closed by default
		),
	) );

	/**
	 * Group fields works the same, except ids only need
	 * to be unique to the group. Prefix is not needed.
	 *
	 * The parent field's id needs to be passed as the first argument.
	 */
	$cmb_group->add_group_field( $group_field_id, array(
		'name'       => __( 'Slide title', 'idp-slider' ),
		'id'         => 'title',
		'type'       => 'text',
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name' => __( 'Slide image', 'idp-slider' ),
		'id'   => 'image',
		'type' => 'file',
	) );

	$cmb_group->add_group_field( $group_field_id, array(
		'name' => __( '"alt" image', 'idp-slider' ),
		'id'   => 'image_caption',
		'type' => 'text',
	) );

}
/*///////////////////////// Slider Options //////////////////////////*/
class IDP_Slider_lite_Admin extends IDP_Slider_lite {
	/**
	 * Option key, and option page slug
	 * @var string
	 */
	private $key = 'idp-slider-lite-options';

	/**
	 * Options page metabox id
	 * @var string
	 */
	private $metabox_id = 'slider_idp_lite_metabox';

	/**
	 * Options Page title
	 * @var string
	 */
	protected $title = '';

	/**
	 * Options Page hook
	 * @var string
	 */
	protected $options_page = '';

	/**
	 * Holds an instance of the object
	 *
	 * @var Myprefix_Admin
	 **/
	private static $instance = null;

	/**
	 * Constructor
	 * @since 0.1.0
	 */
	/* было private*/ function __construct() {
		// Set our title
		$this->title = __('IDP Slider setting', 'idp-slider' );
	}

	/**
	 * Returns the running object
	 *
	 * @return Myprefix_Admin
	 **/
	public static function get_instance() {
		if( is_null( self::$instance ) ) {
			self::$instance = new IDP_Slider_lite_Admin();
			self::$instance->hooks();
		}
		return self::$instance;
	}

	/**
	 * Initiate our hooks
	 * @since 0.1.0
	 */
	public function hooks() {
		add_action( 'admin_init', array( $this, 'init' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		add_action( 'cmb2_admin_init', array( $this, 'add_options_page_metabox' ) );
	}


	/**
	 * Register our setting to WP
	 * @since  0.1.0
	 */
	public function init() {
		register_setting( $this->key, $this->key );
	}

	/**
	 * Add menu options page
	 * @since 0.1.0
	 */
	public function add_options_page() {
		$this->options_page = add_submenu_page('idp-slider-lite.php', __('IDP Slider setting', 'idp-slider' ),  __('IDP Slider setting', 'idp-slider' ), 'manage_options', $this->key, array( $this, 'admin_page_display' ) );

		// Include CMB CSS in the head to avoid FOUC
		add_action( "admin_print_styles-{$this->options_page}", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );
	}

	/**
	 * Admin page markup. Mostly handled by CMB2
	 * @since  0.1.0
	 */
	public function admin_page_display() {
		?>
		<div class="wrap cmb2-idp-slider <?php echo $this->key; ?>">
			<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>
			<?php cmb2_metabox_form( $this->metabox_id, $this->key ); ?>
		</div>
		<?php
	}

	/**
	 * Add the options metabox to the array of metaboxes
	 * @since  0.1.0
	 */
	function add_options_page_metabox() {

		// hook in our save notices
		add_action( "cmb2_save_idp-slider_fields_{$this->metabox_id}", array( $this, 'settings_notices' ), 10, 2 );

		$cmb = new_cmb2_box( array(
			'id'         => $this->metabox_id,
			'hookup'     => false,
			'cmb_styles' => false,
			'show_on'    => array(
				// These are important, don't remove
				'key'   => 'options-page', /*было options-page*/
				'value' => array( $this->key, )
			),
		) );

		// Set our CMB2 fields
		$cmb->add_field( array(
			'name' => __( 'Do action Google jquery?', 'idp-slider' ),
			'id' => 'jquery_act',
			'type' => 'checkbox',
			'default' => '',
			'desc' => __( 'If your theme uses jquery scripts from Google - disable this option', 'idp-slider' ),
		) );

		$cmb->add_field( array(
			'name' => __( 'Do action bootstrap.css & bootstrap.js of plugin', 'idp-slider' ),
			'id' => 'bootstrap_act',
			'type' => 'checkbox',
			'default' => '',
			'desc' => __( 'If your theme uses the styles and scripts from twitter bootstrap - disable this option', 'idp-slider' ),
		) );
	}

	/**
	 * Register settings notices for display
	 *
	 * @since  0.1.0
	 * @param  int   $object_id Option key
	 * @param  array $updated   Array of updated fields
	 * @return void
	 */
	public function settings_notices( $object_id, $updated ) {
		if ( $object_id !== $this->key || empty( $updated ) ) {
			return;
		}

		add_settings_error( $this->key . '-notices', '', __( 'Settings updated.', 'idp-slider' ), 'updated' );
		settings_errors( $this->key . '-notices' );
	}

	/**
	 * Public getter method for retrieving protected/private variables
	 * @since  0.1.0
	 * @param  string  $field Field to retrieve
	 * @return mixed          Field value or exception is thrown
	 */
	public function __get( $field ) {
		// Allowed fields to retrieve
		if ( in_array( $field, array('key', 'metabox_id', 'title', 'options_page'), true ) ) {
			return $this->{$field};
		}

		throw new Exception( 'Invalid property: ' . $field );
	}

}

/**
 * Helper function to get/return the Myprefix_Admin object
 * @since  0.1.0
 * @return Myprefix_Admin object
 */
function slider_idp_lite_admin() {
	return IDP_Slider_lite_Admin::get_instance();
}

/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 * @param  string  $key Options array key
 * @return mixed        Option value
 */
function slider_idp_lite_get_option( $key = '' ) {
	return cmb2_get_option( slider_idp_lite_admin()->key, $key );
}

// Get it started
slider_idp_lite_admin();
