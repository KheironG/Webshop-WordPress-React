<?php
use Carbon_Fields\Block;
use Carbon_Fields\Field;

wp_enqueue_style( "photolab-admin-css", get_template_directory_uri() . '/admin/css/carbon-blocks.css', array(), "1.0", "all" );

Block::make( __( 'Photolab Guide' ) )
	->add_fields( array(
        Field::make( 'separator', 'guide_separator', __( 'Guide details' ) ),
        Field::make( 'text', 'guide_title', __( 'Title' ) ),
        Field::make( 'text', 'guide_description', __( 'Description' ) ),
        Field::make( 'color', 'guide_text_colour', __( 'Text Color' ) ),
		Field::make( 'color', 'guide_background', __( 'Background colour' ) )
            ->set_palette( array( '#E3E3E3', '#F6F6F8', '#FFFFFF' ) ),
        Field::make( 'text', 'guide_button_text', __( 'Button Text' ) ),
		Field::make( 'select', 'guide_button_url', __( 'Button Link' ) )->add_options( 'get_available_pages' ),

        Field::make( 'separator', 'one_separator', __( 'Step One' ) ),
		Field::make( 'text', 'one_title', __( 'Title' ) ),
        Field::make( 'text', 'one_icon', __( 'Icon' ) )->set_help_text( 'Font Awesome class' ),
		Field::make( 'text', 'one_instruction', __( 'Instruction' ) ),

        Field::make( 'separator', 'two_separator', __( 'Step Two' ) ),
		Field::make( 'text', 'two_title', __( 'Title' ) ),
        Field::make( 'text', 'two_icon', __( 'Icon' ) )->set_help_text( 'Font Awesome class' ),
        Field::make( 'text', 'two_instruction', __( 'Instruction' ) ),

        Field::make( 'separator', 'three_separator', __( 'Step Three' ) ),
		Field::make( 'text', 'three_title', __( 'Title' ) ),
        Field::make( 'text', 'three_icon', __( 'Icon' ) )->set_help_text( 'Font Awesome class' ),
        Field::make( 'text', 'three_instruction', __( 'Instruction' ) ),

        Field::make( 'separator', 'four_separator', __( 'Step Four' ) ),
		Field::make( 'text', 'four_title', __( 'Title' ) ),
        Field::make( 'text', 'four_icon', __( 'Icon' ) )->set_help_text( 'Font Awesome class' ),
        Field::make( 'text', 'four_instruction', __( 'Instruction' ) ),
	) )
	->set_icon( 'camera' )
    ->set_mode( 'both' )
    ->set_editor_style( 'photolab-admin-css' )
	->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {

        ?>
        <div class="carbon-block-guide"
            style="color:<?php echo esc_html( $fields['guide_text_colour'] ); ?>;background-color:<?php echo $fields['guide_background']; ?>;">
            <?php
            if ( $fields['guide_title'] !== '' || $fields['guide_description'] !== '') {
                ?>
                <div class="text-center">
                    <h2><?php echo esc_html( $fields['guide_title'] ); ?></h2>
        			<p><?php echo esc_html( $fields['guide_description'] ); ?></p>
                </div>
                <?php
            }
            ?>
            <div class="carbon-block-guide-instructions">
                <?php
                if ( $fields['one_instruction'] !== '' || $fields['one_title'] !== '' ) {
                    ?>
                    <div class="carbon-block-guide-inst">
						<h4><?php echo esc_attr( $fields['one_title'] ); ?></h4>
                        <span class="<?php echo esc_attr( $fields['one_icon'] ); ?>"></span>
                        <p><?php echo esc_html( $fields['one_instruction'] ); ?></p>
                    </div>
                    <?php
                }
                if ( $fields['two_instruction'] !== '' || $fields['two_title'] !== '' ) {
                    ?>
                    <div class="carbon-block-guide-inst">
						<h4><?php echo esc_attr( $fields['two_title'] ); ?></h4>
                        <span class=" <?php echo esc_attr( $fields['two_icon'] ); ?>"></span>
                        <p><?php echo esc_html( $fields['two_instruction'] ); ?></p>
                    </div>
                    <?php
                }
                if ( $fields['three_instruction'] !== '' || $fields['three_title'] !== '' ) {
                    ?>
                    <div class="carbon-block-guide-inst">
						<h4><?php echo esc_attr( $fields['three_title'] ); ?></h4>
                        <span class=" <?php echo esc_attr( $fields['three_icon'] ); ?>"></span>
                        <h5><?php echo esc_html( $fields['three_instruction'] ); ?></h5>
                    </div>
                    <?php
                }
                if ( $fields['four_instruction'] !== '' || $fields['four_title'] !== '' ) {
                    ?>
                    <div class="carbon-block-guide-inst">
						<h4><?php echo esc_attr( $fields['four_title'] ); ?></h4>
                        <span class=" <?php echo esc_attr( $fields['four_icon'] ); ?>"></span>
                        <h5><?php echo esc_html( $fields['four_instruction'] ); ?></h5>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
			if ( $fields['guide_button_url'] !== 'none' ) {
				?>
				<a class="hero-button-link" href="<?php echo esc_attr( $fields['guide_button_url'] ); ?>"
					style="border-style:solid;border-width:1px;border-color:<?php echo esc_attr( $fields['guide_text_colour'] ) ?>;color:<?php echo esc_attr( $fields['hero_text_colour'] ); ?>;">
					<?php echo esc_html( $fields['guide_button_text'] ); ?>
				</a>
				<?php
			}
			?>
        </div>
		<?php
	} );
?>
