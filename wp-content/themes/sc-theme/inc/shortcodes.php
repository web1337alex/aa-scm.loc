<?php
	
	global $CoreTheme;

	add_shortcode('current_year', 'current_year_shortcode');
	function current_year_shortcode($atts){
		return date("Y");
	}

	add_shortcode('footer_link', 'footer_link_shortcode');
	function footer_link_shortcode($atts){
		global $CoreTheme;
		return '<a href="'.$CoreTheme::$settings['footer_link']['url'].'" target='.$CoreTheme::$settings['footer_link']['target'].'">'.$CoreTheme::$settings['footer_link']['title'].'</a>';
	}

	add_shortcode('wp_title', 'wp_title_shortcode');
	function wp_title_shortcode(){
		return get_the_title();
	}

	add_shortcode('wp_content', 'wp_content_shortcode');
	function wp_content_shortcode(){
		return get_the_content();
	}

	add_shortcode('sc_form', ['CoreTheme', 'formConstruct'])

?>