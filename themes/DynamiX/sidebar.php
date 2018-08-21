<?php
/**
 * @package WordPress
 * @subpackage ACODA
 */

/* ------------------------------------
:: SIDEBAR CONFIG
------------------------------------ */
	
	$acoda_layout 				= acoda_settings('page_layout');
	$acoda_sidebar_one_select 	= acoda_settings('sidebar_one');
	$acoda_sidebar_two_select 	= acoda_settings('sidebar_two');

	
	if( $acoda_layout == 'layout_three' || $acoda_layout == 'layout_five' || $acoda_layout == 'layout_six' ) 
	{
		$acoda_columns = 'large-3';
	}
	else
	{
		$acoda_columns = 'large-4';
	}
	
	if($acoda_layout == "layout_six" || $acoda_layout == "layout_two" || $acoda_layout == "layout_three" ) { ?>
			
		<div class="acoda-sidebar columns side_one <?php echo esc_attr( $acoda_columns .' '. $acoda_layout ); ?>" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
            <div class="sidebar skinset-sidebar acoda-skin">
                <ul>
                    <?php dynamic_sidebar( $acoda_sidebar_one_select ); ?>
                </ul>
            </div>
		</div><!-- /sidebar-content -->
	
	
	<?php if($acoda_layout == "layout_three") { ?>     
	
		<div class="acoda-sidebar columns side_two <?php echo esc_attr( $acoda_columns .' '. $acoda_layout ); ?>" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
            <div class="sidebar skinset-sidebar acoda-skin">
                <ul>
                    <?php dynamic_sidebar( $acoda_sidebar_two_select ); ?>
                </ul>
            </div>
		</div><!-- /sidebar-content -->
	   
	<?php } 
	
	}
	
	if( $acoda_layout != "layout_one" && $acoda_layout != "layout_zero"  ) { ?>
		
		<?php if($acoda_layout != "layout_two" && $acoda_layout != "layout_three" && $acoda_layout != "layout_six" ) { ?>
	
	
		<div class="acoda-sidebar columns side_one <?php echo esc_attr( $acoda_columns .' '. $acoda_layout ); ?> <?php if( $acoda_layout=="layout_five" ) echo 'right'; elseif( $acoda_layout=="layout_four" || $acoda_layout=='') echo 'right last';  ?>" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
            <div class="sidebar skinset-sidebar acoda-skin">
                <ul>
                    <?php dynamic_sidebar( $acoda_sidebar_one_select ); ?>
                </ul>
            </div>
		</div><!-- /sidebar-content -->
	
		 
	<?php } 
	
	if($acoda_layout == "layout_five" || $acoda_layout == "layout_six") { ?>
	
		<div class="sidebar acoda-sidebar columns side_two <?php echo esc_attr( $acoda_columns .' '. $acoda_layout ); ?> <?php if($acoda_layout=="layout_five" || $acoda_layout=='layout_six') echo 'right last';  ?>" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
            <div class="skinset-sidebar acoda-skin">
                <ul>
                    <?php dynamic_sidebar( $acoda_sidebar_two_select ); ?>
                </ul>
            </div>
		</div><!-- /sidebar-content -->    
		 
	<?php } 
	
	}