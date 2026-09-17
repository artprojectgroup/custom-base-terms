<?php
/*
Plugin Name: Custom Base Terms
Version: 1.1.1
Plugin URI: https://wordpress.org/plugins/custom-base-terms/
Description: With Custom Base Terms you can create a custom structures for URLs in author, search, comments and page. Created from <a href="https://profiles.wordpress.org/jfarthing84/" target="_blank">Jeff Farthing</a> <a href="https://wordpress.org/plugins/custom-author-base/" target="_blank"><strong>Custom Author Base</strong></a> plugin.
Author: Art Project Group
Author URI: https://artprojectgroup.es/
License: GNU General Public License v3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Requires at least: 5.0
Requires PHP: 7.4
Tested up to: 7.2

Text Domain: custom-base-terms
Domain Path: /languages

@package Custom Base Terms
@category Core
@author Art Project Group
*/

//Igual no deberías poder abrirme
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

//Definimos constantes
define( 'CUSTOM_BASE_TERMS_DIRECCION', plugin_basename( __FILE__ ) );
define( 'CUSTOM_BASE_TERMS_VERSION', '1.1.1' );

//Definimos las variables
$custom_base_terms = array( 	
	'plugin'		=> 'Custom Base Terms', 
	'plugin_uri'	=> 'custom-base-terms', 
	'donacion' 		=> 'https://artprojectgroup.es/tienda/donacion',
	'soporte' 		=> 'https://artprojectgroup.es/tienda/soporte-tecnico',
	'plugin_url' 	=> 'https://artprojectgroup.es/plugins-para-wordpress/custom-base-terms', 
	'ajustes'		=> 'options-permalink.php', 
	'puntuacion' 	=> 'https://wordpress.org/support/view/plugin-reviews/custom-base-terms'
);

//Array con los datos de los campos que vamos a añadir. El valor es la base que WordPress usa por defecto.
$custom_base_terms_bases = array(
	'author_base'		=> 'author', 
	'search_base'		=> 'search', 
	'comments_base'		=> 'comments', 
	'pagination_base'	=> 'page', 
	'feed_base'			=> 'feed'
);

//Sin load_plugin_textdomain(): WordPress carga solo las traducciones de los plugins alojados en WordPress.org desde la versión 4.6.

//Enlaces adicionales personalizados
function custom_base_terms_enlaces( $enlaces, $archivo ) {
	global $custom_base_terms;

	if ( $archivo === CUSTOM_BASE_TERMS_DIRECCION ) {
		$enlaces[] = '<a href="' . esc_url( $custom_base_terms['donacion'] ) . '" target="_blank" title="' . esc_attr( __( 'Make a donation by ', 'custom-base-terms' ) . 'APG' ) . '"><span class="genericon genericon-cart"></span></a>';
		$enlaces[] = '<a href="'. esc_url( $custom_base_terms['plugin_url'] ) . '" target="_blank" title="' . esc_attr( $custom_base_terms['plugin'] ) . '"><strong class="artprojectgroup">APG</strong></a>';
		$enlaces[] = '<a href="https://www.facebook.com/artprojectgroup" title="' . esc_attr( __( 'Follow us on ', 'custom-base-terms' ) . 'Facebook' ) . '" target="_blank"><span class="genericon genericon-facebook-alt"></span></a> <a href="https://twitter.com/artprojectgroup" title="' . esc_attr( __( 'Follow us on ', 'custom-base-terms' ) . 'Twitter' ) . '" target="_blank"><span class="genericon genericon-twitter"></span></a> <a href="https://es.linkedin.com/in/artprojectgroup" title="' . esc_attr( __( 'Follow us on ', 'custom-base-terms' ) . 'LinkedIn' ) . '" target="_blank"><span class="genericon genericon-linkedin"></span></a>';
		$enlaces[] = '<a href="https://profiles.wordpress.org/artprojectgroup/" title="' . esc_attr( __( 'More plugins on ', 'custom-base-terms' ) . 'WordPress' ) . '" target="_blank"><span class="genericon genericon-wordpress"></span></a>';
		$enlaces[] = '<a href="mailto:info@artprojectgroup.es" title="' . esc_attr( __( 'Contact us by ', 'custom-base-terms' ) . 'e-mail' ) . '"><span class="genericon genericon-mail"></span></a> <a href="skype:artprojectgroup" title="' . esc_attr( __( 'Contact us by ', 'custom-base-terms' ) . 'Skype' ) . '"><span class="genericon genericon-skype"></span></a>';
		$enlaces[] = custom_base_terms_obtiene_estrellas( $custom_base_terms['plugin_uri'] );
	}
	
	return $enlaces;
}
add_filter( 'plugin_row_meta', 'custom_base_terms_enlaces', 10, 2 );

