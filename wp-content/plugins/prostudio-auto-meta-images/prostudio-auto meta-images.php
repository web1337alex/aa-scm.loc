<?php
 /*
 * Plugin Name: Prostudio Auto Meta Images
 * Description: Автоматическое добавление Alt и Title для изображений при использовании загрузчика WordPress. Легкий код и правильное заполнение метатегов изображений с точки зрения SEO. 
 * Version: 1.0
 * Author: Prostudio
 * Author URI: https://prostudio.ru
 * License: GPLv2 or later
 */

# Automatically sets the image Title, Alt-Text, Caption & Description upon upload
add_action('add_attachment', 'pami_set_image_meta_upon_upload');

# Helper function
if (!function_exists('pami_image_meta_first')) {
	
	function pami_image_meta_first($my_image_title, $encoding = 'UTF-8') {
		
		$my_image_title = mb_ereg_replace('^[\ ]+', '', $my_image_title);
		$my_image_title = mb_strtoupper(mb_substr($my_image_title, 0, 1, $encoding), $encoding). mb_substr($my_image_title, 1, mb_strlen($my_image_title), $encoding);
		
		return $my_image_title;
		
	}
	
}

# Main function
function pami_set_image_meta_upon_upload($post_ID) {

	if (!wp_attachment_is_image($post_ID)) return;
		
	$my_image_title = get_post($post_ID)->post_title;
		
	// Sanitize the title: remove hyphens, underscores & extra spaces:
	$my_image_title = preg_replace('%\s*[-_\s]+\s*%', ' ', $my_image_title);
	
	// Sanitize the title: capitalize first letter of every word (other letters lower case):
	$my_image_title = str_replace('"', '', $my_image_title);
	$my_image_title = str_replace('«', '', $my_image_title);
	$my_image_title = str_replace('»', '', $my_image_title);
	$my_image_title = str_replace('—', '', $my_image_title);
	$my_image_title = str_replace(':', '', $my_image_title);
	$my_image_title = str_replace('  ', ' ', $my_image_title);
	$my_image_title = str_replace('   ', ' ', $my_image_title);

	$my_image_title = pami_image_meta_first(mb_strtolower($my_image_title));

	// Set the image Alt-Text
	update_post_meta($post_ID, '_wp_attachment_image_alt', $my_image_title);

	$my_image_title = mb_strtolower($my_image_title);

	$my_image_meta = [
		'ID' => $post_ID,
		'post_title' => 'Изображение — ' . $my_image_title, // Set image Title to sanitized title
	]; 

	// Set the image meta (e.g. Title, Excerpt, Content)
	wp_update_post($my_image_meta);
	
}