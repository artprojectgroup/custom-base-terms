<?php
/*
Plugin Name: Custom Base Terms
Version: 1.0
Plugin URI: http://wordpress.org/plugins/custom-base-terms/
Description: With Custom Base Terms you can create a custom structures for URLs in author, search, comments and page. Created from <a href="http://profiles.wordpress.org/jfarthing84/" target="_blank">Jeff Farthing</a> <a href="http://wordpress.org/plugins/custom-author-base/" target="_blank"><strong>Custom Author Base</strong></a> plugin.
Author: Art Project Group
Author URI: http://www.artprojectgroup.es/
Requires at least: 2.7
Tested up to: 4.3

Text Domain: custom_base_terms
Domain Path: /i18n/languages

@package Custom Base Terms
@category Core
@author Art Project Group
*/

//Igual no deberías poder abrirme
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

//Definimos constantes
define( 'DIRECCION_custom_base_terms', plugin_basename( __FILE__ ) );

//Definimos las variables
$custom_base_terms = array( 	
	'plugin'			=> 'Custom Base Terms', 
	'plugin_uri'		=> 'custom-base-terms', 
	'donacion' 		=> 'http://www.artprojectgroup.es/tienda/donacion',
	'soporte' 		=> 'http://www.artprojectgroup.es/tienda/soporte-tecnico',
	'plugin_url' 	=> 'http://www.artprojectgroup.es/plugins-para-wordpress/custom-base-terms', 
	'ajustes'		=> 'options-permalink.php', 
	'puntuacion' 	=> 'http://wordpress.org/support/view/plugin-reviews/custom-base-terms'
);

//Carga el idioma
load_plugin_textdomain( 'custom_base_terms', null, dirname( DIRECCION_custom_base_terms ) . '/i18n/languages' );

//Enlaces adicionales personalizados
function custom_base_terms_enlaces( $enlaces, $archivo ) {
	global $custom_base_terms;

	if ( $archivo == DIRECCION_custom_base_terms ) {
		$enlaces[] = '<a href="' . $custom_base_terms['donacion'] . '" target="_blank" title="' . __( 'Make a donation by ', 'custom_base_terms' ) . 'APG"><span class="genericon genericon-cart"></span></a>';
		$enlaces[] = '<a href="'. $custom_base_terms['plugin_url'] . '" target="_blank" title="' . $custom_base_terms['plugin'] . '"><strong class="artprojectgroup">APG</strong></a>';
		$enlaces[] = '<a href="https://www.facebook.com/artprojectgroup" title="' . __( 'Follow us on ', 'custom_base_terms' ) . 'Facebook" target="_blank"><span class="genericon genericon-facebook-alt"></span></a> <a href="https://twitter.com/artprojectgroup" title="' . __( 'Follow us on ', 'custom_base_terms' ) . 'Twitter" target="_blank"><span class="genericon genericon-twitter"></span></a> <a href="https://plus.google.com/+ArtProjectGroupES" title="' . __( 'Follow us on ', 'custom_base_terms' ) . 'Google+" target="_blank"><span class="genericon genericon-googleplus-alt"></span></a> <a href="http://es.linkedin.com/in/artprojectgroup" title="' . __( 'Follow us on ', 'custom_base_terms' ) . 'LinkedIn" target="_blank"><span class="genericon genericon-linkedin"></span></a>';
		$enlaces[] = '<a href="http://profiles.wordpress.org/artprojectgroup/" title="' . __( 'More plugins on ', 'custom_base_terms' ) . 'WordPress" target="_blank"><span class="genericon genericon-wordpress"></span></a>';
		$enlaces[] = '<a href="mailto:info@artprojectgroup.es" title="' . __( 'Contact with us by ', 'custom_base_terms' ) . 'e-mail"><span class="genericon genericon-mail"></span></a> <a href="skype:artprojectgroup" title="' . __( 'Contact with us by ', 'custom_base_terms' ) . 'Skype"><span class="genericon genericon-skype"></span></a>';
		$enlaces[] = custom_base_terms_plugin( $custom_base_terms['plugin_uri'] );
	}
	
	return $enlaces;
}
add_filter( 'plugin_row_meta', 'custom_base_terms_enlaces', 10, 2 );

