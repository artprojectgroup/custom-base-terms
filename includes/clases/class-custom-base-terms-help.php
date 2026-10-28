<?php
/**
 * Ayuda contextual de la pantalla de enlaces permanentes: un panel más en la pestaña «Ayuda»
 * nativa de WordPress, con los cinco campos que añade el plugin. La versión completa vive en la
 * web y se enlaza desde el lateral.
 *
 * @package Custom Base Terms
 */

defined( 'ABSPATH' ) || exit;

/**
 * Añade el panel de ayuda a la pantalla de enlaces permanentes.
 */
class Custom_Base_Terms_Help {

	/**
	 * Dirección de la documentación completa, en español.
	 */
	const DOCS_URL = 'https://artprojectgroup.es/documentacion/custom-base-terms';

	/**
	 * Dirección de la documentación completa, en inglés.
	 */
	const DOCS_URL_EN = 'https://artprojectgroup.com/documentation/custom-base-terms';

	/**
	 * Añade el panel del plugin a la ayuda de la pantalla.
	 *
	 * La pantalla es del núcleo y su ayuda explica los enlaces permanentes de WordPress, así que
	 * aquí no se borra nada: se añade un panel más y se amplía el lateral que ya hay.
	 *
	 * @return void
	 */
	public static function add_tabs() {
		$screen = get_current_screen();
		if ( ! $screen ) {
			return;
		}

		$screen->add_help_tab(
			array(
				'id'      => 'custom_base_terms_help',
				'title'   => __( 'Custom Base Terms', 'custom-base-terms' ),
				'content' => self::render(),
				//Los paneles del núcleo van con la prioridad predeterminada, que es 10: éste va detrás.
				'priority' => 20,
			)
		);

		$screen->set_help_sidebar(
			$screen->get_help_sidebar() .
			'<p><strong>' . esc_html__( 'Custom Base Terms', 'custom-base-terms' ) . '</strong></p>' .
			'<p><a href="' . esc_url( self::documentacion() ) . '" target="_blank">' . esc_html__( 'Full documentation', 'custom-base-terms' ) . '</a></p>'
		);
	}

	/**
	 * Dirección de la documentación en el idioma de quien lee la pantalla.
	 *
	 * @return string
	 */
	private static function documentacion() {
		return ( 0 === strpos( get_user_locale(), 'es' ) ) ? self::DOCS_URL : self::DOCS_URL_EN;
	}

	/**
	 * Pinta el panel: un párrafo de entrada, la lista de campos y una advertencia.
	 *
	 * @return string
	 */
	private static function render() {
		$items = array(
			__( 'Author base', 'custom-base-terms' )     => __( 'the word in the address of an author\'s page, example.com/author/name. Change it to autor, redactor or whatever your readers understand.', 'custom-base-terms' ),
			__( 'Search base', 'custom-base-terms' )     => __( 'the word in the address of a search, example.com/search/what-was-searched.', 'custom-base-terms' ),
			__( 'Comments base', 'custom-base-terms' )   => __( 'the word in the address of the comments pages.', 'custom-base-terms' ),
			__( 'Pagination base', 'custom-base-terms' ) => __( 'the word that numbers the pages of a listing, example.com/blog/page/2.', 'custom-base-terms' ),
			__( 'Feed base', 'custom-base-terms' )       => __( 'the word in the address of the feeds, example.com/feed.', 'custom-base-terms' ),
		);

		$html  = '<p>' . esc_html__( 'These five fields replace the words WordPress puts in its own addresses, the ones that are in English whatever language your site is in. They are the same permalinks, with your words.', 'custom-base-terms' ) . '</p>';
		$html .= '<ul>';

		foreach ( $items as $term => $text ) {
			$html .= '<li><strong>' . esc_html( $term ) . '</strong>: ' . esc_html( $text ) . '</li>';
		}

		$html .= '</ul>';
		$html .= '<p>' . esc_html__( 'Leave a field empty and that term goes back to the word WordPress uses, which is the one shown in grey inside the field. Changing any of them changes the addresses of those pages, so the old ones stop working: on a site that is already published, set up a redirect from the old word to the new one.', 'custom-base-terms' ) . '</p>';

		return $html;
	}
}
