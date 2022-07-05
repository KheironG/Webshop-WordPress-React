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
                    'label' => __('Set available sizes', 'artshop'),
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
            ?>
            <div style="display:flex;grid-gap:20px;align-items:center;">
                <p>Currently available in: </p>
                <div style="display:flex;grid-gap:15px;">
                    <?php
                    foreach ( $get_current_sizes as $current_size ) {
                        ?>
                        <b><?php echo $current_size; ?></b>
                        <?php
                    }
                    ?>
                </div>
            </div>

            <div class="options_group">

            </div>
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

?>
