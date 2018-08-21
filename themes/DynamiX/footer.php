<?php 
			
	echo "\n". '<div class="clear"></div>';
	echo "\n". '</div><!-- /content-wrap -->';	
	
	do_action('acoda_after_content_wrap');

	echo "\n". '</div><!-- /.main-wrap -->';	
	echo "\n". '</div><!-- /#main-wrap -->';

	echo "\n". '</div><!-- /.site-inwrap -->';

	// Preloader 
	if( acoda_settings('preloader') != false  )
	{	
		echo "\n". '<div class="preloader-wrapper active"><div class="spinner-layer"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>';
	}
	
	echo "\n". '</div><!-- /#container -->';

	echo "\n". '<div class="autototop"><a href="#"><i class="fal fa-angle-up"></i></a></div>';

	wp_footer();
	
echo "\n". '</body>';
echo "\n". '</html>';