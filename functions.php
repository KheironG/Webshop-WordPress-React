<?php

function artshop_carbon_fields() {
    require( get_template_directory() . '/inc/carbon-fields.php' );
}
add_action( 'carbon_fields_register_fields', 'artshop_carbon_fields' );


function crb_load() {
    require_once( 'vendor/autoload.php' );
    \Carbon_Fields\Carbon_Fields::boot();
}
add_action( 'after_setup_theme', 'crb_load' );


require( get_template_directory() . '/inc/cpt-gallery.php' );
require( get_template_directory() . '/inc/cpt-frame.php' );
require( get_template_directory() . '/inc/cpt-medium.php' );
new ArtShop_CPT_Gallery();
new ArtShop_CPT_Frame();
new ArtShop_CPT_Medium();
?>