//Añade el botón de configuración
function custom_base_terms_enlace_de_ajustes( $enlaces ) { 
	global $custom_base_terms;

	$enlaces_de_ajustes = array(
		'<a href="' . esc_url( admin_url( $custom_base_terms['ajustes'] ) ) . '" title="' . esc_attr( __( 'Settings of ', 'custom-base-terms' ) . $custom_base_terms['plugin'] ) . '">' . esc_html__( 'Settings', 'custom-base-terms' ) . '</a>', 
		'<a href="' . esc_url( $custom_base_terms['soporte'] ) . '" target="_blank" title="' . esc_attr( __( 'Support of ', 'custom-base-terms' ) . $custom_base_terms['plugin'] ) . '">' . esc_html__( 'Support', 'custom-base-terms' ) . '</a>'
	);
	foreach( $enlaces_de_ajustes as $enlace_de_ajustes )	{
		array_unshift( $enlaces, $enlace_de_ajustes );
	}
	
	return $enlaces; 
}
add_filter( 'plugin_action_links_' . CUSTOM_BASE_TERMS_DIRECCION, 'custom_base_terms_enlace_de_ajustes' );

//Inicializamos el plugin
function custom_base_terms_inicio() {
	global $wp_rewrite, $custom_base_terms_bases;

	if ( empty( $custom_base_terms_bases ) || ! $wp_rewrite instanceof WP_Rewrite ) {
		return;
	}

	foreach ( $custom_base_terms_bases as $base => $nombre ) {
		//Sin esc_attr(): este valor alimenta las reglas de reescritura, no una salida HTML, y escaparlo aquí corrompe la base.
		$custom_base		= get_option( $base );
		$wp_rewrite->$base	= empty( $custom_base ) ? $wp_rewrite->$base : $custom_base;
	}
}
add_action( 'init', 'custom_base_terms_inicio' );

//Añadimos los campos a la página de Enlaces permanentes
function custom_base_terms_enlaces_permanentes() {
	global $custom_base_terms_bases;

	/* El hook load-options-permalink.php se dispara en wp-admin/admin.php, antes de que options-permalink.php
	compruebe la capacidad y el nonce, así que hay que verificar ambos aquí o cualquier usuario identificado
	podría reescribir las bases de enlaces permanentes del sitio. */
	if ( ! isset( $_POST['_wpnonce'] ) ) {
		add_settings_section( 'custom_base_terms-permalink', __( 'Custom Base Terms', 'custom-base-terms' ), 'custom_base_terms_seccion', 'permalink' );

		return;
	}

	$nonce = sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) );

	if ( wp_verify_nonce( $nonce, 'update-permalink' ) && current_user_can( 'manage_options' ) ) {
		foreach ( $custom_base_terms_bases as $base => $nombre ) {
			if ( ! isset( $_POST[ $base ] ) ) {
				continue;
			}

			$custom_base = sanitize_text_field( wp_unslash( $_POST[ $base ] ) );
			if ( '' !== $custom_base ) {
				$custom_base = preg_replace( '#/+#', '/', '/' . $custom_base );
			}

			custom_base_terms_carga_base( $custom_base, $base, $nombre );
		}
	}

	add_settings_section( 'custom_base_terms-permalink', __( 'Custom Base Terms', 'custom-base-terms' ), 'custom_base_terms_seccion', 'permalink' );
}
add_action( 'load-options-permalink.php', 'custom_base_terms_enlaces_permanentes' );

