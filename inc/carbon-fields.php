<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

function get_gallery_sizes() {
    $get_gallery_sizes = get_terms( array(
        'taxonomy' => 'gallery_sizes',
        'hide_empty' => false,
    ) );
    $gallery_sizes = [];
    foreach ( $get_gallery_sizes as $gallery_size ) {
        $gallery_sizes[$gallery_size->term_id] = $gallery_size->name;
    }
    return $gallery_sizes;
}

Container::make( 'term_meta', __( 'Size Properties' ) )
    ->where( 'term_taxonomy', '=', 'gallery_sizes' )
    ->add_fields( array(
         Field::make( 'text', 'width' )->set_required( true )->set_width( 50 )->set_help_text( 'in cm' ),
         Field::make( 'text', 'height' )->set_required( true )->set_width( 50 )->set_help_text( 'in cm' ),
         Field::make( 'text', 'aspect_ratio' )->set_width( 50 ),
         Field::make( 'text', 'min_resulotion_for_print' )->set_required( true )->set_width( 50 )->set_help_text( 'width by height in pixels' ),
    ) );

Container::make( 'post_meta', __( 'Details' ) )
    ->show_on_post_type( array( 'medium' ) )
    ->add_fields( array(
        Field::make( 'select', 'size' )->add_options( 'get_gallery_sizes' )->set_required( true )->set_width( 33 ),
        Field::make( 'text', 'gsm' )->set_required( true )->set_width( 33 )->set_help_text( 'weight in gsm' ),
        Field::make( 'text', 'price' )->set_required( true )->set_width( 33 )
    ) );

?>
