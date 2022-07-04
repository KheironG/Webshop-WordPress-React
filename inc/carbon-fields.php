<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make( 'term_meta', __( 'Size Properties' ) )
    ->where( 'term_taxonomy', '=', 'gallery_sizes' )
    ->add_fields( array(
         Field::make( 'text', 'width' )->set_required( true )->set_width( 50 )->set_help_text( 'in cm' ),
         Field::make( 'text', 'height' )->set_required( true )->set_width( 50 )->set_help_text( 'in cm' ),
         Field::make( 'text', 'aspect_ratio' )->set_width( 50 ),
         Field::make( 'text', 'min_resulotion_for_print' )->set_required( true )->set_width( 50 )->set_help_text( 'width by height in pixels' ),
    ) );

Container::make( 'post_meta', __( 'Weigth' ) )
    ->show_on_post_type( array( 'medium' ) )
    ->add_fields( array(
         Field::make( 'text', 'gsm' )->set_required( true )->set_width( 50 )->set_help_text( 'weight in gsm' ),
    ) );

Container::make( 'post_meta', 'Price' )
    ->show_on_post_type( array( 'gallery_product', 'frame', 'medium' ) )
    ->add_fields( array(
        Field::make( 'text', 'price' )->set_required( true )->set_width( 50 )
    ));
?>
