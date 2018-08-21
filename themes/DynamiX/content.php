<?php
/**
 * The template for displaying content in the single.php template
 *
 * @package WordPress
 */
 
 ?>

<article id="post-<?php echo esc_attr( get_the_ID() ); ?>" <?php esc_attr( post_class('row') ); ?>> 	
	 
		
		<?php	

		
		echo '<section class="entry columns large-12 '. ( acoda_settings('archive_img_align') != 'center' ? 'flex-layout' : '' ) .'">';
		
			// Post Title
			acoda_post_title();			

			// Post Metadata 
			acoda_post_metadata();	
	
			// Post Image
			acoda_post_image();	

			// Post Content		
			acoda_post_content();				


			wp_link_pages(
				array( 
					'before'	=> '<div class="page_nav">',
					'after'		=> '</div>',
					'link_before'	=> '<span class="page-numbers">',
					'link_after'	=> '</span>',
				) 
			); 
    
		echo '</section><!-- / .entry -->';
     
		
		if( is_single() )
		{
			// Single Post Footer
			acoda_post_footer();
		} ?>
    
  
</article><!-- #post-<?php the_ID(); ?> -->