//Añadimos la nueva sección
function custom_base_terms_seccion() {
	global $custom_base_terms_bases, $wp_rewrite, $custom_base_terms;

	echo wp_kses_post( wpautop( __( 'These settings added by <strong class="artprojectgroup">APG</strong> control the WordPress base permalinks used for author, search, comments, pagination and feed pages.', 'custom-base-terms' ) ) );
	include( plugin_dir_path( __FILE__ ) . 'includes/cuadro-informacion.php' );
?>
<div class="cabecera"> <a href="<?php echo esc_url( $custom_base_terms['plugin_url'] ); ?>" title="<?php echo esc_attr( $custom_base_terms['plugin'] ); ?>" target="_blank"><img src="<?php echo esc_url( plugins_url( 'assets/images/cabecera.jpg', __FILE__ ) ); ?>" class="imagen" alt="<?php echo esc_attr( $custom_base_terms['plugin'] ); ?>" /></a> </div>
<table class="form-table apg-table">
	<tbody>
<?php
	//Array con las etiquetas y descripciones de los campos que vamos a añadir
	$texto_bases = array(
		'author_base' 		=> array(
			'etiqueta'		=> __( 'Author base', 'custom-base-terms' ),
			'descripcion'	=> __( 'Base for the author permalink structure (example.com/author/authorname).', 'custom-base-terms' )
		),
		'search_base' 		=> array(
			'etiqueta'		=> __( 'Search base', 'custom-base-terms' ),
			'descripcion'	=> __( 'Base of the search permalink structure (example.com/search/query).', 'custom-base-terms' )
		),
		'comments_base'		=> array(
			'etiqueta'		=> __( 'Comments base', 'custom-base-terms' ),
			'descripcion'	=> __( 'Comments permalink base.', 'custom-base-terms' )
		),
		'pagination_base'	=> array(
			'etiqueta'		=> __( 'Pagination base', 'custom-base-terms' ),
			'descripcion'	=> __( 'Pagination permalink base.', 'custom-base-terms' )
		),
		'feed_base'			=> array(
			'etiqueta'		=> __( 'Feed base', 'custom-base-terms' ),
			'descripcion'	=> __( 'Feed permalink base.', 'custom-base-terms' )
		)
	);

	foreach ( $custom_base_terms_bases as $base => $nombre ) {
		if ( ! isset( $texto_bases[ $base ] ) ) {
			continue;
		}
		?>
		<tr>
			<th><label for="<?php echo esc_attr( $base ); ?>"><?php echo esc_html( $texto_bases[ $base ]['etiqueta'] ); ?></label></th>
			<td><input name="<?php echo esc_attr( $base ); ?>" id="<?php echo esc_attr( $base ); ?>" type="text" value="<?php echo esc_attr( get_option( $base ) ); ?>" class="regular-text code apg" placeholder="<?php echo esc_attr( $wp_rewrite->$base ); ?>" /> <span class="description"><?php echo esc_html( $texto_bases[ $base ]['descripcion'] ); ?></span></td>
		</tr>
		<?php
	}
?>
	</tbody>
</table>
<?php
}

//Guarda los nuevos términos utilizados
function custom_base_terms_carga_base( $custom_base, $base, $nombre ) {
	global $wp_rewrite;

	if ( $custom_base !== $wp_rewrite->$base ) {
		update_option( $base, $custom_base );
		$wp_rewrite->init();
		//Si se vacía el campo, se vuelve a la base que WordPress usa por defecto para ese término.
		$wp_rewrite->$base = empty( $custom_base ) ? $nombre : $custom_base;
	}
}

//Ejecuta las modificaciones realizadas
add_filter( 'option_author_base', '_wp_filter_taxonomy_base' );
add_filter( 'option_search_base', '_wp_filter_taxonomy_base' );
add_filter( 'option_comments_base', '_wp_filter_taxonomy_base' );
add_filter( 'option_pagination_base', '_wp_filter_taxonomy_base' );
add_filter( 'option_feed_base', '_wp_filter_taxonomy_base' );

