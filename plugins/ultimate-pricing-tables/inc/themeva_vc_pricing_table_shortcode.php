<?php

if( class_exists('WPBakeryShortCode') ) {

	class WPBakeryShortCode_T_Plan extends WPBakeryShortCode {

		protected  $predefined_atts = array(
			'el_position' => '',
			'title' => "",
			'subtitle' => "",
			'featured' => '',
			'button_text' => '',
			'button_link' => '',
			'price' => '',
			'currency' => '',
			'target' => '',
			'button_shape' => '',
			'icon' => '',
			'icon_background' => '',
			'icon_color' => '',						
			'per' => '',
			'color' => '',
			'el_class' => '',
			'width' => '1/4',
			'title_background' => '',
			'background_color' => '',
			'border_style' => '',
			'border_color' => '',
			'shade_color' => '',
			'text_color' => '',
			'title_color' => '',
			'subtitle_color' => '',			
			'button_color' => '',
			'button_text_color' => '',
			'button_border_color' => '',	
			'button_background_color' => '',				
			'shadow' => ''
		);
		

		public $nonDraggableClass = 'vc-non-draggable-column';
		/**
		 * @param $controls
		 * @param string $extended_css
		 *
		 * @return string
		 */
		public function getColumnControls( $controls, $extended_css = '' ) {
			$output = '<div class="vc_controls vc_control-column vc_controls-visible' . ( ! empty( $extended_css ) ? " {$extended_css}" : '' ) . '">';
			$controls_end = '</div>';
	
			if ( ' bottom-controls' === $extended_css ) {
				$control_title = __( 'Append to this column', 'js_composer' );
			} else {
				$control_title = __( 'Prepend to this column', 'js_composer' );
			}
			if ( vc_user_access()
				->part( 'shortcodes' )
				->checkStateAny( true, 'custom', null )
				->get()
			) {
				$controls_add = '<a class="vc_control column_add vc_column-add" data-vc-control="add" href="#" title="' . $control_title . '"><i class="vc_icon"></i></a>';
			} else {
				$controls_add = '';
			}
			$controls_edit = '<a class="vc_control column_edit vc_column-edit"  data-vc-control="edit" href="#" title="' . __( 'Edit this column', 'js_composer' ) . '"><i class="vc_icon"></i></a>';
			$controls_delete = '<a class="vc_control column_delete vc_column-delete" data-vc-control="delete"  href="#" title="' . __( 'Delete this column', 'js_composer' ) . '"><i class="vc_icon"></i></a>';
			$editAccess = vc_user_access_check_shortcode_edit( $this->shortcode );
			$allAccess = vc_user_access_check_shortcode_all( $this->shortcode );
			if ( is_array( $controls ) && ! empty( $controls ) ) {
				foreach ( $controls as $control ) {
					if ( 'add' === $control || ( $editAccess && 'edit' === $control ) || $allAccess ) {
						$method_name = vc_camel_case( 'output-editor-control-' . $control );
						if ( method_exists( $this, $method_name ) ) {
							$output .= $this->$method_name();
						} else {
							$control_var = 'controls_' . $control;
							if ( isset( ${$control_var} ) ) {
								$output .= ${$control_var};
							}
						}
					}
				}
	
				return $output . $controls_end;
			} elseif ( is_string( $controls ) && 'full' === $controls ) {
				if ( $allAccess ) {
					return $output . $controls_add . $controls_edit . $controls_delete . $controls_end;
				} elseif ( $editAccess ) {
					return $output . $controls_add . $controls_edit . $controls_end;
				}
				return $output . $controls_add . $controls_end;
			} elseif ( is_string( $controls ) ) {
				$control_var = 'controls_' . $controls;
				if ( 'add' === $controls || ( $editAccess && 'edit' == $controls || $allAccess ) && isset( ${$control_var} ) ) {
					return $output . ${$control_var} . $controls_end;
				}
	
				return $output . $controls_end;
			}
			if ( $allAccess ) {
				return $output . $controls_add . $controls_edit . $controls_delete . $controls_end;
			} elseif ( $editAccess ) {
				return $output . $controls_add . $controls_edit . $controls_end;
			}
			
			return $output . $controls_add . $controls_end;
		}
	
		/**
		 * @param $param
		 * @param $value
		 *
		 * @return string
		 */
		public function singleParamHtmlHolder( $param, $value ) {
			$output = '';
			// Compatibility fixes.
			$old_names = array(
				'yellow_message',
				'blue_message',
				'green_message',
				'button_green',
				'button_grey',
				'button_yellow',
				'button_blue',
				'button_red',
				'button_orange',
			);
			$new_names = array(
				'alert-block',
				'alert-info',
				'alert-success',
				'btn-success',
				'btn',
				'btn-info',
				'btn-primary',
				'btn-danger',
				'btn-warning',
			);
			$value = str_ireplace( $old_names, $new_names, $value );
			$param_name = isset( $param['param_name'] ) ? $param['param_name'] : '';
			$type = isset( $param['type'] ) ? $param['type'] : '';
			$class = isset( $param['class'] ) ? $param['class'] : '';
	
			if ( isset( $param['holder'] ) && 'hidden' !== $param['holder'] ) {
				$output .= '<' . $param['holder'] . ' class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '">' . $value . '</' . $param['holder'] . '>';
			}
	
			return $output;
		}
	
		/**
		 * @param $atts
		 * @param null $content
		 *
		 * @return string
		 */
		public function contentAdmin( $atts, $content = null ) {
			$width = $el_class = '';
			extract( shortcode_atts( $this->predefined_atts, $atts ) );
			$output = '';
	
			$column_controls = $this->getColumnControls( $this->settings( 'controls' ) );
			$column_controls_bottom = $this->getColumnControls( 'add', 'bottom-controls' );
	
			if ( ' column_14' === $width || ' 1/4' === $width ) {
				$width = array( 'vc_col-sm-3' );
			} elseif ( ' column_14===$width-14-14-14' ) {
				$width = array(
					'vc_col-sm-3',
					'vc_col-sm-3',
					'vc_col-sm-3',
					'vc_col-sm-3',
				);
			} elseif ( ' column_13' === $width || ' 1/3' === $width ) {
				$width = array( 'vc_col-sm-4' );
			} elseif ( ' column_13===$width-23' ) {
				$width = array( 'vc_col-sm-4', 'vc_col-sm-8' );
			} elseif ( ' column_13===$width-13-13' ) {
				$width = array( 'vc_col-sm-4', 'vc_col-sm-4', 'vc_col-sm-4' );
			} elseif ( ' column_12' === $width || ' 1/2' === $width ) {
				$width = array( 'vc_col-sm-6' );
			} elseif ( ' column_12===$width-12' ) {
				$width = array( 'vc_col-sm-6', 'vc_col-sm-6' );
			} elseif ( ' column_23' === $width || ' 2/3' === $width ) {
				$width = array( 'vc_col-sm-8' );
			} elseif ( ' column_34' === $width || ' 3/4' === $width ) {
				$width = array( 'vc_col-sm-9' );
			} elseif ( ' column_16' === $width || ' 1/6' === $width ) {
				$width = array( 'vc_col-sm-2' );
			} elseif ( ' column_56' === $width || ' 5/6' === $width ) {
				$width = array( 'vc_col-sm-10' );
			} else {
				$width = array( '' );
			}
			for ( $i = 0; $i < count( $width ); $i ++ ) {
				$output .= '<div ' . $this->mainHtmlBlockParams( $width, $i ) . '>';
				$output .= str_replace( '%column_size%', wpb_translateColumnWidthToFractional( $width[ $i ] ), $column_controls );
				$output .= '<div class="wpb_element_wrapper">';
	
				if ( isset( $this->settings['params'] ) ) {
					$inner = '';
					foreach ( $this->settings['params'] as $param ) {
						$param_value = isset( ${$param['param_name']} ) ? ${$param['param_name']} : '';
						if ( is_array( $param_value ) ) {
							// Get first element from the array
							reset( $param_value );
							$first_key = key( $param_value );
							$param_value = $param_value[ $first_key ];
						}
						$inner .= $this->singleParamHtmlHolder( $param, $param_value );
					}
					$output .= $inner;
				}
				$output .= '</div>';
				$output .= str_replace( '%column_size%', wpb_translateColumnWidthToFractional( $width[ $i ] ), $column_controls_bottom );
				$output .= '</div>';
			}
	
			return $output;
		}
	
		/**
		 * @return string
		 */
		public function customAdminBlockParams() {
			return '';
		}
	
		/**
		 * @param $width
		 * @param $i
		 *
		 * @return string
		 */
		public function mainHtmlBlockParams( $width, $i ) {
			$sortable = ( vc_user_access_check_shortcode_all( $this->shortcode ) ? 'wpb_sortable' : $this->nonDraggableClass );
	
			return 'data-element_type="' . $this->settings['base'] . '" data-vc-column-width="' . wpb_vc_get_column_width_indent( $width[ $i ] ) . '" class="wpb_' . $this->settings['base'] . ' ' . $sortable . ' ' . $this->templateWidth() . ' wpb_content_holder"' . $this->customAdminBlockParams();
		}
	
		/**
		 * @param $width
		 * @param $i
		 *
		 * @return string
		 */
		public function containerHtmlBlockParams( $width, $i ) {
			return 'class="wpb_column_container vc_container_for_children"';
		}
	
		/**
		 * @param string $content
		 *
		 * @return string
		 */
		public function template( $content = '' ) {
			return $this->contentAdmin( $this->atts );
		}
	
		/**
		 * @return string
		 */
		protected function templateWidth() {
			return '<%= window.vc_convert_column_size(params.width) %>';
		}
		
		public function content( $atts, $content = null ) {
			$title = $el_position = $featured = $button_text = $custom_color = $button_link = $price = $target = $per = $color = $el_class = $width = $title_background = $icon_style = $shadow = $border_style = $shade_color = $text_color = $title_color = $plan_style = $plan_design = $button_style = $border_color = $background_color = '';
	
			extract(shortcode_atts(array(
				'el_position' => '',
				'title' => "",
				'subtitle' => "",
				'featured' => '',
				'button_text' => '',
				'button_link' => '',
				'price' => '',
				'currency' => '',
				'target' => '',
				'button_shape' => '',
				'icon' => '',
				'icon_background' => '',
				'icon_color' => '',						
				'per' => '',
				'color' => '',
				'el_class' => '',
				'width' => '1/4',
				'title_background' => '',
				'background_color' => '',
				'border_style' => '',
				'border_color' => '',
				'shade_color' => '',
				'text_color' => '',
				'title_color' => '',
				'subtitle_color' => '',
				'button_color' => '',
				'button_text_color' => '',
				'button_border_color' => '',	
				'button_background_color' => '',									
				'shadow' => ''				
			), $atts));	
		
			// Featured
			if( $featured == 'true' ) $featured = 'featured';
			
			// Custom Plan Design
			if( $color == 'custom' )
			{
				// Color
				if( !empty( $background_color ) )
				{
					$plan_design .= 'background-color:'. $background_color .';';
				}

				// Text Color
				if( !empty( $text_color ) )
				{
					$plan_design .= 'color:'. $text_color .';';
				}			
				
				// Button Color
				if( !empty( $button_color ) ) 
				{				
					$button_style = 'background-color:'. $button_color .';';
				}

				// Button Color
				if( !empty( $button_border_color ) ) 
				{				
					$button_style .= 'border-color:'. $button_border_color .';';
				}				

				if( !empty( $button_background_color ) ) 
				{				
					$button_background_style = 'background-color:'. $button_background_color .';';
				}
				
			
				// Set Icon Background if not set
				if( empty( $icon_background ) )
				{
					$icon_background = $custom_color;
				}
			}
			elseif( $color == '' && empty( $custom_color ) )
			{
				$color = 'grey';
			}
			
			$width = wpb_translateColumnWidthToSpan($width);	
		
			$output = '';
			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'pricing-plan group '. $featured .' '. ( !empty( $shadow ) ? 'shadow '  : '' ) . ( !empty( $plan_style ) ? $plan_style. ' '  : '' ) . ( !empty( $border_style ) ? 'border-'. $border_style .' ' : '' ) . $color .' '. $el_class .' '. $width, $this->settings['base']);
			$output .= "\n\t\t\t" . '<div class="'.$css_class.'">';	
			$output .= "\n\t\t\t\t" . '<div class="plan-wrap" '. ( !empty( $border_color ) && $color == 'custom' ? 'style="border-color:'. $border_color .'"' : '' ) .' >';		

			if( !empty( $icon ) ) 
			{
				// Icon + Icon Background
				if( !empty( $icon_color ) ) $icon_style .= 'color:'. $icon_color .';';
				if( !empty( $icon_background ) ) $icon_style .= 'background-color:'. $icon_background .';';						
				
				wp_register_style( 'font-awesome', plugins_url('../css/font-awesome/css/font-awesome.min.css', __FILE__) );
				wp_enqueue_style( 'font-awesome' );				
								
				$output .= "\n\t\t\t" . '<span class="icon-wrap" '. ( !empty( $icon_style ) && $color == 'custom' ? 'style="'. $icon_style .'"' : '' ) .'><span><i class="fa '. $icon .'"></i></span></span>';	
			}
			
			
			
			
			$output .= "\n\t\t\t\t" . '<div class="pricing-title '. ( !empty( $icon ) ? 'icon' : '' ) .' '. $color .'" '. ( !empty( $title_background ) && $color == 'custom' ? 'style="background-color:'. $title_background .'"' : '' ) .'>';
			
			if( !empty( $title ) )
			{
				$output .= '<h3 '. ( !empty( $title_color ) && $color == 'custom' ? 'style="color:'. $title_color .'"' : '' ) .'>'. ( $title =='BLANK' ? '&nbsp;' : esc_attr($title) ) .'</h3>';
			}
			
			
			if( !empty( $subtitle ) )
			{
				$output .= '<h4 '. ( !empty( $subtitle_color ) && $color == 'custom' ? 'style="color:'. $subtitle_color .'"' : '' ) .'>'. ( $subtitle =='BLANK' ? '&nbsp;' : esc_attr($subtitle) ) .'</h4>';
			}
			
			
			if ( $price !='' )
			{
				$output .= "\n\t\t\t\t\t" . '<div class="pricing-cost" '. ( !empty( $title_color ) ? 'style="color:'. $title_color .'"' : '' ) .'><span class="price-value"><span class="price-currency">'. esc_attr($currency) .'</span><span class="price-number">'. ( $price =='BLANK' ? '&nbsp;' : $price ) .'</span><span class="price-per">'. esc_attr($per) .'</span></span></div>';
			}
			
			$output .= "\n\t\t\t\t" . '</div>';
			$output .= "\n\t\t\t\t\t" . '<div class="pricing-container '. $color .'" '. ( !empty( $plan_design ) ? 'style="'. $plan_design .'"' : '' ) .'>';
			$output .= "\n\t\t\t\t\t\t" . '<div class="pricing-content">'.wpb_js_remove_wpautop($content).'</div>';
				
			// Set Signup Button		
			if( $target !='' ) $target='target="'. $target .'"';
			
			if( $button_text != '' )
			{
				$output .= "\n\t\t\t\t\t" . '<div class="pricing-signup" '. ( !empty( $button_background_style ) ? 'style="'. $button_background_style .'"' : '' ) .'><div class="pricing-button '. ( !empty( $button_shape ) ? $button_shape : '' ) .'" '. ( !empty( $button_style ) ? 'style="'. $button_style .'"' : '' ) .'><div class="button-overlay"><a href="'.esc_attr($button_link).'" '. $target .' '. ( !empty( $button_text_color ) ? 'style="color:'. $button_text_color .'"' : ''  ) .' >'. esc_attr($button_text) .'</a></div></div></div>';
			}
				
			$output .= "\n\t\t\t\t\t" . '</div> ' . $this->endBlockComment('.pricing-container');
			$output .= "\n\t\t\t\t" . '</div> ' . $this->endBlockComment('.plan-wrap');	
			$output .= "\n\t\t\t" . '</div> ' . $this->endBlockComment('.pricing-plan');	
	
			return $output;
		}	
	}
	
	if( !class_exists( 'WPBakeryShortCode_VC_Row' ) )
	{
		require_once vc_path_dir('SHORTCODES_DIR', 'vc-row.php');
	}
	

	class WPBakeryShortCode_T_Pricing_Table extends WPBakeryShortCode_VC_Row {

	   protected $predefined_atts = array(
			'padding' => '',
			'el_class' => '',
			'animation' => '',
			'title_size' => '',
			'subtitle_size' => '',			
			'plan_style' => ''
		);

		protected function content( $atts, $content = null ) {
			$padding = $animation = $plan_style = $el_class = '';

			extract(shortcode_atts(array(
				'padding' => '',
				'el_class' => '',
				'animation' => '',
				'title_size' => '',
				'subtitle_size' => '',
				'plan_style' => '',
			), $atts));
			$output = '';

			wp_register_style( 'themeva_pricing_table', plugins_url('../css/pricing-table.css', __FILE__) );
			wp_enqueue_style( 'themeva_pricing_table' );
			
			if( $padding != 'true' ) 
			{
				$el_class .= ' no_padding';
			}
			else
			{
				//$el_class .= ' '. get_row_css_class();
			}
			
			if( $plan_style == 'rounded' )
			{
				$el_class .= ' rounded';
			}
			
			if( $animation != 'disable' )
			{
				$el_class .= ' animate '. $animation;
			}
			
			if( !empty( $title_size ) )
			{
				$el_class .= ' title-size-'. $title_size;	
			}

			if( !empty( $subtitle_size ) )
			{
				$el_class .= ' subtitle-size-'. $subtitle_size;	
			}			
	
			$el_class = $this->getExtraClass($el_class);

			$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'themeva_pricing_table clearfix '.$el_class , $this->settings['base']);
	
			$output .= "\n\t".'<div class="'.$css_class.'">';
			$output .= "\n\t\t\t".wpb_js_remove_wpautop($content);
			$output .= "\n\t".'</div> ';		
			
			//$output = $this->startRow($el_position) . $output . $this->endRow($el_position);
			return $output;
		}		
	}
}