<?php
/**
 * The template for displaying Page format
 *
 * @package WordPress
 */ ?>

	<article id="post-<?php echo esc_attr( get_the_ID() ); ?>" <?php esc_attr( post_class() ); ?> itemscope="itemscope" itemtype="http://schema.org/CreativeWork"> 	
        <section class="entry">
			<?php 
			
			the_content( esc_html__('<p class="serif">Read the rest of this page &raquo;</p>', 'dynamix' ) );
			
			wp_link_pages(
				array( 
					'before'	=> '<div class="page_nav">',
					'after'		=> '</div>',
					'link_before'	=> '<span class="page-numbers">',
					'link_after'	=> '</span>',
				) 
			); ?>
  
        </section><!-- /entry -->  
    </article>