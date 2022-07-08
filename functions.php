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
require_once( get_template_directory() . '/inc/taxonomies.php' );
new Photlab_Taxonomies();



function enq_photolab_scripts() {
    wp_enqueue_style( "photolab-frontend-CSS", get_template_directory_uri() . '/static/frontend-style.css', array(), "1.0", "all" );
}
add_action('wp_enqueue_scripts', 'enq_photolab_scripts');


?>
