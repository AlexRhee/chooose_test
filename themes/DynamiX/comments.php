<?php
/**
 * @package WordPress
 * @subpackage acoda
 */

	if ( post_password_required() ) 
	{
		echo '<p class="nopassword">'. esc_html__( 'This post is password protected. Enter the password to view any comments.', 'dynamix' ) .'</p>';
		return;
	} ?>

    <div class="comments-wrapper comments-area row"  id="comments">
        <div class="comments-wrap columns large-12">
        
        <?php
        //if ( have_comments() ) : 
		
			echo '<div class="comments-value">';
			echo get_comments_number();
			echo '</div>';
			
			echo '<div class="heading-font" id="comments-title">'. ( get_comments_number() == 1 ? esc_html__( 'Comment', 'dynamix' ) : esc_html__( 'Comments', 'dynamix' ) ) .'</div>';
						
			if ( get_comment_pages_count() > 1 ) : // are there comments to navigate through ?>
                <nav id="comment-nav-above">
                        <h3 class="assistive-text"><?php esc_html_e( 'Comment navigation', 'dynamix' ); ?></h3>
                    <div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'dynamix' ) ); ?></div>
                    <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'dynamix' ) ); ?></div>
                </nav>
			<?php 
			endif; // check for comment navigation ?>
    
            <ol class="commentlist">
                <?php				
				wp_list_comments( array(
					'avatar_size' => 100,
					'style'       => 'ol',
					'short_ping'  => true,
				) ); ?>
            </ol>
    
            <?php
            if ( get_comment_pages_count() > 1 ) : // are there comments to navigate through ?>
            <nav id="comment-nav-below">
                <h3 class="assistive-text"><?php esc_html_e( 'Comment navigation', 'dynamix' ); ?></h3>
                <div class="nav-previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'dynamix' ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'dynamix' ) ); ?></div>
            </nav>

            <div class="page_nav clearfix">
            <?php
            echo paginate_comments_links( array(
                'prev_text' => '&laquo;',
                'next_text' => '&raquo;',							
            )); ?> 
            </div>	
            <br class="clear" />               
			<?php 
			endif; 
			
		//endif;
		comment_form(array(
			'comment_notes_after' => ' ',
			'label_submit' => esc_html__( 'Post Comment', 'dynamix' )
        )); ?>
    	</div><!-- #comments-wrap -->
    </div><!-- #comments -->