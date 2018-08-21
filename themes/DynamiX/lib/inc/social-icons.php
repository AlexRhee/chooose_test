<?php 

	if( empty( $acoda_socialicons ) )
	{
		//$acoda_socialicons = acoda_settings('display_socialicons');	
	}
	
	if( $acoda_socialicons == true && acoda_settings('socialicons') !='' )
	{
		$output = $display_type = '';
		
		$mobile_social = ( !empty( $mobile_social ) ? $mobile_social : '' );
		
		//require get_template_directory() .'/lib/admin/inc/social-media-urls.php';
		
		// Get Social Icons
		$get_social_icons = acoda_settings('socialicons');
				
			
		foreach( $get_social_icons as $social_icon => $value )
		{
			// Check global Social Options
			if( acoda_settings( 'display_socialicons' ) == true || acoda_settings( 'share_post' ) == true )
			{					
				if( $value['enabled'] == true )
				{
					if( empty( $value['url'] ) )
					{
						$social_defaultlink = acoda_social_icon_data( $value['id'] );
	
						$sociallink = ( ! empty( $social_defaultlink ) ? acoda_social_link( $social_defaultlink ) : '' );
					}
					else
					{
						$sociallink = ( ! empty( $value['url'] ) ? acoda_social_link( $value['url'] ) : '' );
					}
					

					// Check for lightbox attribute
					$popup = '';

					if( strpos( $sociallink , 'popup=yes' ) !== false ) 
					{
						$sociallink = str_replace( 'popup=yes', '', $sociallink );
						$popup = 'javascript:window.open(this.href, "", "menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600")';
					}

					$icon_name = $value['icon'] ;

					$output .= "\n\t\t". '<li class="dock-tab '. esc_attr( $display_type ) .' social-'. esc_attr( strtolower( str_replace('.','',$value['id'] ) ) ) .'">';
					$output .= '<a href="'. esc_url( str_replace(' ', '%20', $sociallink) ) .'" rel="nofollow" title="'. esc_attr( $value['name'] ) .'" '. ( !empty( $popup ) ? 'onclick="'. esc_js( $popup ) .'"' : '' ) .' target="_blank"><i class="social-icon fab '. esc_attr( $icon_name ) .'"></i></a>';
					$output .= '</li>';
				}
			}
		}		
			
		echo $output; 
	}