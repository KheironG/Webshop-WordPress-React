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

        function get_page_ids() {
            $get_pages = get_pages( array( 'hierarchical' => true ) );
            $pages = [];
            foreach ( $get_pages as $page ) {
                $pages[$page->ID] = $page->post_title;
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

        function get_product_parent_category_ids() {
            global $wpdb;
    		$sql = $wpdb->prepare( "SELECT term_id, name
                    				FROM wp_terms
    							 	WHERE slug IN ( 'images', 'frames', 'passepartouts' )"
    							);
            $get_categories = $wpdb->get_results( $sql );
            $categories = [];
            foreach ( $get_categories as $category ) {
                $categories[$category->term_id] = $category->name;
            }
            return $categories;
        }

        function get_product_attribute_ids() {
            global $wpdb;
    		$sql = $wpdb->prepare( "SELECT attribute_id, attribute_label
                    				FROM wp_woocommerce_attribute_taxonomies"
    							);
            $get_attributes = $wpdb->get_results( $sql );
            $attributes = [];
            foreach ( $get_attributes as $attribute ) {
                $attributes[$attribute->attribute_id] = $attribute->attribute_label;
            }
            return $attributes;
        }


        //Gutenberg Blocks
        require_once( get_template_directory() . '/inc/gutenberg-blocks/block-start.php' );
        require_once( get_template_directory() . '/inc/gutenberg-blocks/block-product.php' );
        // require_once( get_template_directory() . '/inc/gutenberg-blocks/block-hero.php' );
        // require_once( get_template_directory() . '/inc/gutenberg-blocks/block-section.php' );
        // require_once( get_template_directory() . '/inc/gutenberg-blocks/block-guide.php' );
        // require_once( get_template_directory() . '/inc/gutenberg-blocks/block-previews.php' );
        // require_once( get_template_directory() . '/inc/gutenberg-blocks/block-advert.php' );
    }

}
?>
