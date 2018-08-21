<?php
    /**
     * The template for the main content of the panel.
     * Override this template by specifying the path where it is stored (templates_path) in your Redux config.
     *
     * @author      Redux Framework
     * @package     ReduxFramework/Templates
     * @version:    3.5.4.18
     */
?>
<!-- Header Block -->
<?php //$this->get_template( 'header.tpl.php' ); 

global $dynamix_options;

?>
<!-- Intro Text -->
<?php if ( isset( $this->parent->args['intro_text'] ) ) { ?>
    <div id="redux-intro-text"><?php echo wp_kses_post( $this->parent->args['intro_text'] ); ?></div>
<?php } ?>

<?php $this->get_template( 'menu_container.tpl.php' ); ?>

<div class="redux-main">
    <!-- Stickybar -->
    <?php $this->get_template( 'header_stickybar.tpl.php' ); ?>
    <div id="redux_ajax_overlay">&nbsp;</div>
    <?php
        foreach ($this->parent->sections as $k => $section) {
        if ( isset( $section['customizer_only'] ) && $section['customizer_only'] == true ) {
            continue;
        }
	

        //$active = ( ( is_numeric($this->parent->current_tab) && $this->parent->current_tab == $k ) || ( !is_numeric($this->parent->current_tab) && $this->parent->current_tab === $k )  ) ? ' style="display: block;"' : '';
        $section['class'] = isset( $section['class'] ) ? ' ' . $section['class'] : '';
		
        echo '<div id="' . $k . '_section_group' . '" class="redux-group-tab' . esc_attr( $section['class'] ) . '" data-rel="' . $k . '">';
		
		
        //echo '<div id="' . $k . '_nav-bar' . '"';
        /*
    if ( !empty( $section['tab'] ) ) {

        echo '<div id="' . $k . '_section_tabs' . '" class="redux-section-tabs">';

        echo '<ul>';

        foreach ($section['tab'] as $subkey => $subsection) {
            //echo '-=' . $subkey . '=-';
            echo '<li style="display:inline;"><a href="#' . $k . '_section-tab-' . $subkey . '">' . $subsection['title'] . '</a></li>';
        }

        echo '</ul>';
        foreach ($section['tab'] as $subkey => $subsection) {
            echo '<div id="' . $k .'sub-'.$subkey. '_section_group' . '" class="redux-group-tab" style="display:block;">';
            echo '<div id="' . $k . '_section-tab-' . $subkey . '">';
            echo "hello ".$subkey;
            do_settings_sections( $this->parent->args['opt_name'] . $k . '_tab_' . $subkey . '_section_group' );
            echo "</div>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        */

		
			
        // Don't display in the
        $display = true;
        if ( isset( $_GET['page'] ) && $_GET['page'] == $this->parent->args['page_slug'] ) {
            if ( isset( $section['panel'] ) && $section['panel'] == "false" ) {
                $display = false;
            }
        }
			

        if ( $display ) {
            do_action( "redux/page/{$this->parent->args['opt_name']}/section/before", $section );
            $this->output_section( $k );
			
			$demo_html	= '';
			
			if( $section['id'] == 'demos' )
			{

				$demo_data	= acoda_demo_data(); 
				$demos 		= $demo_data['demos'];

				foreach( $demos as $demo => $data )
				{
					$demo_html .= '
					<div class="demo-section">
					<img src="'. get_template_directory_uri() .'/demos/'. $demo .'/preview.png" />
					<h4>'. esc_html( $data['name'] )  .'</h4>
					<a href="#'. esc_attr( $demo ) .'" class="import-demo button button-primary">'. esc_html__( 'Install', 'dynamix' ) .'</a> <a href="'. esc_attr( $data['url'] ) .'" target="_blank" class="button">'. esc_html__( 'Preview', 'dynamix' ) .'</a>
					</div>		
					';
				}
				
				echo $demo_html;
			}
				
			if( $section['id'] == 'documentation' )
			{

				$demo_html .= '
				<p><a class="button-primary button" href="http://docs.acoda.com/dynamix/" target="_blank">'. esc_html('View Documentation', 'dynamix') .'</a> <a class="button-primary button" href="http://acoda.com/forums/" target="_blank">'. esc_html('Help Center', 'dynamix') .'</a></p>
				<div class="video-section">
				<iframe width="560" height="315" src="https://www.youtube.com/embed/qI4uBhvAwRs" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
				</div>		
				';
				
				echo $demo_html;
			}
			
			if( $k == 1 )
			{
    			if( $_REQUEST['page'] !== 'dynamix_options' ) 
				{
					$width = ' style="width: 40%;"'; ?>
					<table class="form-table skin-select">
						<tbody>
							<tr class="skin-editor-row disable-border">
								<th scope="row">
									<div class="redux_field_th"><?php esc_html_e('Select a Skin to Edit', 'dynamix'); ?></div>
								</th>
								<td>
									<fieldset id="dynamix_options-skin_select" class="redux-field-container redux-field redux-container-select" data-id="skin_select" data-type="select" >
										<select id="skin_select-select" data-placeholder="Select an item" name="dynamix_theme[skin_select]" class="redux-select-item" <?php echo $width ?> rows="6" tabindex="-1" title="" data-ajaxurl="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ) ?>">
											<?php

											$skin_ids = explode(',', rtrim( get_option('skins_'. get_option('acoda_theme') .'_ids'), ',' ) );

											$skin_id_array = array();

											foreach( $skin_ids as $skin_id )
											{
												echo '<option value="'. $skin_id .'" '. ( $skin_id == get_option('acoda_dynamix_skin') ? 'selected' : '' ) .' >'. $skin_id .'</option>';
											}	
											?>

										</select>
										<div class="description field-desc"><a href="#" class="button load-skin disabled"><?php esc_html_e('Load Skin', 'dynamix'); ?></a> <a href="#" class="button duplicate-skin"><?php esc_html_e('Duplicate Skin', 'dynamix'); ?></a> <a href="#" class="button delete-skin"><?php esc_html_e('Delete Skin', 'dynamix'); ?></a> <a href="#" class="button-primary button new-skin"><?php esc_html_e('New Skin', 'dynamix'); ?></a> </div>

									</fieldset>
								</td>
							</tr> 
							<tr class="hidden acoda-new-skin">
								<th scope="row">
									<div class="redux_field_th"><?php esc_html_e('Create a New Skin', 'dynamix'); ?></div>
								</th>
								<td>
									<fieldset id="dynamix_options-skin_create" class="redux-field-container redux-field">
										<input type="text" class="regular-text" id="acoda-new-skin" name="acoda-new-skin" />
										<div class="description field-desc"><a class="button-primary button create-skin new hidden"><?php esc_html_e('Create Skin', 'dynamix'); ?></a> <a class="button-primary button create-skin duplicate hidden"><?php esc_html_e('Duplicate Skin', 'dynamix'); ?></a> <a class="button cancel"><?php esc_html_e('Cancel', 'dynamix'); ?></a></div>
									</fieldset>
								</td>
							</tr>	

						</tbody>
					</table>	
			<?php
				}
            }
			
            do_action( "redux/page/{$this->parent->args['opt_name']}/section/after", $section );
        }
        //}
    ?></div><?php
    //print '</div>';
    }

    /**
     * action 'redux/page-after-sections-{opt_name}'
     *
     * @deprecated
     *
     * @param object $this ReduxFramework
     */
    do_action( "redux/page-after-sections-{$this->parent->args['opt_name']}", $this ); // REMOVE LATER

    /**
     * action 'redux/page/{opt_name}/sections/after'
     *
     * @param object $this ReduxFramework
     */
    do_action( "redux/page/{$this->parent->args['opt_name']}/sections/after", $this );
?>
<div class="clear"></div>
<!-- Footer Block -->
<?php $this->get_template( 'footer.tpl.php' ); ?>
<div id="redux-sticky-padder" style="display: none;">&nbsp;</div>
</div>
<div class="clear"></div>