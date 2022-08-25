<?php
use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make( __( 'Start' ) )
	->add_fields( array(
		Field::make( 'complex', 'top_section', 'Top Section' )
               ->set_layout( 'tabbed-horizontal' )
               ->add_fields( array(
				  Field::make( 'text', 'strapline', __( 'Strapline' ) ),
				  Field::make( 'text', 'title', __( 'Title' ) ),
 		          Field::make( 'text', 'desc', __( 'Description' ) ),
                  Field::make( 'select', 'url', __( 'URL' ) )->add_options( 'get_available_pages' ),
				  Field::make( 'image', 'background', __( 'Background Image' ) )
		  			->set_value_type( 'url' )
        ) ),
		Field::make( 'complex', 'bottom_section', 'Bottom Section' )
               ->set_layout( 'tabbed-horizontal' )
               ->add_fields( array(
				   Field::make( 'text', 'strapline', __( 'Strapline' ) ),
 				   Field::make( 'text', 'title', __( 'Title' ) ),
  		           Field::make( 'text', 'desc', __( 'Description' ) ),
                   Field::make( 'select', 'url', __( 'URL' ) )->add_options( 'get_available_pages' ),
 				   Field::make( 'image', 'background', __( 'Background Image' ) )
 		  		     ->set_value_type( 'url' )
        ) ),
	) )
	->set_icon( 'camera' )
    ->set_mode( 'both' )
	->set_category( 'layout' )
	->set_description( __( 'A layout block for Start page with link items divided into top and bottom sections.' ) )
	->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
		$top_sections = $fields['top_section'];
		$bottom_sections = $fields['bottom_section'];
		?>
		<div class="block-start">
			<div class="top-section">
				<?php
				if ( !empty( $top_sections )  ) {
					foreach ( $top_sections as $top_section ) {
						$strapline = !empty($top_section['strapline']) ? '<h5>'. esc_html( $top_section['strapline'] ) .'</h5>': null;
						$title = !empty($top_section['title']) ? '<h3>'. esc_html( $top_section['title'] ) .'</h3>': null;
						$desc = !empty($top_section['desc']) ? '<p>'. esc_html( $top_section['desc'] ) .'</p>': null;
						?>
						<a class="top-section-item" href="<?php esc_attr_e( $top_section['url']); ?>"
							style="background-image: url('<?php echo $top_section['background'] ?>')">
							<?php
							echo $strapline;
							echo $title;
							if ( $title != null && $title != null ) {
								?>
								<span class="white-line-break"></span>
								<?php
							}
							echo $desc;
						    ?>
						</a>
						<?php
					}

				}
				?>
			</div>
			<div class="bottom-section">
				<?php
				if ( !empty( $bottom_sections )  ) {
					foreach ( $bottom_sections as $bottom_section ) {
						$strapline = !empty( $bottom_section['strapline'] ) ? '<h5>'. esc_html( $bottom_section['strapline'] ) .'</h5>': null;
						$title = !empty( $bottom_section['title']) ? '<h3>'. esc_html( $bottom_section['title'] ) .'</h3>': null;
						$desc = !empty( $bottom_section['desc']) ? '<p>'. esc_html( $bottom_section['desc'] ) .'</p>': null;
						?>
						<a class="top-section-item" href="<?php esc_attr_e( $bottom_section['url']); ?>"
							style="background-image: url('<?php echo $bottom_section['background'] ?>')">
							<?php
							echo $strapline;
							echo $title;
							if ( $title != null && $title != null ) {
								?>
								<span class="white-line-break"></span>
								<?php
							}
							echo $desc;
						    ?>
						</a>
						<?php
					}
				}
				?>
			</div>
		</div>
		<?php
	} );
?>
