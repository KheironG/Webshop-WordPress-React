<?php
/**
 *
 */
class Photlab_Taxonomies {

    public function __construct() {
        add_action( 'init', array( $this, 'gallery_sizes_taxonomy' ) );
    }

    public function gallery_sizes_taxonomy() {
        register_taxonomy( 'gallery_sizes', array( 'product' ), array(
            'hierarchical'      => true,
            'labels'            => array(
                'name'              => __( 'Gallery Sizes', 'taxonomy general name', 'artshop' ),
                'singular_name'     => __( 'Gallery Size', 'taxonomy singular name', 'artshop' ),
                'menu_name'         => __( 'Gallery Sizes', 'photolab' )
            ),
            'show_ui'           => true,
            'show_admin_column' => false,
            'show_in_menu'      => true,
            'meta_box_cb'       => false,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'gallery-sizes' )
        ) );
    }

}
?>
