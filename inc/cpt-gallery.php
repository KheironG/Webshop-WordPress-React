<?php
/**
 * Register custom post type, taxonomies, metabox for Gallery Item.
 */
class ArtShop_CPT_Gallery {

    /**
     * Constructor.
     */
    public function __construct() {
        if ( is_admin() ) {
            add_action( 'init', array( $this, 'create_post_type' ) );
            add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
            add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
        }
    }

    /**
     * Registers custom post type and taxonomies.
     */
    public function create_post_type () {
        register_post_type('gallery',
                array(
                    'labels'      => array(
                        'name'          => __( 'Gallery Items', 'artshop' ),
                        'singular_name' => __( 'Gallery Item', 'artshop' ),
                    ),
                    'public'      => true,
                    'has_archive' => true,
                )
            );

            register_taxonomy( 'sizes', array( 'gallery' ), array(
                'hierarchical'      => true,
                'labels'            => array(
                    'name'              => __( 'Sizes', 'taxonomy general name', 'artshop' ),
                    'singular_name'     => __( 'Size', 'taxonomy singular name', 'artshop' ),
                    'menu_name'         => __( 'Sizes', 'artshop' )
                ),
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array( 'slug' => 'sizes' )
            ) );
    }


    /**
     * Meta box initialization.
     */
    public function init_metabox() {
        add_action( 'add_meta_boxes', array( $this, 'add_metabox'  )        );
        add_action( 'save_post',      array( $this, 'save_metabox' ), 10, 2 );
    }

    /**
     * Adds meta box.
     */
    public function add_metabox() {
        add_meta_box(
            'artshop-gallery-metabox',
            __( 'Gallery Item Options', 'artshop' ),
            array( $this, 'render_metabox' ),
            'gallery',
        );

    }

    /**
     * Renders the meta box.
     */
    public function render_metabox( $post ) {
        // Add nonce for security and authentication.
        wp_nonce_field( 'custom_nonce_action', 'custom_nonce' );
    }

    /**
     * Handles saving the meta box.
     *
     * @param int     $post_id Post ID.
     * @param WP_Post $post    Post object.
     * @return null
     */
    public function save_metabox( $post_id, $post ) {
        // Add nonce for security and authentication.
        $nonce_name   = isset( $_POST['custom_nonce'] ) ? $_POST['custom_nonce'] : '';
        $nonce_action = 'custom_nonce_action';

        // Check if nonce is valid.
        if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
            return;
        }

        // Check if user has permissions to save data.
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }

        // Check if not an autosave.
        if ( wp_is_post_autosave( $post_id ) ) {
            return;
        }

        // Check if not a revision.
        if ( wp_is_post_revision( $post_id ) ) {
            return;
        }
    }
}
?>
