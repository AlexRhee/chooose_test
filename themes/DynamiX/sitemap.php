<?php
/**
 * @package WordPress
 * @subpackage acoda
*/

/*
Template Name: Sitemap
*/ 

	get_header();
	
	$acoda_layout = acoda_settings('page_layout');

	$columns = 'large-8';
			
	if( $acoda_layout == "layout_one" ) 			: $columns = 'large-12';
	elseif( $acoda_layout == "layout_two" )		: $columns = 'large-8 last';
	elseif( $acoda_layout == "layout_three" ) 	: $columns = 'large-6 last';
	elseif( $acoda_layout == "layout_four" ) 	: $columns = 'large-8';
	elseif( $acoda_layout == "layout_five" )  	: $columns = 'large-6';
	elseif( $acoda_layout == "layout_six" )  	: $columns = 'large-6';
	endif;
		
	echo "\n\t". '<div id="content" class="columns '. esc_attr( $columns .' '. $acoda_layout ) .'">'; ?>
        
		<article>
            <h3><?php echo esc_html__('Pages', 'dynamix' ); ?></h3>
            <ul><?php wp_list_pages("title_li=" ); ?></ul>
            
            <h3><?php echo esc_html__('Feeds', 'dynamix' ); ?></h3>
            <ul>
                <li><a title="Full content" href="feed:<?php esc_url( bloginfo('rss2_url') ); ?>"><?php echo esc_html__('Main RSS', 'dynamix' ); ?></a></li>
                <li><a title="Comment Feed" href="feed:<?php esc_url( bloginfo('comments_rss2_url') ); ?>"><?php echo esc_html__('Comment Feed', 'dynamix' ); ?></a></li>
            </ul>
            
            <h3><?php echo esc_html__('Categories', 'dynamix' ); ?></h3>
            <ul><?php wp_list_categories('orderby=name&title_li='); ?></ul>
            
            <h3><?php echo esc_html__('Blog Posts', 'dynamix' ); ?></h3>
            <ul><?php $archive_query = new WP_Query('showposts=1000&cat=-8');
                    while ($archive_query->have_posts()) : $archive_query->the_post(); ?>
                        <li>
								<a href="<?php esc_url( the_permalink() ); ?>" rel="bookmark"><?php the_title(); ?></a>
                         		(<?php comments_number('0', '1', '%'); ?>)
                        </li>
                    <?php endwhile; ?>
            </ul>
            
            <h3><?php echo esc_html__('Archives', 'dynamix' ); ?></h3>
            <ul>
                <?php wp_get_archives('type=monthly&show_post_count=true'); ?>
            </ul>	
         
		</article>

	<?php 

	echo "\n\t\t". '<div class="clear"></div>';
	echo "\n\t". '</div><!-- #content -->';
				
	get_sidebar();
	get_footer();