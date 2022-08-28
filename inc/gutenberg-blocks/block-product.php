<?php
use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make( __( 'Photolab Product' ) )
	->add_fields( array(
		Field::make( 'select', 'product_category', __( 'Product Category' ) )
        ->add_options( 'get_product_parent_category_ids' ),
		Field::make( 'multiselect', 'product_attributes', __( 'Product Filters' ) )
        ->add_options( 'get_product_attribute_ids' )
	) )
	->set_icon( 'camera' )
    ->set_mode( 'both' )
	->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {

		//PRODUCT CATEGORIES LOGIC STARTS HERE
		$parent_category = $fields['product_category'];
		global $wpdb;
		$categories_sql = $wpdb->prepare( "SELECT wp_term_taxonomy.term_id, wp_terms.name, wp_terms.slug
								FROM wp_term_taxonomy
								LEFT JOIN wp_terms
								ON wp_term_taxonomy.term_id = wp_terms.term_id
								WHERE parent=$parent_category OR wp_terms.term_id=$parent_category
								AND count > 0
								ORDER BY parent ASC"
							);
		$get_active_categories = $wpdb->get_results( $categories_sql );


		//PRODUCT FILTERS LOGIC STARTS HERE
		$product_attribute_ids = $fields['product_attributes'];
		if ( !empty( $product_attribute_ids ) ) {
			//Gets selected attributes
			$attributes_sql = $wpdb->prepare( "SELECT attribute_name, attribute_label
											   FROM wp_woocommerce_attribute_taxonomies
											   WHERE attribute_id IN  (" . implode(',', $product_attribute_ids) . ")"
											);
			$get_attributes = $wpdb->get_results( $attributes_sql );

			//Adapts attributes for attribute terms query
			$attributes = array();
			foreach ( $get_attributes as $attribute ) {
				array_push( $attributes, '"pa_' . $attribute->attribute_name . '"' );
			}

			//Gets active attribute terms
			$attribute_terms_sql = $wpdb->prepare( "SELECT wp_terms.term_id, wp_terms.name, wp_term_taxonomy.taxonomy
												    FROM wp_term_taxonomy
												    JOIN wp_terms
				   								    ON wp_term_taxonomy.term_id = wp_terms.term_id
												    WHERE wp_term_taxonomy.taxonomy IN (" . implode(',', $attributes) . ")
												    AND wp_term_taxonomy.count > 0"
												  );
			$get_attribute_terms = $wpdb->get_results( $attribute_terms_sql );

			//Constructs product filters array
			$filters_array = array();
			foreach ( $get_attributes as $attribute ) {
				$filters_array[strtolower($attribute->attribute_label)] = array();
			}
			foreach ( $get_attribute_terms as $attribute_term ) {
				$key =  substr( $attribute_term->taxonomy, 3 );
				array_push( $filters_array[$key], $attribute_term);
			}

		}

		//PRODUCT QUERY
		$query = new WC_Product_Query( array(
					 'limit' => 25,
					 'status' => 'publish',
					 'tax_query' => array( array(
						   'taxonomy' => 'product_cat',
						   'field'    => 'term_id',
						   'terms'    => $parent_category
						) )
					) );
		$get_products = $query->get_products();

		?>
		<div class="block-product">
			<div class="category-bar">
				<?php
				foreach ( $get_active_categories as $key => $category ) {
					$category_class = $key == 0 ? 'product-category active' : 'product-category';
					$name = $key == 0 ? 'Alla' : esc_html($category->name);
					?>
					<div class="<?php echo $category_class; ?>">
						<?php echo $name; ?>
					</div>
					<?php
				}
				?>
			</div>
			<div class="products">
				<?php
				foreach ( $get_products as $product ) {
					$price = $product->get_type() === 'variable' ? $product->get_variation_price( 'min' ) : $product->get_price();
					$price_from = $product->get_type() === 'variable' ? '<span class="price-from">från </span>' : null;
					$image = wp_get_attachment_image_src( $product->image_id, '' );
					$image_class = $image[1] > $image[2] ? "landscape-img" : "portrait-img";
					?>
					<div class="product">
						<div class="image">
							<img class="<?php echo $image_class; ?>" src="<?php esc_attr_e( $image[0] ); ?>" alt="">
						</div>
						<h5><?php esc_html_e( $product->name ); ?></h5>
						<div class="price">
							<?php echo $price_from; ?>
							<h5><?php echo wc_price( $price ); ?></h5>
						</div>

					</div>
					<?php
				}
				?>
			</div>
		</div>
		<?php
	} );
?>