//Añade el botón de configuración
function custom_base_terms_enlace_de_ajustes( $enlaces ) { 
	global $custom_base_terms;

	$enlaces_de_ajustes = array(
		'<a href="' . $custom_base_terms['ajustes'] . '" title="' . __( 'Settings of ', 'custom_base_terms' ) . $custom_base_terms['plugin'] .'">' . __( 'Settings', 'custom_base_terms' ) . '</a>', 
		'<a href="' . $custom_base_terms['soporte'] . '" title="' . __( 'Support of ', 'custom_base_terms' ) . $custom_base_terms['plugin'] .'">' . __( 'Support', 'apg_shipping' ) . '</a>'
	);
	foreach( $enlaces_de_ajustes as $enlace_de_ajustes )	{
		array_unshift( $enlaces, $enlace_de_ajustes );
	}
	
	return $enlaces; 
}
$plugin = DIRECCION_custom_base_terms; 
add_filter( "plugin_action_links_$plugin", 'custom_base_terms_enlace_de_ajustes' );

//Inicializamos el plugin
$bases = array(	//Array con los datos de los campos que vamos a añadir
	'author_base'		=> 'author', 
	'search_base'		=> 'search', 
	'comments_base'		=> 'comments', 
	'pagination_base'	=> 'page', 
	'feed_base'			=> 'feed'
);
$custom_slugs = array();

function custom_base_terms_inicio() {
	global $wp_rewrite, $bases, $custom_slugs;

	foreach ( $bases as $base => $nombre ) {
		$custom_base		= get_option( $base );
		$wp_rewrite->$base	= empty( $custom_base ) ? $wp_rewrite->$base : $custom_base;
	}
}
add_action( 'init', 'custom_base_terms_inicio' );

//Añadimos los campos a la página de Enlaces permanentes
function custom_base_terms_enlaces_permanentes() {
	global $bases;

	foreach ( $bases as $base => $nombre ) {
		if ( isset( $_POST[$base] ) ) {
			$custom_base = $_POST[$base];
			if ( !empty( $custom_base ) ) {
				$custom_base = preg_replace( '#/+#', '/', '/' . $custom_base );
			}

			custom_base_terms_carga_base( $custom_base, $base, $nombre );
		}
	}
	
	add_settings_section( 'custom_base_terms-permalink', __( 'Custom Base Terms', 'custom_base_terms' ), 'custom_base_terms_seccion', 'permalink' );
}
add_action( 'load-options-permalink.php', 'custom_base_terms_enlaces_permanentes' );

//Añadimos la nueva sección
function custom_base_terms_seccion() {
	global $bases, $wp_rewrite, $custom_base_terms, $custom_slugs;

	echo wpautop( __( 'These settings added by <strong class="artprojectgroup">APG</strong> control the WordPress base permalinks used for author, search, comments, pagination and feed pages.', 'custom_base_terms' ) );
	include('includes/cuadro-informacion.php');
?>
<table class="form-table apg-table">
	<tbody>
<?php
	$texto_bases = array(
		'author_base' 		=> __( 'Base for the author permalink structure (example.com/author/authorname).', 'custom_base_terms' ),
		'search_base' 		=> __( 'Base of the search permalink structure (example.com/search/query).', 'custom_base_terms' ),
		'comments_base'		=> __( 'Comments permalink base.', 'custom_base_terms' ),
		'pagination_base'	=> __( 'Pagination permalink base.', 'custom_base_terms' ),
		'feed_base'			=> __( 'Feed permalink base.', 'custom_base_terms' )
	); //Array con los datos de los campos que vamos a añadir

	foreach ( $bases as $base => $nombre ) {
		echo '
		<tr>
			<th><label for="'. $base . '">' . __( ucfirst( $nombre ) ) . ' base</label></th>
			<td><input name="'. $base . '" id="'. $base . '" type="text" value="' . esc_attr( get_option( $base ) ) . '" class="regular-text code apg" placeholder="' . $wp_rewrite->$base . '" /> <span class="description">' . $texto_bases[$base] . '</span></td>
		</tr>';
	}
?>
	</tbody>
</table>
<?php
}

