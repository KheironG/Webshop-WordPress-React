<?php

/**
 *
 *
 * @since  1.0
 *
*/
class Photolab_Styles_Scripts {

    function __construct() {
        add_action( 'wp_enqueue_scripts',  array( $this, 'enq_photolab_scripts' ) );
    }

    function enq_photolab_scripts() {

        wp_enqueue_style(
			"photolab-frontend-CSS",
			get_template_directory_uri() . '/static/frontend-style.css',
			[],
			"1.0",
			'all'
		);


    }


}
?>
