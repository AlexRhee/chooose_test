<?php
/**
 * The template for displaying content in the single.php template
 *
 * @package WordPress
 */
 
 ?>

<article id="post-<?php echo esc_attr( get_the_ID() ); ?>" <?php esc_attr( post_class() ); ?> itemscope="itemscope" itemtype="http://schema.org/CreativeWork"> 	
	<div class="article-row row">               
		<section class="entry columns large-12">

			<?php
				
			// Author Avatar
			echo get_avatar( get_the_author_meta( 'ID' ), 70 );
				 
			// Post Title
			acoda_post_title();

			// Post Metadata 
			acoda_post_metadata();			
							
			// Post Content		
			acoda_post_content();		
		
			wp_link_pages(
				array( 
					'before'	=> '<div class="page_nav">',
					'after'		=> '</div>',
					'link_before'	=> '<span class="page-numbers">',
					'link_after'	=> '</span>',
				) 
			); ?>
    
		</section><!-- / .entry --> 
     
		<?php 
		if( is_single() )
		{
			// Single Post Footer
			acoda_post_footer();
		} ?>
    
    </div>
</article><!-- #post-<?php the_ID(); ?> -->