<?php


function artshop_register_product_types () {

    class WC_Product_Gallery extends WC_Product {
        public function __construct( $product ) {
           $this->product_type = 'gallery';
           parent::__construct( $product );
           // add additional functions here
        }
    }

    class WC_Product_Frame extends WC_Product {
        public function __construct( $product ) {
           $this->product_type = 'frame';
           parent::__construct( $product );
           // add additional functions here
        }
    }
}
add_action( 'init', 'artshop_register_product_types' );


function artshop_add_product_types ( $type ) {
	$type[ 'gallery' ] = __( 'Gallery' );
    $type[ 'frame' ] = __( 'Frame' );

	return $type;
}
add_filter( 'product_type_selector', 'artshop_add_product_types' );

function product_type_tabs( $tabs) {

	$tabs['gallery'] = array(
		'label'	 => __( 'Gallery', 'artshop' ),
		'target' => 'gallery_options',
		'class'  => ('show_if_gallery'),
	);

    $tabs['frame'] = array(
		'label'	 => __( 'Frame', 'artshop' ),
		'target' => 'frame_options',
		'class'  => ('show_if_frame'),
	);

	return $tabs;
}
add_filter( 'woocommerce_product_data_tabs', 'product_type_tabs' );

function artshop_product_tab_content( ) {
    global $post;

	?><div id='gallery_options' class='panel woocommerce_options_panel'><?php
		?><div class='options_group'><?php
            $get_gallery_sizes = get_terms( array(
                'taxonomy' => 'gallery_sizes',
                'hide_empty' => false,
            ) );
            $gallery_sizes = [];
            foreach ( $get_gallery_sizes as $gallery_size ) {
                $gallery_sizes[$gallery_size->term_id] = $gallery_size->name;
            }
            woocommerce_wp_select(
                array(
                    'id' => 'gallery_items_sizes',
                    'name' => 'gallery_items_sizes[]',
                    'label' => __('Select size', 'artshop'),
                    'description' => 'What dimensions is this gallery item available in. Accepts single or multiple?',
                    'desc_tip' => 'true',
                    'class' => 'cb-admin-multiselect',
                    'options' => $gallery_sizes,
                    'custom_attributes' => array('multiple' => 'multiple')
                )
            );

            $get_current_sizes = get_terms( array(
                'taxonomy' => 'gallery_sizes',
                'object_ids' => $post->ID,
                'fields' => 'names'
            ) );
            $current_sizes = '';
            foreach ( $get_current_sizes as $current_size ) {
                $current_sizes .= ' ' . $current_size;
            }
            ?>
            <p>Currently available sizes: <?php echo $current_sizes; ?> </p>
		</div>
	</div><?php

}
add_action( 'woocommerce_product_data_panels', 'artshop_product_tab_content' );

function artshop_save_options_field( $post_id ) {

	if ( isset( $_POST['gallery_items_sizes'] ) ) :
		wp_set_post_terms( $post_id, $_POST['gallery_items_sizes'], 'gallery_sizes' );
	endif;
}
add_action( 'woocommerce_process_product_meta', 'artshop_save_options_field' );




/**
 * Register custom post type, taxonomies, metabox for Gallery Item.
 */
// class ArtShop_CPT_Gallery {
//
//     /**
//      * Constructor.
//      */
//     public function __construct() {
//         if ( is_admin() ) {
//             add_action( 'init', array( $this, 'create_post_type' ) );
//             add_action( 'load-post.php',     array( $this, 'init_metabox' ) );
//             add_action( 'load-post-new.php', array( $this, 'init_metabox' ) );
//         }
//     }
//
//     /**
//      * Registers custom post type and taxonomies.
//      */
//     public function create_post_type () {
//         register_post_type('gallery',
//                 array(
//                     'labels'      => array(
//                         'name'          => __( 'Gallery Items', 'artshop' ),
//                         'singular_name' => __( 'Gallery Item', 'artshop' ),
//                     ),
//                     'public'      => true,
//                     'has_archive' => true,
//                 )
//             );
//
//             register_taxonomy( 'sizes', array( 'gallery' ), array(
//                 'hierarchical'      => true,
//                 'labels'            => array(
//                     'name'              => __( 'Sizes', 'taxonomy general name', 'artshop' ),
//                     'singular_name'     => __( 'Size', 'taxonomy singular name', 'artshop' ),
//                     'menu_name'         => __( 'Sizes', 'artshop' )
//                 ),
//                 'show_ui'           => true,
//                 'show_admin_column' => true,
//                 'query_var'         => true,
//                 'rewrite'           => array( 'slug' => 'sizes' )
//             ) );
//     }
//
//
//     /**
//      * Meta box initialization.
//      */
//     public function init_metabox() {
//         add_action( 'add_meta_boxes', array( $this, 'add_metabox'  )        );
//         add_action( 'save_post',      array( $this, 'save_metabox' ), 10, 2 );
//     }
//
//     /**
//      * Adds meta box.
//      */
//     public function add_metabox() {
//         add_meta_box(
//             'artshop-gallery-metabox',
//             __( 'Gallery Item Options', 'artshop' ),
//             array( $this, 'render_metabox' ),
//             'gallery',
//         );
//
//     }
//
//     /**
//      * Renders the meta box.
//      */
//     public function render_metabox( $post ) {
//         // Add nonce for security and authentication.
//         wp_nonce_field( 'custom_nonce_action', 'custom_nonce' );
//     }
//
//     /**
//      * Handles saving the meta box.
//      *
//      * @param int     $post_id Post ID.
//      * @param WP_Post $post    Post object.
//      * @return null
//      */
//     public function save_metabox( $post_id, $post ) {
//         // Add nonce for security and authentication.
//         $nonce_name   = isset( $_POST['custom_nonce'] ) ? $_POST['custom_nonce'] : '';
//         $nonce_action = 'custom_nonce_action';
//
//         // Check if nonce is valid.
//         if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
//             return;
//         }
//
//         // Check if user has permissions to save data.
//         if ( ! current_user_can( 'edit_post', $post_id ) ) {
//             return;
//         }
//
//         // Check if not an autosave.
//         if ( wp_is_post_autosave( $post_id ) ) {
//             return;
//         }
//
//         // Check if not a revision.
//         if ( wp_is_post_revision( $post_id ) ) {
//             return;
//         }
//     }
// }
?>
