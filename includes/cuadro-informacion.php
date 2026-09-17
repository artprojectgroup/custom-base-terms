<?php
//Igual no deberías poder abrirme
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

//Se incluye desde custom_base_terms_seccion(), que ya tiene $custom_base_terms en su ámbito.
global $custom_base_terms;
?>
<div class="informacion">
  <div class="fila">
    <div class="columna">
      <p>
        <?php esc_html_e( 'If you enjoy this plugin and find it helpful, please make a donation:', 'custom-base-terms' ); ?>
      </p>
      <p><a href="<?php echo esc_url( $custom_base_terms['donacion'] ); ?>" target="_blank" title="<?php echo esc_attr( __( 'Make a donation by ', 'custom-base-terms' ) . 'APG' ); ?>"><span class="genericon genericon-cart"></span></a></p>
    </div>
    <div class="columna">
      <p>Art Project Group:</p>
      <p><a href="https://www.artprojectgroup.es" title="Art Project Group" target="_blank"><strong class="artprojectgroup">APG</strong></a></p>
    </div>
  </div>
  <div class="fila">
    <div class="columna">
      <p>
        <?php esc_html_e( 'Follow us:', 'custom-base-terms' ); ?>
      </p>
      <p><a href="https://www.facebook.com/artprojectgroup" title="<?php echo esc_attr( __( 'Follow us on ', 'custom-base-terms' ) . 'Facebook' ); ?>" target="_blank"><span class="genericon genericon-facebook-alt"></span></a> <a href="https://twitter.com/artprojectgroup" title="<?php echo esc_attr( __( 'Follow us on ', 'custom-base-terms' ) . 'Twitter' ); ?>" target="_blank"><span class="genericon genericon-twitter"></span></a> <a href="https://es.linkedin.com/in/artprojectgroup" title="<?php echo esc_attr( __( 'Follow us on ', 'custom-base-terms' ) . 'LinkedIn' ); ?>" target="_blank"><span class="genericon genericon-linkedin"></span></a></p>
    </div>
    <div class="columna">
      <p>
        <?php esc_html_e( 'More plugins:', 'custom-base-terms' ); ?>
      </p>
      <p><a href="https://profiles.wordpress.org/artprojectgroup/" title="<?php echo esc_attr( __( 'More plugins on ', 'custom-base-terms' ) . 'WordPress' ); ?>" target="_blank"><span class="genericon genericon-wordpress"></span></a></p>
    </div>
  </div>
  <div class="fila">
    <div class="columna">
      <p>
        <?php esc_html_e( 'Contact us:', 'custom-base-terms' ); ?>
      </p>
      <p><a href="mailto:info@artprojectgroup.es" title="<?php echo esc_attr( __( 'Contact us by ', 'custom-base-terms' ) . 'e-mail' ); ?>"><span class="genericon genericon-mail"></span></a> <a href="skype:artprojectgroup" title="<?php echo esc_attr( __( 'Contact us by ', 'custom-base-terms' ) . 'Skype' ); ?>"><span class="genericon genericon-skype"></span></a></p>
    </div>
    <div class="columna">
      <p>
        <?php esc_html_e( 'Documentation and Support:', 'custom-base-terms' ); ?>
      </p>
      <p><a href="<?php echo esc_url( $custom_base_terms['plugin_url'] ); ?>" title="<?php echo esc_attr( $custom_base_terms['plugin'] ); ?>" target="_blank"><span class="genericon genericon-book"></span></a> <a href="<?php echo esc_url( $custom_base_terms['soporte'] ); ?>" title="<?php esc_attr_e( 'Support', 'custom-base-terms' ); ?>" target="_blank"><span class="genericon genericon-cog"></span></a></p>
    </div>
  </div>
  <div class="fila final">
    <div class="columna">
      <?php /* translators: %s: Plugin name. */ ?>
      <p> <?php echo esc_html( sprintf( __( 'Please, rate %s:', 'custom-base-terms' ), $custom_base_terms['plugin'] ) ); ?> </p>
      <?php custom_base_terms_estrellas( $custom_base_terms['plugin_uri'] ); ?> </div>
    <div class="columna final"></div>
  </div>
</div>
