<?php

/**
 *
 */
use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Carbon_Fields\Block;

class Photolab_Carbon_Fields {

    public function __construct() {
		add_action( 'after_setup_theme',  array( $this, 'load_carbon_fields' ) );
        add_action( 'carbon_fields_register_fields', array( $this, 'register_carbon_fields' ) );
	}

    function load_carbon_fields() {
        require_once( get_template_directory() . '/vendor/autoload.php' );
        \Carbon_Fields\Carbon_Fields::boot();
    }

    function register_carbon_fields() {

        wp_enqueue_style( "photolab-admin-css", get_template_directory_uri() . '/static/admin-style.css', array(), "1.0", "all" );

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

        function get_gallery_sizes() {
            $get_gallery_sizes = get_terms( array(
                'taxonomy' => 'gallery_sizes',
                'hide_empty' => false,
            ) );
            $gallery_sizes = [];
            foreach ( $get_gallery_sizes as $gallery_size ) {
                $gallery_sizes[$gallery_size->term_id] = $gallery_size->name;
            }
            return $gallery_sizes;
        }

        Container::make( 'term_meta', __( 'Size Properties' ) )
            ->where( 'term_taxonomy', '=', 'gallery_sizes' )
            ->add_fields( array(
                 Field::make( 'text', 'width' )->set_required( true )->set_width( 50 )->set_help_text( 'in cm' ),
                 Field::make( 'text', 'height' )->set_required( true )->set_width( 50 )->set_help_text( 'in cm' ),
                 Field::make( 'text', 'aspect_ratio' )->set_width( 50 ),
                 Field::make( 'text', 'low_quality' )->set_required( true )->set_width( 50 )->set_help_text( 'required DPI' ),
                 Field::make( 'text', 'medium_quality' )->set_required( true )->set_width( 50 )->set_help_text( 'required DPI' ),
                 Field::make( 'text', 'high_quality' )->set_required( true )->set_width( 50 )->set_help_text( 'required DPI' ),
            ) );

        //Gutenberg Blocks
        require( get_template_directory() . '/inc/gutenberg-blocks/block-hero.php' );
        require( get_template_directory() . '/inc/gutenberg-blocks/block-section.php' );
        require( get_template_directory() . '/inc/gutenberg-blocks/block-guide.php' );
        require( get_template_directory() . '/inc/gutenberg-blocks/block-previews.php' );
    }

}
?>
