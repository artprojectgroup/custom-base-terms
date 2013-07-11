<?php
/*
Plugin Name: Custom Base Terms
Version: 0.1
Plugin URI: http://www.artprojectgroup.com/custom-base-terms
Description: Adds fields to the Permalink Settings page to change the author, search, pagination and comments permalink base. Created from <a href="http://wordpress.org/plugins/custom-author-base/">Jeff Farthing</a> <strong>Custom Author Base</strong>
Author: Art Project Group
Author URI: http://www.artprojectgroup.com/
*/

/**
 * Initializes the plugin
 */

$bases = array('author_base' => 'author', 'search_base' => 'search', 'comments_base' => 'comments', 'pagination_base' => 'page');

function cbt_init() {
	global $wp_rewrite, $bases;

	foreach($bases as $base => $nombre)
	{
		$custom_base = get_option( $base );
		$wp_rewrite->$base = empty( $custom_base ) ? mb_strtolower( __( ucfirst($nombre) ) ) : $custom_base;
	}
}
add_action( 'init', 'cbt_init' );

/**
 * Adds base terms fields to permalink settings page
 */
function cbt_load_options_permalink() {
	global $bases;

	foreach($bases as $base => $nombre)
	{
		if ( isset( $_POST[$base] ) ) {
			$custom_base = $_POST[$base];
			if ( !empty( $custom_base ) )
				$custom_base = preg_replace( '#/+#', '/', '/' . $custom_base );
			cbt_set_base( $custom_base, $base, $nombre );
		}

		add_settings_field( $base, __( ucfirst($nombre) ) . ' base', 'cbt_settings_field',
			'permalink', 'optional', array( 'label_for' => $base ) );
	}
}
add_action( 'load-options-permalink.php', 'cbt_load_options_permalink' );

/**
 * Displays base terms settings field
 */
function cbt_settings_field($campo) {
	$campo = $campo['label_for'];
	echo '<input name="'.$campo.'" id="'.$campo.'" type="text" value="' . esc_attr( get_option( $campo ) ) . '" class="regular-text code" />';
}

/**
 * Set the base for the terms permalink
 */
function cbt_set_base ( $custom_base, $base, $nombre ) {
	global $wp_rewrite;

	if ( $custom_base != $wp_rewrite->$base ) {
		update_option( $base, $custom_base );
		$wp_rewrite->init();
		$wp_rewrite->$base = empty( $custom_base ) ? mb_strtolower( __( ucfirst($nombre) ) ) : $custom_base;
	}
}

// Filter the base terms
add_filter( 'option_author_base', '_wp_filter_taxonomy_base' );
add_filter( 'option_search_base', '_wp_filter_taxonomy_base' );
add_filter( 'option_comments_base', '_wp_filter_taxonomy_base' );
add_filter( 'option_pagination_base', '_wp_filter_taxonomy_base' );

?>