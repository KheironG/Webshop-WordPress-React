<?php
class Photolab_Custom_WooCommerce {

	public function __construct() {
		add_action( 'woocommerce_product_options_general_product_data',  array( $this, 'add_general_product_tab' ) );
		add_action( 'woocommerce_process_product_meta', array( $this, 'save_product_fields' ) );
	}


	public function add_general_product_tab() {
		global $post;
		$get_gallery_sizes = get_terms( array(
			'taxonomy' => 'gallery_sizes',
			'hide_empty' => false,
		) );
		$gallery_sizes = [];
		foreach ( $get_gallery_sizes as $gallery_size ) {
			$gallery_sizes[$gallery_size->term_id] = $gallery_size->name;
		}
		$get_current_sizes = get_terms( array(
			'taxonomy' => 'gallery_sizes',
			'object_ids' => $post->ID,
		) );
		$get_current_layout = get_post_meta( $post->ID, 'gallery_layout', true );
		?>
		<div class='options_group show_if_simple'>
			<h4 style="padding-left:10px;">For Gallery Products</h4>
			<?php
			woocommerce_wp_select(
				array(
					'id' => 'gallery_item_size',
					'name' => 'gallery_item_size[]',
					'label' => __('Set size', 'photolab'),
					'class' => 'cb-admin-multiselect',
					'description' => 'Single value, or multiple values for products with same price.',
				   	'desc_tip' => 'true',
					'options' => $gallery_sizes,
					'custom_attributes' => array('multiple' => 'multiple')
				)
			);
			?>
			<div style="display:flex;grid-gap:20px;align-items:center;">
                <p>Currently available in: </p>
                <div style="display:flex;grid-gap:15px;">
                    <?php
                    foreach ( $get_current_sizes as $current_size ) {
                        ?>
                        <b><?php echo $current_size->name; ?></b>
                        <?php
                    }
                    ?>
                </div>
            </div>
			<?php
			woocommerce_wp_select(
				array(
					'id' => 'gallery_item_layout',
					'name' => 'gallery_item_layout',
					'label' => __('Set layout', 'photolab'),
					'options' => array( 'portrait' => 'portrait', 'landscape' => 'landscape' ),
					'value' => $get_current_layout
				)
			);
			?>
		</div>
		<?php
	}


	function save_product_fields( $post_id ){
		$gallery_item_size = $_POST['gallery_item_size'];
		$gallery_item_layout = esc_html( $_POST['gallery_item_layout'] );
		if( !empty( $gallery_item_size ) ) {
			wp_set_post_terms( $post_id, $gallery_item_size, 'gallery_sizes' );
		}
			update_post_meta( $post_id, 'gallery_layout', $gallery_item_layout );

	}

}
?>