//Guarda los nuevos términos utilizados
function custom_base_terms_carga_base( $custom_base, $base, $nombre ) {
	global $wp_rewrite;

	if ( $custom_base != $wp_rewrite->$base ) {
		update_option( $base, $custom_base );
		$wp_rewrite->init();
		$wp_rewrite->$base = empty( $custom_base ) ? mb_strtolower( __( ucfirst( $nombre ) ) ) : $custom_base;
	}
}

//Ejecuta las modificaciones realizadas
add_filter( 'option_author_base', '_wp_filter_taxonomy_base' );
add_filter( 'option_search_base', '_wp_filter_taxonomy_base' );
add_filter( 'option_comments_base', '_wp_filter_taxonomy_base' );
add_filter( 'option_pagination_base', '_wp_filter_taxonomy_base' );
add_filter( 'option_feed_base', '_wp_filter_taxonomy_base' );

//Obtiene toda la información sobre el plugin
function custom_base_terms_plugin( $nombre ) {
	global $custom_base_terms;
	
	$argumentos = ( object ) array( 
		'slug' => $nombre 
	);
	$consulta = array( 
		'action' => 'plugin_information', 
		'timeout' => 15, 
		'request' => serialize( $argumentos )
	);
	$respuesta = get_transient( 'custom_base_terms_plugin' );
	if ( false === $respuesta ) {
		$respuesta = wp_remote_post( 'http://api.wordpress.org/plugins/info/1.0/', array( 
			'body' => $consulta)
		);
		set_transient( 'custom_base_terms_plugin', $respuesta, 24 * HOUR_IN_SECONDS );
	}
	if ( !is_wp_error( $respuesta ) ) {
		$plugin = get_object_vars( unserialize( $respuesta['body'] ) );
	} else {
		$plugin['rating'] = 100;
	}

	$rating = array(
	   'rating'	=> $plugin['rating'],
	   'type'	=> 'percent',
	   'number'	=> $plugin['num_ratings'],
	);
	ob_start();
	wp_star_rating( $rating );
	$estrellas = ob_get_contents();
	ob_end_clean();

	return '<a title="' . sprintf( __( 'Please, rate %s:', 'custom_base_terms' ), $custom_base_terms['plugin'] ) . '" href="' . $custom_base_terms['puntuacion'] . '?rate=5#postform" class="estrellas">' . $estrellas . '</a>';
}

//Carga las hojas de estilo
function custom_base_terms_muestra_mensaje() {
	wp_register_style( 'custom_base_terms_hoja_de_estilo', plugins_url( 'assets/css/style.css', __FILE__ ) ); //Carga la hoja de estilo
	wp_enqueue_style( 'custom_base_terms_hoja_de_estilo' ); //Carga la hoja de estilo global
	wp_register_style( 'custom_base_terms_fuentes', plugins_url( 'assets/fonts/stylesheet.css', __FILE__ ) ); //Carga la hoja de estilo global
	wp_enqueue_style( 'custom_base_terms_fuentes' ); //Carga la hoja de estilo global
}
add_action( 'admin_init', 'custom_base_terms_muestra_mensaje' );

//Eliminamos todo rastro del plugin al desinstalarlo
function custom_base_terms_desinstalar() {
	global $bases;
	
	delete_transient( 'custom_base_terms_plugin' );
	delete_option( 'custom_base_terms' );
	foreach ( $bases as $base => $nombre ) {
		delete_option($base);
	}
}
register_uninstall_hook( __FILE__, 'custom_base_terms_desinstalar' );
?>