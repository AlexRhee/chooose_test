<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WCPBC_FixerIo' ) ) :

/**
 *
 * @class WCPBC_FloatRates
 * @version	1.0.0
 */
class WCPBC_FixerIo extends WCPBC_Exchange_Rates_Provider {	
	
	/**
	 * Exchange rates provider url (to display provider information).
	 *
	 * @var $provider_url
	 */
	public $provider_url = 'http://fixer.io/';
	
	/**
	 * Exchange rates provider url name.
	 *
	 * @var $name
	 */
	public $name = 'fixer.io';
	
	/**
	 * Return API endpoint
	 *
	 * @param  string $from_currency
	 * @param  array $to_currency	 
	 * @return string
	 */
	protected function get_api_endpoint( $from_currency, $to_currency ){
		return "http://api.fixer.io/latest?base={$from_currency}&symbols=" . implode(',', $to_currency);
	}

	/**
	 * Return rates array from response
	 *
	 * @param  string $from_currency
	 * @param  array $to_currency	 
	 * @return string
	 */
	protected function get_rates_from_response( $response, $from_currency, $to_currency ){		
		$data = json_decode( $response['body'], true );			
		$rates = $data['rates'];		

		return $rates;
	}
}

endif;

return new WCPBC_FixerIo();