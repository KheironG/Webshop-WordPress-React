<?php
/**
 * Register a meta box using a class.
 */
class ArtShop_CPT_Medium {

    /**
     * Constructor.
     */
    public function __construct() {
        if ( is_admin() ) {
            add_action( 'init', array( $this, 'create_post_type' ) );
        }
    }

    /**
     * Registers custom post type and taxonomies.
     */
    public function create_post_type () {
        register_post_type('medium',
                array(
                    'labels'      => array(
                        'name'          => __( 'Print Mediums', 'artshop' ),
                        'singular_name' => __( 'Print Medium', 'artshop' ),
                    ),
                    'public'      => true,
                    'has_archive' => false,
                    'show_in_menu' => true
                )
        );
    }

}
?>
