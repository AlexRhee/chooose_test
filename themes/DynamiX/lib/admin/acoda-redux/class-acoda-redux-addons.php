<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if ( class_exists( 'Acoda_Redux_Addons' ) ) {
	return;
}

/**
 * Handle loading Redux Addons for Acoda.
 *
 * @since 4.0.0
 */
class Acoda_Redux_Addons {

	/**
	 * An array of our custom field types.
	 *
	 * @access public
	 * @var array
	 */
	public $field_types;

	/**
	 * An array of our custom extension.
	 *
	 * @access public
	 * @var array
	 */
	public $extensions;

	/**
	 * The path of the current file.
	 *
	 * @access public
	 * @var string
	 */
	public $path;

	/**
	 * Constructor.
	 *
	 * @access public
	 */
	public function __construct() {
		// An array of all the custom fields we have.
		$this->field_types = array(
			'typography',
		);

		$theme = strtolower( get_option('acoda_theme') );
		$theme_options = get_option( $theme .'_options' );

		$default_skin = get_option( 'acoda_dynamix_skin' );
		
		$skin = ( !empty( $default_skin ) ? $default_skin : 'Classic');	

		$this->path = dirname( __FILE__ );
		
		foreach ( $this->field_types as $field_type ) {
			add_action( 'redux/'. $theme .'_'. $skin .'/field/class/' . $field_type, array( $this, 'register_' . $field_type ) );
		}

	}

	/**
	 * Register the custom typography field
	 */
	public function register_typography() {
		return $this->path . '/custom-fields/field_typography.php';
	}
}
