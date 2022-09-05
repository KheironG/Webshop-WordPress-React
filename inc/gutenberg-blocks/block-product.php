<?php
use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make( __( 'Photolab Product' ) )
	->add_fields( array(
		Field::make( 'select', 'product_category', __( 'Product Category' ) )
        ->add_options( 'get_product_parent_category_ids' ),
		Field::make( 'multiselect', 'product_attributes', __( 'Product Filters' ) )
        ->add_options( 'get_product_attribute_ids' ),
		Field::make( 'text', 'limit', __( 'Products Per Page' ) )
		->set_default_value( 25 ),
	) )
	->set_icon( 'camera' )
    ->set_mode( 'both' )
	->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {

		//PRODUCT CATEGORIES LOGIC STARTS HERE
		$parent_category = $fields['product_category'];
		global $wpdb;
		$categories_sql = $wpdb->prepare( "SELECT {$wpdb->prefix}term_taxonomy.term_id, {$wpdb->prefix}terms.name, {$wpdb->prefix}terms.slug
								FROM {$wpdb->prefix}term_taxonomy
								LEFT JOIN {$wpdb->prefix}terms
								ON {$wpdb->prefix}term_taxonomy.term_id = {$wpdb->prefix}terms.term_id
								WHERE parent=$parent_category OR {$wpdb->prefix}terms.term_id=$parent_category
								AND count > 0
								ORDER BY parent ASC"
							);
		$get_active_categories = $wpdb->get_results( $categories_sql );


		//PRODUCT FILTERS LOGIC STARTS HERE
		$product_attribute_ids = $fields['product_attributes'];
		if ( !empty( $product_attribute_ids ) ) {
			//Gets selected attributes
			$attributes_sql = $wpdb->prepare( "SELECT attribute_name, attribute_label
											   FROM {$wpdb->prefix}woocommerce_attribute_taxonomies
											   WHERE attribute_id IN  (" . implode(',', $product_attribute_ids) . ")"
											);
			$get_attributes = $wpdb->get_results( $attributes_sql );

			//Adapts attributes for attribute terms query
			$attributes = array();
			foreach ( $get_attributes as $attribute ) {
				array_push( $attributes, '"pa_' . $attribute->attribute_name . '"' );
			}

			//Gets active attribute terms
			$attribute_terms_sql = $wpdb->prepare( "SELECT {$wpdb->prefix}terms.term_id, {$wpdb->prefix}terms.name, {$wpdb->prefix}term_taxonomy.taxonomy
												    FROM {$wpdb->prefix}term_taxonomy
												    JOIN {$wpdb->prefix}terms
				   								    ON {$wpdb->prefix}term_taxonomy.term_id = {$wpdb->prefix}terms.term_id
												    WHERE {$wpdb->prefix}term_taxonomy.taxonomy IN (" . implode(',', $attributes) . ")
												    AND {$wpdb->prefix}term_taxonomy.count > 0"
												  );
			$get_attribute_terms = $wpdb->get_results( $attribute_terms_sql );

			//Constructs product filters array
			$filters_array = array();
			foreach ( $get_attributes as $attribute ) {
				$filters_array[$attribute->attribute_name] = array(
					'label' => $attribute->attribute_label,
					'terms' => array()
				);
			}
			foreach ( $get_attribute_terms as $attribute_term ) {
				$name =  substr( $attribute_term->taxonomy, 3 );
				array_push( $filters_array[$name]['terms'], $attribute_term );
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
			<div class="category-bar-container">
				<div class="category-bar">
					<?php
					foreach ( $get_active_categories as $key => $category ) {
						$category_class = $key == 0 ? 'product-category active' : 'product-category';
						$name = $key == 0 ? 'Alla' : esc_html($category->name);
						?>
						<div class="<?php echo $category_class; ?>" onclick="categoryTrigger(this);">
							<?php echo $name; ?>
							<input class="category" type="hidden" value="<?php echo $category->term_id; ?>">
						</div>
						<?php
					}
					?>
				</div>
				<div class="filters-open" onclick="filterTrigger(this);">
					<i class="fa-solid fa-caret-left fa-lg"></i>
					<label>produkt filter</label>
				</div>
			</div>
			<div class="products">
				<div id="loader" class="lds-roller hidden"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
				<div id="products-container">
					<?php
					foreach ( $get_products as $product ) {
						get_template_part( 'template-parts/part', 'product-preview', $product );
					}
					?>
				</div>
				<div id="product-filters" class="product-filter-container">
					<div class="product-filters">
						<div class="filters-close" onclick="filterTrigger(this);">
							<label>stäng</label>
							<i class="fa-solid fa-caret-right fa-lg"></i>
						</div>
						<?php
						if ( !empty( $filters_array ) ) {
							foreach ( $filters_array as $filter_group ) {
								?>
								<div class="filter-group">
									<div class="trigger" onclick="filterGroupTrigger(this);">
										<label><?php esc_html_e( $filter_group['label'] ); ?></label>
										<i class="fa-solid fa-caret-down"></i>
									</div>
									<div class="inputs hidden">
										<?php
										foreach ( $filter_group['terms'] as $input ) {
											?>
											<div class="input">
												<input class="filter" type="checkbox"
												value="<?php esc_html_e( $input->taxonomy ); ?>:<?php esc_html_e( $input->term_id ); ?>">
												<label ><?php esc_html_e( $input->name ); ?></label>
											</div>
											<?php
										}
										?>
									</div>
								</div>
								<?php
							}
						}
						?>
						<button class="more-info-button" type="button" name="button" onclick="getProducts();">filtrera</button>
						<span onclick="clearFilters();">rensa filter</span>
					</div>
				</div>
				<input type="hidden" name="limit" id="limit" value="<?php esc_html_e( $fields['limit'] );?>">
				<input type="hidden" name="offset" id="offset" value="0">
			</div>
		</div>
		<?php
	} );
?>
