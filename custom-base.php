<?php
/*
Plugin Name: Custom Base Terms
Version: 0.3
Plugin URI: http://wordpress.org/plugins/custom-base-terms/
Description: With Custom Base Terms you can create a custom structures for URLs in author, search, comments and page. Created from <a href="http://profiles.wordpress.org/jfarthing84/" target="_blank">Jeff Farthing</a> <a href="http://wordpress.org/plugins/custom-author-base/" target="_blank"><strong>Custom Author Base</strong></a> plugin.
Author: Art Project Group
Author URI: http://www.artprojectgroup.es/

Text Domain: custom_base_terms
Domain Path: /lang
License: GPL2
*/

/*  Copyright 2013  artprojectgroup  (email : info@artprojectgroup.es)

    This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//Carga el idioma
load_plugin_textdomain('custom_base_terms', null, dirname(plugin_basename(__FILE__)) . '/lang');

//Enlaces adicionales personalizados
function custom_base_terms_enlaces($enlaces, $archivo) {
	$plugin = plugin_basename(__FILE__);

	if ($archivo == $plugin) 
	{
		$enlaces[] = '<a href="http://www.artprojectgroup.es/plugins-para-wordpress/custom-base-terms" target="_blank" title="Art Project Group">' . __('Visit the official plugin website', 'custom_base_terms') . '</a>';
		$enlaces[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=EWFS5SMZ5UYU4" target="_blank" title="PayPal"><img alt="Custom Base Terms" src="' . __('https://www.paypalobjects.com/en_GB/i/btn/btn_donate_LG.gif', 'custom_base_terms') . '" width="53" height="15" style="vertical-align:text-bottom;"></a>';
	}
		
	return $enlaces;
}
add_filter('plugin_row_meta', 'custom_base_terms_enlaces', 10, 2);

// Initializes the plugin
$bases = array('author_base' => 'author', 'search_base' => 'search', 'comments_base' => 'comments', 'pagination_base' => 'page');

function cbt_init() {
	global $wp_rewrite, $bases;

	foreach($bases as $base => $nombre)
	{
		$custom_base = get_option($base);
		$wp_rewrite->$base = empty($custom_base) ? mb_strtolower(__(ucfirst($nombre))) : $custom_base;
	}
}
add_action('init', 'cbt_init');

// Adds base terms fields to permalink settings page
function cbt_load_options_permalink() {
	global $bases;

	foreach($bases as $base => $nombre)
	{
		if (isset($_POST[$base])) {
			$custom_base = $_POST[$base];
			if (!empty($custom_base)) $custom_base = preg_replace('#/+#', '/', '/' . $custom_base);
			cbt_set_base($custom_base, $base, $nombre);
		}

		add_settings_field($base, __(ucfirst($nombre)) . ' base', 'cbt_settings_field', 'permalink', 'optional', array('label_for' => $base));
	}
}
add_action('load-options-permalink.php', 'cbt_load_options_permalink');

// Displays base terms settings field
function cbt_settings_field($campo) {
	$campo = $campo['label_for'];
	echo '<input name="'.$campo.'" id="'.$campo.'" type="text" value="' . esc_attr(get_option($campo)) . '" class="regular-text code" />';
}

// Set the base for the terms permalink
function cbt_set_base ($custom_base, $base, $nombre) {
	global $wp_rewrite;

	if ($custom_base != $wp_rewrite->$base) 
	{
		update_option($base, $custom_base);
		$wp_rewrite->init();
		$wp_rewrite->$base = empty($custom_base) ? mb_strtolower(__(ucfirst($nombre))) : $custom_base;
	}
}

// Filter the base terms
add_filter('option_author_base', '_wp_filter_taxonomy_base');
add_filter('option_search_base', '_wp_filter_taxonomy_base');
add_filter('option_comments_base', '_wp_filter_taxonomy_base');
add_filter('option_pagination_base', '_wp_filter_taxonomy_base');
?>