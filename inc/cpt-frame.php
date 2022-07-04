<?php
/**
 * Register a meta box using a class.
 */
class ArtShop_CPT_Frame {

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
        register_post_type('frame',
                array(
                    'labels'      => array(
                        'name'          => __( 'Frames', 'artshop' ),
                        'singular_name' => __( 'Frame', 'artshop' ),
                    ),
                    'public'      => true,
                    'has_archive' => false,
                )
        );

        register_taxonomy( 'frame-material', array( 'frame' ), array(
            'hierarchical'      => true,
            'labels'            => array(
                'name'              => __( 'Materials', 'taxonomy general name', 'artshop' ),
                'singular_name'     => __( 'Material', 'taxonomy singular name', 'artshop' ),
                'menu_name'         => __( 'Materials', 'artshop' )
            ),
            'show_ui'           => false,
            'show_admin_column' => false,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'materials' )
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
            'artshop-frame-metabox',
            __( 'Frame Item Options', 'artshop' ),
            array( $this, 'render_metabox' ),
            'frame',
        );

    }

    /**
     * Renders the meta box.
     */
    public function render_metabox( $post ) {

        wp_nonce_field( 'custom_nonce_action', 'custom_nonce' );

        $sizes = get_terms( array(
            'taxonomy' => 'sizes',
            'hide_empty' => false,
        ) );

        ?>
        <label for="">Select dimensions</label>
        <select class="" name="">
            <?php
            foreach ( $sizes as $size ) {
                ?>
                <option value="<?php echo $size->term_id ?>"><?php echo $size->name; ?></option>
                <?php
            }
             ?>
        </select>
        <?php

        $materials = get_terms( array(
            'taxonomy' => 'frame-material',
            'hide_empty' => false,
        ) );
        ?>
        <label for="">Select Material</label>
        <select class="" name="">
            <?php
            foreach ( $materials as $material ) {
                ?>
                <option value="<?php echo $material->term_id ?>"><?php echo $material->name; ?></option>
                <?php
            }
             ?>
        </select>
        <?php
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
