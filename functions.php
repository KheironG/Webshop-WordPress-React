<?php

function artshop_carbon_fields() {

    wp_enqueue_style( "photolab-carbon-blocks-css", get_template_directory_uri() . '/admin/css/carbon-blocks.css', array(), "1.0", "all" );

    function get_available_pages() {
        $get_pages = get_pages( array( 'hierarchical' => true ) );
        $pages = [];
    	$pages['none'] = 'No link';
        foreach ( $get_pages as $page ) {
    		$page_url = get_page_link($page->ID);
            $pages[$page_url] = $page->post_title;
        }
        return $pages;
    }

    require( get_template_directory() . '/inc/carbon-fields.php' );

    //Gutenberg Blocks
    require( get_template_directory() . '/inc/blocks/block-hero.php' );
    require( get_template_directory() . '/inc/blocks/block-section.php' );
    require( get_template_directory() . '/inc/blocks/block-guide.php' );
}
add_action( 'carbon_fields_register_fields', 'artshop_carbon_fields' );


function crb_load() {
    require_once( 'vendor/autoload.php' );
    \Carbon_Fields\Carbon_Fields::boot();
}
add_action( 'after_setup_theme', 'crb_load' );




class Photolab_Custom_Product_Types {

    public function __construct() {
        add_action( 'woocommerce_loaded', array( $this, 'load_product_types' ) );
        add_filter( 'product_type_selector', array( $this, 'add_types' ) );
        add_filter( 'woocommerce_product_data_tabs', array( $this, 'add_product_tabs' ), 50 );
        add_action( 'woocommerce_product_data_panels', array( $this, 'add_product_tabs_content' ) );
    }

    public function add_types( $types ) {
        $types['image'] = __( 'Image', 'photolab' );
        $types['frame'] = __( 'Frame', 'photolab' );
        $types['medium'] = __( 'Medium', 'photolab' );
        $types['passepartout'] = __( 'Passepartout', 'photolab' );
        return $types;
    }

    public function load_product_types() {
        require_once 'inc/custom-product-types/cpt-image.php';
        require_once 'inc/custom-product-types/cpt-frame.php';
        require_once 'inc/custom-product-types/cpt-medium.php';
        require_once 'inc/custom-product-types/cpt-passepartout.php';
    }

    public function add_product_tabs( $tabs ) {
        $tabs['image'] = array(
            'label'    => __( 'Image', 'photolab' ),
            'target' => 'image_product_options',
            'class'  => 'show_if_image',
        );
        $tabs['frame'] = array(
            'label'    => __( 'Frame', 'photolab' ),
            'target' => 'frame_product_options',
            'class'  => 'show_if_frame',
        );
        $tabs['medium'] = array(
            'label'    => __( 'Medium', 'photolab' ),
            'target' => 'medium_product_options',
            'class'  => 'show_if_medium',
        );
        $tabs['passepartout'] = array(
            'label'    => __( 'Passepartout', 'photolab' ),
            'target' => 'passepartout_product_options',
            'class'  => 'show_if_passepartout',
        );
        return $tabs;
    }

    public function add_product_tabs_content() {
        global $product_object;

        $get_gallery_sizes = get_terms( array(
            'taxonomy' => 'gallery_sizes',
            'hide_empty' => false,
        ) );
        $gallery_sizes = [];
        foreach ( $get_gallery_sizes as $gallery_size ) {
            $gallery_sizes[$gallery_size->term_id] = $gallery_size->name;
        }
        $get_current_size = get_terms( array(
            'taxonomy' => 'gallery_sizes',
            'object_ids' => $product_type->ID,
        ) );
        require_once 'inc/custom-product-types/cpt-image-tab-content.php';
        require_once 'inc/custom-product-types/cpt-frame-tab-content.php';
        require_once 'inc/custom-product-types/cpt-medium-tab-content.php';
        require_once 'inc/custom-product-types/cpt-passepartout-tab-content.php';
    }

}
new Photolab_Custom_Product_Types();




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
