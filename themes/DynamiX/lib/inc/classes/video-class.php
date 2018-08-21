<?php

	// Get WP Embed
    $media_url = $acoda_movieurl;
    $file = basename($media_url); 
    $parts = explode(".", $file); 

	$acoda_loop = ( !empty( $acoda_loop ) ? $acoda_loop : '0');
		
	
	if( $acoda_videotype == "oembed" || empty( $acoda_videotype ) )
	{		
		$video_types_array = array("mp4", "mov", "flv", "wmv", "wmv", "webm", "ogv", "mp3");
		
		$video_types = implode('|', $video_types_array);
		
		if( preg_match( '/^.*\.('. $video_types .')$/i', $media_url ) )
		{
			$video_html = 'video';
		}
		else
		{
			$video_html = 'iframe';
		}
	}	

	$ratio = ( !empty( $ratio ) ? $ratio : '' );
	
    $output .= '<div class="videowrap '. ( $ratio != 'normal' ? 'ratio '. esc_attr( $ratio ) : '' ) . ( !empty( $video_html ) ? ' '. esc_attr( $video_html ) : '' ) .'">';
	
	$height = ( !empty( $img['max_height'] ) ? 'height="'. esc_attr( $img['max_height'] ) .'"' : '' );
	$width = ( !empty( $img['max_width'] ) ? 'height="'. esc_attr( $img['max_width'] ) .'"' : '' );
    
    $vidid = $parts[0]; //File name 

	if( $acoda_videotype == "oembed" || empty( $acoda_videotype ) )
	{		
		$video_types_array = array("mp4", "mov", "flv", "wmv", "wmv", "webm", "ogv");
		
		$video_types = implode('|', $video_types_array);
		
		if( preg_match( '/^.*\.('. $video_types .')$/i', $media_url ) )
		{
			$output .= do_shortcode('[video src="'. esc_url( $media_url ) .'" '. $height .' '. $width .' '. ( $acoda_videoautoplay == 1 ? 'autoplay="on"' : '' ) .' '. ( $acoda_loop == 1 ? 'loop="on"' : '' ) .' ]');
		}
		else if( preg_match( '/^.*\.(mp3)$/i', $media_url ) )
		{
			$videoautoplay = ( $acoda_videoautoplay == '1' ? 'autoplay="on"' : '' );
			$output .= do_shortcode('[audio src="'.  esc_url( $media_url ) .'" '. $videoautoplay .']'); 
		}
		else
		{
			$output .= acoda_get_embed( $height, $width, $media_url );
		}
	}
    elseif( $acoda_videotype == "youtube" )
	{	
		$vidid = strstr( $vidid , '=' ); // trim id after = 
		$params = strstr( $vidid , '&' ); // trim id after = 
            
		$splitter = '?'; // set url parameter	
		$isplaylist = strpos($media_url ,"playlist?list="); // check if playlist
		$isredirect = strpos($media_url ,"youtu.be"); // check if share url
       
		// if share url retrieve video id   
		if( $isredirect != false ) 
		{ 
			$vidid=$parts[0];
			$splitter = '?'; // set url parameter	
		}				
                                
		if( $isplaylist != false ) 
		{
			$vidid = 'videoseries?list='.$vidid;
			$splitter = '&amp;';		
		}	
    
            
		if( $isredirect == false )
		{
			$vidid = substr($vidid, 1); // remove = if not youtu.be address		
		}
            
		$vidid = str_replace( $params ,'', $vidid );
		$params = str_replace( '?','', $params );
		$video_url = '//www.youtube.com/embed/'.  $vidid . $splitter .'autoplay='. $acoda_videoautoplay .'&amp;loop='. $acoda_loop . $params .'&amp;rel=0&amp;wmode=opaque&amp;title=&amp;playlist='. $vidid;
				
		$output .= '<iframe frameborder="0" '. esc_attr( $height .' '. $width ) .' marginheight="0" marginwidth="0" src="'. esc_url( $video_url ) .'" allowfullscreen></iframe>';
		
    }
	elseif( $acoda_videotype == "wistia" )
	{
		$extras = $components = '';
		
		$components = parse_url( $vidid );

		$vidid = str_ireplace( array('/medias/', '/embed/iframe/'), '', $components['path'] );
		$extras = $components['query'];
		
		if( $extras == '' ) $extras = 'controlsVisibleOnLoad=true&amp;version=v1&amp;volumeControl=true';
		
		// autoplay
		if( $acoda_videoautoplay == '1' ) $acoda_videoautoplay = 'true'; else $acoda_videoautoplay = 'false'; 

		$extras = $extras . '&amp;autoPlay='.  $acoda_videoautoplay;
		
		$video_url = '//fast.wistia.net/embed/iframe/'. $vidid .'?'. $extras;
		
		$output .= '<iframe src="'. esc_url( $video_url ) .'" allowtransparency="true" frameborder="0" scrolling="no" class="wistia_embed" name="wistia_embed" '. esc_attr( $height .' '. $width ) .'></iframe>'; 
		
    }
	elseif( $acoda_videotype == "vimeo" )
	{ 
		$video_url = '//player.vimeo.com/video/'. $vidid .'?autoplay='. $acoda_videoautoplay .'&amp;loop='. $acoda_loop .'&amp;title=0&amp;byline=0&amp;portrait=0&amp;';
    	$output .= '<iframe frameborder="0" marginheight="0" marginwidth="0"  src="'. esc_url( $video_url ) .'" '. esc_attr( $height .' '. $width ) .' ></iframe>';
    
	} 	

	
	$output .= '</div>';