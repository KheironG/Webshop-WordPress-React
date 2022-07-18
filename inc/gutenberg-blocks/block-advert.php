<?php
use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make( __( 'Photolab Advert' ) )
	->add_fields( array(
        Field::make( 'separator', 'advert_separator', __( 'Guide details' ) ),
        Field::make( 'text', 'advert_title', __( 'Title' ) ),
        Field::make( 'text', 'advert_description', __( 'Description' ) ),
        Field::make( 'color', 'advert_text_colour', __( 'Text Color' ) ),

		Field::make( 'color', 'advert_background', __( 'Background colour' ) )
            ->set_palette( array( '#E3E3E3', '#F6F6F8', '#FFFFFF' ) ),
		Field::make( 'image', 'advert_image', __( 'Image' ) )
			->set_value_type( 'url' ),

		Field::make( 'text', 'advert_button_text', __( 'Button Text' ) ),
		Field::make( 'select', 'advert_button_url', __( 'Button Link' ) )->add_options( 'get_available_pages' ),

	) )
	->set_icon( 'camera' )
    ->set_mode( 'both' )
    ->set_editor_style( 'photolab-admin-css' )
	->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {

		if ( empty( $fields['advert_background'] ) || empty( $fields['advert_image'] ) ) {

			if ( !empty( $fields['advert_background'] ) ) {
				$single_advert_class['style'] = 'background-color:';
				$single_advert_class['value'] = $fields['advert_background'];
			} else {
				$single_advert_class['style'] = 'background-image:';
				$single_advert_class['value'] = $fields['advert_image'];
			}
			?>
			<div class="carbon-block-advert-single" style="color:<?php $fields['advert_text_colour'] ?>;<?php echo $single_advert_class . $single_advert_class['value']; ?>">
				<h4><?php echo esc_attr( $fields['advert_title'] ); ?></h4>
				<p><?php echo esc_html( $fields['advert_description'] ); ?></p>
			</div>
			<?php
		} elseif ( !empty( $fields['advert_background'] ) && !empty( $fields['advert_image'] ) ) {
			?>
			<div class="carbon-block-advert-double" style="color:<?php $fields['advert_text_colour'] ?>;">
				<div class="column-1">
					<img src="<?php echo $fields['advert_image']; ?>" alt="">
				</div>
				<div class="column-2" style="color:<?php echo $fields['advert_text_colour'] ?>;background-color:<?php echo $fields['advert_background']; ?>;" >
					<h2><?php echo esc_attr( $fields['advert_title'] ); ?></h2>
					<p><?php echo esc_html( $fields['advert_description'] ); ?></p>
					<?php
					if ( $fields['advert_button_url'] !== 'none' ) {
						?>
						<a class="hero-button-link" href="<?php echo esc_attr( $fields['advert_button_url'] ); ?>"
							style="border-style:solid;border-width:1px;border-color:<?php echo esc_attr( $fields['advert_text_colour'] ) ?>;color:<?php echo esc_attr( $fields['advert_text_colour'] ); ?>;">
							<?php echo esc_html( $fields['advert_button_text'] ); ?>
						</a>
						<?php
					}
					?>
				</div>
			</div>
			<?php
		}
	} );
?>
