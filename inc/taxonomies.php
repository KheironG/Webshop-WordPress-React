<?php
register_taxonomy( 'gallery_sizes', array( 'medium' ), array(
    'hierarchical'      => true,
    'labels'            => array(
        'name'              => __( 'Gallery Sizes', 'taxonomy general name', 'artshop' ),
        'singular_name'     => __( 'Gallery Size', 'taxonomy singular name', 'artshop' ),
        'menu_name'         => __( 'Gallery Sizes', 'artshop' )
    ),
    'show_ui'           => true,
    'show_admin_column' => true,
    'show_in_menu'      => true,
    'meta_box_cb'       => false,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'gallery-sizes' )
) );

register_taxonomy( 'print-medium', array( 'product' ), array(
    'hierarchical'      => true,
    'labels'            => array(
        'name'              => __( 'Print Mediums', 'taxonomy general name', 'artshop' ),
        'singular_name'     => __( 'Print Medium', 'taxonomy singular name', 'artshop' ),
        'menu_name'         => __( 'Print Mediums', 'artshop' )
    ),
    'show_ui'           => true,
    'show_admin_column' => false,
    'meta_box_cb'       => false,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'print-mediums' )
) );
?>
