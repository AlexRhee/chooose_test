<?php
/**
 * Overwrite Subscription Product Class
 *
 * @class 		WCPBC_Product_Subscription
 * @category	Class
 * @since		1.0
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class WCPBC_Product_Subscription extends WC_Product_Subscription {		

	/**
	 * Create a simple subscription product object.
	 *
	 * @access public
	 * @param mixed $product
	 */
	public function __construct( $product ) {

		parent::__construct( $product );
		
		unset ( $this->subscription_sign_up_fee );
		unset ( $this->subscription_price );					
	}	
}
