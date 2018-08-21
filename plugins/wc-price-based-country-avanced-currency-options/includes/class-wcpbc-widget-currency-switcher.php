<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Currency Switcher Widget
 *
 * @author   OscarGare
 * @category Widgets 
 * @version  1.0.6
 * @extends  WC_Widget
 */
class WCPBC_Widget_Currency_Switcher extends WC_Widget {

	/**
	 * @var string
	 */
	private static $_other_countries_text = '';

	/**
	 * Constructor
	 */
	public function __construct() {		
		$this->widget_description = __( 'A currency switcher for your store.', 'wc-price-based-country' );
		$this->widget_id          = 'wcpbc_currency_switcher';
		$this->widget_name        = __( 'WooCommerce Currency Switcher', 'wc-price-based-country' );
		$this->settings           = array(
			'title'  => array(
				'type'  => 'text',
				'std'   => __( 'Currency', 'wc-price-based-country' ),
				'label' => __( 'Title', 'wc-price-based-country' )
			),
			'currency_display_style'  => array(
				'type'  => 'display_style',
				'std'   => '',
				'label' => __( 'Currency display style', 'wc-price-based-country' )
			)
		);

		add_action( 'woocommerce_widget_field_display_style', array( $this, 'field_display_style' ), 10, 4 );

		parent::__construct();
	}

	/**
	 * Output currency display style field.
	 *	 
	 * @param string $key
	 * @param string $value
	 * @param array $setting
	 * @param object $instance
	 */
	public function field_display_style( $key, $value, $setting, $instance ) {
		?>
		<p>
			<label for="<?php echo $this->get_field_id( $key ); ?>"><?php echo $setting['label']; ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>" name="<?php echo $this->get_field_name( $key ); ?>" type="text" value="<?php echo esc_attr( $value ); ?>" placeholder="[name] ([symbol])" />			
		</p>
		<p class="description"><?php _e( 'Supports the following placeholders: [name] = currency name, [code] = currency code and [symbol] = currency symbol', 'wc-price-based-country' ); ?></p>
		<?php
	}	

	/**
	 * widget function.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args
	 * @param array $instance
	 *
	 * @return void
	 */
	public function widget( $args, $instance ) {				
		
		$options = array();		
		$currencies = get_woocommerce_currencies();			

		$base_country = wc_get_base_location();
		$base_country = $base_country['country'];				
		$base_currency = wcpbc_get_base_currency();

		$display_style = empty( $instance['currency_display_style'] ) ? '[name] ([symbol])' : $instance['currency_display_style'];

		$base_label = apply_filters( 'wc_price_based_country_currency_widget_text', 
			str_replace( array( '[code]', '[symbol]', '[name]', ' ' ), array( $base_currency, get_woocommerce_currency_symbol( $base_currency ), $currencies[ $base_currency ], '&nbsp;' ), $display_style )
			, $base_currency
		);

		$options[$base_country] = $base_label;

		$selected_country 	= $base_country;
		$selected_label		= $base_label;

		$customer_country 	= wcpbc_get_woocommerce_country();		

		foreach ( WCPBC()->get_regions() as $region ) {		

			$option_label = apply_filters( 'wc_price_based_country_currency_widget_text', 
				str_replace( array( '[code]', '[symbol]', '[name]', ' ' ), array( $region['currency'], get_woocommerce_currency_symbol( $region['currency'] ), $currencies[ $region['currency'] ], '&nbsp;' ), $display_style )
				, $region['currency']
			);

			if ( ! in_array( $option_label, $options ) ) {
				$options[ $region['countries'][0] ] = $option_label;						
			}
			
			if ( in_array( $customer_country, $region['countries'] ) ) {
				$selected_country 	= $region['countries'][0];				
				$selected_label		= $option_label;
			}			
		}		
		
		$sel_key = array_search( $selected_label, $options );
		if ( $sel_key !== $selected_country ) {
			unset( $options[$sel_key]);
			$options[$selected_country] = $selected_label;
		}
		

		//sort array
		asort($options);
		
		$this->widget_start( $args, $instance );						
		
		echo '<div class="wc-price-based-country">';
		wc_get_template('currency-switcher.php', array( 'options' => $options, 'selected_country' => $selected_country ), 'woocommerce-product-price-based-on-countries/', WCPBC_Avanced_Currency_Options::plugin_path()  . 'templates/' );
		echo '</div>';
		
		$this->widget_end( $args );
	}	

	
	
}

?>