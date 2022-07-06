<?php

function artshop_carbon_fields() {
    require( get_template_directory() . '/inc/carbon-fields.php' );

    //Gutenberg Blocks
    require( get_template_directory() . '/inc/blocks/block-hero.php' );
    require( get_template_directory() . '/inc/blocks/block-section.php' );
}
add_action( 'carbon_fields_register_fields', 'artshop_carbon_fields' );


function crb_load() {
    require_once( 'vendor/autoload.php' );
    \Carbon_Fields\Carbon_Fields::boot();
}
add_action( 'after_setup_theme', 'crb_load' );


require( get_template_directory() . '/inc/cpt-gallery.php' );


function register_taxonomies() {
    require( get_template_directory() . '/inc/taxonomies.php' );
}
add_action( 'init', 'register_taxonomies', 0 );

require( get_template_directory() . '/inc/site-sections/gallery-section.php' );
new ArtShop_CPT_Medium();


function enq_photolab_scripts() {
    wp_enqueue_style( "photolab-frontend-CSS", get_template_directory_uri() . '/static/style.css', array(), "1.0", "all" );
}
add_action('wp_enqueue_scripts', 'enq_photolab_scripts');


?>
