<?php

/**
 * Handles custom product types for WooCommerce
 *
 */
 if ( is_admin() ) {
     require_once( get_template_directory() . '/inc/Photolab_Custom_WooCommerce.php' );
     new Photolab_Custom_WooCommerce();
 }


 /**
  * Handles Carbon fields and blocks
  *
  */
 require_once( get_template_directory() . '/inc/Photolab_Carbon_Fields.php' );
 new Photolab_Carbon_Fields();


/**
 * Registers custom taxonomies
 *
 */
require_once( get_template_directory() . '/inc/Photolab_Taxonomies.php' );
new Photlab_Taxonomies();


/**
 * Registers styles and scripts
 *
 */
require_once( get_template_directory() . '/inc/Photolab_Styles_Scripts.php' );
new Photolab_Styles_Scripts();


add_theme_support( 'post-thumbnails' );


/**
 * Handles woocommerce ajax handler and callback
 *
 */
require __DIR__ . '/vendor/autoload.php';
require_once( get_template_directory() . '/inc/WooCommerce_Ajax.php' );
new WooCommerce_Ajax();


/**
 * Handles woocommerce ajax handler and callback
 *
 */
require_once( get_template_directory() . '/inc/Photolab_Shortcodes.php' );
new Photolab_Shortcodes();
?>
