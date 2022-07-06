<?php
use Carbon_Fields\Block;
use Carbon_Fields\Field;

function get_available_pages() {
    $get_pages = get_pages( array( 'hierarchical' => true ) );
    $pages = [];
	$pages['none'] = 'No link';
    foreach ( $get_pages as $page ) {
		$page_url = get_page_link($page->ID);
        $pages[$page_url] = $page->post_title;
    }
    return $pages;
}


Block::make( __( 'Photolab Hero' ) )
	->add_fields( array(
		Field::make( 'text', 'hero_title', __( 'Title' ) ),
        Field::make( 'text', 'hero_description', __( 'Description' ) ),
		Field::make( 'text', 'hero_button_text', __( 'Button Text' ) ),
		Field::make( 'select', 'hero_button_url', __( 'Button Link' ) )->add_options( 'get_available_pages' ),
		Field::make( 'color', 'hero_text_colour', __( 'Text Color' ) )
			->set_palette( array( '#E3E3E3', '#F6F6F8', '#FFFFFF' ) ),
		Field::make( 'image', 'hero_background', __( 'Image' ) )
			->set_value_type( 'url' )
	) )
	->set_icon( 'camera' )
	->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
		?>
		<div class="carbon-block-hero"
			style="color:<?php echo esc_html( $fields['hero_text_colour'] ); ?>;background-image: url('<?php echo $fields['hero_background']; ?>') ">

			<h1><?php echo esc_html( $fields['hero_title'] ); ?></h1>

			<p><?php echo esc_html( $fields['hero_description'] ); ?></p>

			<?php
			if ( $fields['hero_button_url'] !== 'none' ) {
				?>
				<a class="hero-button-link" href="<?php echo esc_attr( $fields['hero_button_url'] ); ?>"
					style="border-style:solid;border-width:1px;border-color:<?php echo esc_attr( $fields['hero_text_colour'] ) ?>;color:<?php echo esc_attr( $fields['hero_text_colour'] ); ?>;">
					<?php echo esc_html( $fields['hero_button_text'] ); ?>
				</a>
				<?php
			}

			?>

		</div>
		<?php
	} );
?>
