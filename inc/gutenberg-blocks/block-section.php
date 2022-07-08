<?php
use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make( __( 'Photolab Section' ) )
	->add_fields( array(
		Field::make( 'text', 'section_title', __( 'Title' ) ),
        Field::make( 'text', 'section_description', __( 'Description' ) ),
        Field::make( 'color', 'section_background', 'Background Colour' )
            ->set_palette( array( '#E3E3E3', '#F6F6F8', '#FFFFFF' ) )
	) )
	->set_icon( 'camera' )
	->set_inner_blocks( true )
	->set_inner_blocks_position( 'below' )
	->set_inner_blocks_template( array(
		array( 'core/heading' ),
		array( 'core/paragraph' )
	) )
	->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
		?>
		<div class="flex-center-column" style="background-color: <?php echo esc_html( $fields['section_background'] ); ?> ">

			<h2><?php echo esc_html( $fields['section_title'] ); ?></h2>

			<p><?php echo esc_html( $fields['section_description'] ); ?></p>



		</div>
		<?php
	} );
?>