//Obtiene la puntuación del plugin desde WordPress.org
function custom_base_terms_puntuacion( $nombre ) {
	$plugin = get_transient( 'custom_base_terms_plugin' );

	if ( ! is_array( $plugin ) ) {
		/* La API 1.2 devuelve JSON. La 1.0 devolvía un objeto serializado y pasar una respuesta remota por
		unserialize() abre la puerta a la inyección de objetos PHP. */
		$respuesta = wp_remote_get( add_query_arg( array( 
			'action'		=> 'plugin_information', 
			'request[slug]'	=> $nombre 
		), 'https://api.wordpress.org/plugins/info/1.2/' ), array( 
			'timeout' => 15 
		) );

		$plugin = array();
		if ( ! is_wp_error( $respuesta ) && 200 === wp_remote_retrieve_response_code( $respuesta ) ) {
			$datos = json_decode( wp_remote_retrieve_body( $respuesta ), true );

			if ( is_array( $datos ) && isset( $datos['rating'] ) ) {
				$plugin = array( 
					'rating'		=> ( float ) $datos['rating'], 
					'num_ratings'	=> isset( $datos['num_ratings'] ) ? ( int ) $datos['num_ratings'] : 0 
				);
				//Sólo se cachea una respuesta válida, para no arrastrar un fallo de la API durante 24 horas.
				set_transient( 'custom_base_terms_plugin', $plugin, DAY_IN_SECONDS );
			}
		}
	}

	if ( empty( $plugin ) ) {
		$plugin = array( 
			'rating'		=> 100, 
			'num_ratings'	=> 0 
		);
	}

	return $plugin;
}

//Devuelve el enlace con las estrellas de puntuación
function custom_base_terms_obtiene_estrellas( $nombre ) {
	global $custom_base_terms;

	if ( ! function_exists( 'wp_star_rating' ) ) {
		require_once ABSPATH . 'wp-admin/includes/template.php';
	}

	$plugin		= custom_base_terms_puntuacion( $nombre );
	$estrellas	= wp_star_rating( array( 
		'rating'	=> $plugin['rating'], 
		'type'		=> 'percent', 
		'number'	=> $plugin['num_ratings'], 
		'echo'		=> false 
	) );

	/* translators: %s: Plugin name. */
	return '<a title="' . esc_attr( sprintf( __( 'Please, rate %s:', 'custom-base-terms' ), $custom_base_terms['plugin'] ) ) . '" href="' . esc_url( $custom_base_terms['puntuacion'] . '?rate=5#postform' ) . '" class="estrellas">' . $estrellas . '</a>';
}

//Muestra el enlace con las estrellas de puntuación
function custom_base_terms_estrellas( $nombre ) {
	echo wp_kses_post( custom_base_terms_obtiene_estrellas( $nombre ) );
}

//Hoja de estilo
function custom_base_terms_estilo( $hook ) {
	//Sólo en las dos pantallas donde el plugin pinta algo, para no cargarla en todo el escritorio.
	if ( ! in_array( $hook, array( 'options-permalink.php', 'plugins.php' ), true ) ) {
		return;
	}

	wp_enqueue_style( 'custom_base_terms_hoja_de_estilo', plugins_url( 'assets/css/style.css', __FILE__ ), array(), CUSTOM_BASE_TERMS_VERSION ); //Carga la hoja de estilo
}
add_action( 'admin_enqueue_scripts', 'custom_base_terms_estilo' );

//Eliminamos todo rastro del plugin al desinstalarlo
function custom_base_terms_desinstalar() {
	//Sin global: al desinstalar no hay garantía de que las variables del ámbito global estén cargadas.
	$custom_base_terms_bases = array( 'author_base', 'search_base', 'comments_base', 'pagination_base', 'feed_base' );

	delete_transient( 'custom_base_terms_plugin' );
	delete_option( 'custom-base-terms' );
	foreach ( $custom_base_terms_bases as $base ) {
		delete_option( $base );
	}
}
register_uninstall_hook( __FILE__, 'custom_base_terms_desinstalar' );
