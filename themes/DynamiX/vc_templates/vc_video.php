<?php
$output = $title = $link = $size = $el_class = $video_types = $embed = '';
extract( shortcode_atts( array(
	'title' => '',
	'link' => 'http://vimeo.com/92033601',
	'el_class' => '',
	'style' => '',
	'width' => '',
	'autoplay' => '',
	'type' => 'oembed',
	'ratio' => 'sixteen_by_nine',
	'css' => ''

), $atts ) );

if ( $link == '' ) {
	return null;
}
$el_class = $this->getExtraClass( $el_class );

$acoda_videotype = $type;
$acoda_movieurl = $link;
$acoda_videoautoplay = $autoplay;

include(get_template_directory() .'/lib/inc/classes/video-class.php');

$embed = $output;

$output = '';

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_video_widget wpb_content_element' . $el_class .' '. $style . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

$output .= "\n\t" . '<div class="' . esc_attr( $css_class ) .'">';
$output .= "\n\t\t" . '<div class="wpb_wrapper">';
$output .=  esc_html( wpb_widget_title( array( 'title' => $title, 'extraclass' => 'wpb_video_heading' ) ) );
$output .= '<div class="wpb_video_wrapper '. esc_attr( $ratio ) .'">'. $embed .'</div>'; // $embed escaped in video-class.php 
$output .= "\n\t\t" . '</div>';
$output .= "\n\t" . '</div>';

echo $output;