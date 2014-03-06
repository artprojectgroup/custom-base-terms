<?php
/*
Plugin Name: Custom Base Terms
Version: 0.7.2
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

//Definimos las variables
$custom_base_terms = array(	'plugin' => 'Custom Base Terms', 
								'plugin_uri' => 'custom-base-terms', 
								'donacion' => 'http://www.artprojectgroup.es/donacion',
								'plugin_url' => 'http://www.artprojectgroup.es/plugins-para-wordpress/custom-base-terms', 
								'ajustes' => 'options-permalink.php', 
								'puntuacion' => 'http://wordpress.org/support/view/plugin-reviews/custom-base-terms');

//Carga el idioma
load_plugin_textdomain('custom_base_terms', null, dirname(plugin_basename(__FILE__)) . '/lang');

//Enlaces adicionales personalizados
function custom_base_terms_enlaces($enlaces, $archivo) {
	global $custom_base_terms;

	$plugin = plugin_basename(__FILE__);

	if ($archivo == $plugin) 
	{
		$plugin = custom_base_terms_plugin($custom_base_terms['plugin_uri']);
		$enlaces[] = '<a href="' . $custom_base_terms['donacion'] . '" target="_blank" title="' . __('Make a donation by ', 'custom_base_terms') . 'APG"><span class="icon-bills"></span></a>';
		$enlaces[] = '<a href="'. $custom_base_terms['plugin_url'] . '" target="_blank" title="' . $custom_base_terms['plugin'] . '"><strong class="artprojectgroup">APG</strong></a>';
		$enlaces[] = '<a href="https://www.facebook.com/artprojectgroup" title="' . __('Follow us on ', 'custom_base_terms') . 'Facebook" target="_blank"><span class="icon-facebook6"></span></a> <a href="https://twitter.com/artprojectgroup" title="' . __('Follow us on ', 'custom_base_terms') . 'Twitter" target="_blank"><span class="icon-social19"></span></a> <a href="https://plus.google.com/+ArtProjectGroupES" title="' . __('Follow us on ', 'custom_base_terms') . 'Google+" target="_blank"><span class="icon-google16"></span></a> <a href="http://es.linkedin.com/in/artprojectgroup" title="' . __('Follow us on ', 'custom_base_terms') . 'LinkedIn" target="_blank"><span class="icon-logo"></span></a>';
		$enlaces[] = '<a href="http://profiles.wordpress.org/artprojectgroup/" title="' . __('More plugins on ', 'custom_base_terms') . 'WordPress" target="_blank"><span class="icon-wordpress2"></span></a>';
		$enlaces[] = '<a href="mailto:info@artprojectgroup.es" title="' . __('Contact with us by ', 'custom_base_terms') . 'e-mail"><span class="icon-open21"></span></a> <a href="skype:artprojectgroup" title="' . __('Contact with us by ', 'custom_base_terms') . 'Skype"><span class="icon-social6"></span></a>';
		$enlaces[] = '<div class="star-holder rate"><div style="width:' . esc_attr(str_replace(',', '.', $plugin['rating'])) . 'px;" class="star-rating"></div><div class="star-rate"><a title="' . __('***** Fantastic!', 'custom_base_terms') . '" href="' . $custom_base_terms['puntuacion'] . '?rate=5#postform" target="_blank"><span></span></a> <a title="' . __('**** Great', 'custom_base_terms') . '" href="' . $custom_base_terms['puntuacion'] . '?rate=4#postform" target="_blank"><span></span></a> <a title="' . __('*** Good', 'custom_base_terms') . '" href="' . $custom_base_terms['puntuacion'] . '?rate=3#postform" target="_blank"><span></span></a> <a title="' . __('** Works', 'custom_base_terms') . '" href="' . $custom_base_terms['puntuacion'] . '?rate=2#postform" target="_blank"><span></span></a> <a title="' . __('* Poor', 'custom_base_terms') . '" href="' . $custom_base_terms['puntuacion'] . '?rate=1#postform" target="_blank"><span></span></a></div></div>';
	}
	
	return $enlaces;
}
add_filter('plugin_row_meta', 'custom_base_terms_enlaces', 10, 2);

//Añade el botón de configuración
function custom_base_terms_enlace_de_ajustes($enlaces) { 
	global $custom_base_terms;

	$enlace_de_ajustes = '<a href="' . $custom_base_terms['ajustes'] . '" title="' . __('Settings of ', 'custom_base_terms') . $custom_base_terms['plugin'] . '">' . __('Settings', 'custom_base_terms') . '</a>'; 
	array_unshift($enlaces, $enlace_de_ajustes); 
	
	return $enlaces; 
}
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'custom_base_terms_enlace_de_ajustes');

//Inicializamos el plugin
$bases = array('author_base' => 'author', 'search_base' => 'search', 'comments_base' => 'comments', 'pagination_base' => 'page', 'feed_base' => 'feed'); //Array con los datos de los campos que vamos a añadir

function custom_base_terms_inicio() {
	global $wp_rewrite, $bases;

	foreach($bases as $base => $nombre)
	{
		$custom_base = get_option($base);
		$wp_rewrite->$base = empty($custom_base) ? $wp_rewrite->$base : $custom_base;
	}
}
add_action('init', 'custom_base_terms_inicio');

//Añadimos los campos a la página de Enlaces permanentes
function custom_base_terms_enlaces_permanentes() {
	global $bases, $custom_base_terms;
	
	foreach($bases as $base => $nombre)
	{
		if (isset($_POST[$base])) 
		{
			$custom_base = $_POST[$base];
			if (!empty($custom_base)) $custom_base = preg_replace('#/+#', '/', '/' . $custom_base);
			custom_base_terms_carga_base($custom_base, $base, $nombre);
		}

		add_settings_field($base, __(ucfirst($nombre)) . ' base', 'custom_base_terms_campos', 'permalink', 'optional', array('label_for' => $base));
	}
}
add_action('load-options-permalink.php', 'custom_base_terms_enlaces_permanentes');

//Pinta los campos
function custom_base_terms_campos($campo) {
	global $wp_rewrite, $custom_base_terms;

	wp_enqueue_style('custom_base_terms_hoja_de_estilo'); //Carga la hoja de estilo

	$campo = $campo['label_for'];

	$texto_bases = array('author_base' => __('Base for the author permalink structure (example.com/author/authorname).', 'custom_base_terms'), 'search_base' => __('Base of the search permalink structure (example.com/search/query).', 'custom_base_terms'), 'comments_base' => __('Comments permalink base.', 'custom_base_terms'), 'pagination_base' => __('Pagination permalink base.', 'custom_base_terms'), 'feed_base' => __('Feed permalink base.', 'custom_base_terms')); //Array con los datos de los campos que vamos a añadir

	echo '<input name="' . $campo . '" id="' . $campo . '" type="text" value="' . esc_attr(get_option($campo)) . '" class="regular-text code apg" placeholder="' . $wp_rewrite->$campo . '" /> ' . $texto_bases[$campo] . PHP_EOL;
	if ($campo == 'author_base') include('cuadro-donacion.php');	
}

//Guarda los nuevos términos utilizados
function custom_base_terms_carga_base($custom_base, $base, $nombre) {
	global $wp_rewrite;

	if ($custom_base != $wp_rewrite->$base) 
	{
		update_option($base, $custom_base);
		$wp_rewrite->init();
		$wp_rewrite->$base = empty($custom_base) ? mb_strtolower(__(ucfirst($nombre))) : $custom_base;
	}
}

//Ejecuta las modificaciones realizadas
add_filter('option_author_base', '_wp_filter_taxonomy_base');
add_filter('option_search_base', '_wp_filter_taxonomy_base');
add_filter('option_comments_base', '_wp_filter_taxonomy_base');
add_filter('option_pagination_base', '_wp_filter_taxonomy_base');
add_filter('option_feed_base', '_wp_filter_taxonomy_base');

//Obtiene toda la información sobre el plugin
function custom_base_terms_plugin($nombre) {
	$argumentos = (object) array('slug' => $nombre);
	$consulta = array('action' => 'plugin_information', 'timeout' => 15, 'request' => serialize($argumentos));
	$respuesta = get_transient('custom_base_terms_plugin');
	if (false === $respuesta) 
	{
		$respuesta = wp_remote_post('http://api.wordpress.org/plugins/info/1.0/', array('body' => $consulta));
		set_transient('custom_base_terms_plugin', $respuesta, 24 * HOUR_IN_SECONDS);
	}
	if (isset($respuesta['body'])) $plugin = get_object_vars(unserialize($respuesta['body']));
	else $plugin['rating'] = 100;
	
	return $plugin;
}

//Carga las hojas de estilo
function custom_base_terms_muestra_mensaje() {
	wp_register_style('custom_base_terms_hoja_de_estilo', plugins_url('style.css', __FILE__)); //Carga la hoja de estilo
	wp_register_style('custom_base_terms_fuentes', plugins_url('fonts/stylesheet.css', __FILE__)); //Carga la hoja de estilo global
	wp_enqueue_style('custom_base_terms_fuentes'); //Carga la hoja de estilo global
}
add_action('admin_init', 'custom_base_terms_muestra_mensaje');

//Eliminamos todo rastro del plugin al desinstalarlo
function custom_base_terms_desinstalar() {
  delete_transient('custom_base_terms_plugin');
}
register_deactivation_hook( __FILE__, 'custom_base_terms_desinstalar' );
?>