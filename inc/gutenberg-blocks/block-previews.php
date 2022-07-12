<?php
use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make( __( 'Product Previews' ) )
	->add_fields( array(
		Field::make( 'text', 'previews_title', __( 'Title' ) ),
        Field::make( 'text', 'previews_description', __( 'Description' ) ),
		Field::make( 'color', 'previews_text_colour', __( 'Text Color' ) )
			->set_palette( array( '#000000' ) ),
		Field::make( 'color', 'previews_background', __( 'Text Color' ) )
			->set_palette( array( '#E3E3E3', '#F6F6F8', '#FFFFFF' ) ),
		Field::make( 'select', 'previews_category', __( 'Show product type' ) )->add_options(
			array(
				'images' => __( 'Images' ),
				'frames' => __( 'Frames' ),
				'mediums' => __( 'Print Mediums' ),
				'passpartouts' => __( 'Passepartouts' ),
			) ),
		Field::make( 'text', 'previews_per_page', __( 'Products per page' ) )->set_help_text( 'Products to show per page. Defaults to 9.' ),
	) )
	->set_icon( 'camera' )
    ->set_mode( 'both' )
    ->set_editor_style( 'photolab-admin-css' )
	->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
		?>
		<div class="carbon-block-previews"
			style="color:<?php echo esc_html( $fields['previews_text_colour'] ); ?>;background-color:<?php echo $fields['previews_background'] ?>;">
			<?php
            if ( !empty( $fields['previews_title'] ) || !empty( $fields['previews_description'] ) ) {
                ?>
                <div class="text-center">
                    <h2><?php echo esc_html( $fields['previews_title'] ); ?></h2>
        			<p><?php echo esc_html( $fields['previews_description'] ); ?></p>
                </div>
                <?php
            }
            ?>
			<div class="category-selector">
				<select id="products-category" name="product-preview-category-selector">
					<?php
					$product_category = get_term_by( 'name', $fields['previews_category'], 'product_cat' );
					$category_children = get_terms( 'product_cat', ['child_of'=> $product_category->term_id ] );
					$options = [];
					$options .= '<option value="">Category</option>';
					foreach ( $category_children as $category_children ) {
						echo '<option value="' . $category_children->term_id . '">'. $category_children->name .'</option>';
					}
					?>
				</select>
			</div>
			<div class="products">
				<div class="products-section">
					<?php
					$per_page = !empty( $fields['previews_per_page'] ) ? $fields['previews_per_page'] : 9;
					$args = array( 'category' => array( $fields['previews_category'] ), 'limit' => $per_page, 'paginate' => true );
					$products = wc_get_products( $args );
					foreach ( $products->products as $product ) {
						get_template_part( 'template-parts/part', 'product-preview', $product );
					}
					?>
				</div>
			</div>
			<?php
			if ( $products->max_num_pages > 1 ) {
				?>
				<div class="flex-center-column grid-gap-10">
					<small>
						<?php
						echo __( 'visar ');
						echo $per_page;
						echo __( ' av ');
						echo $products->total;
						?>
					</small>
					<div onclick="photolabPaginateProducts();" class="paginate-button">
						<?php echo __( 'hämta flera' ); ?>
					</div>
				</div>
				<input id="products-limit" type="hidden" value="<?php echo $fields['previews_per_page']; ?>">
				<input id="products-offset" type="hidden" value="<?php echo $fields['previews_per_page']; ?>">
				<input id="products-category" type="hidden" value="<?php echo $product_category->term_id; ?>">
				<?php
			}
			?>
		</div>
		<?php
	} );
?>
