<?php
/**
 *
 */

use Automattic\WooCommerce\Client;

class WooCommerce_Ajax
{

    function __construct()
    {
        add_action( 'wp_enqueue_scripts',  array( $this, 'woocommerce_ajax' ) );
        add_action( 'wp_ajax_photolab_ajax',  array( $this, 'photolab_woocommerce_ajax_cb' ) );
        add_action( 'wp_ajax_nopriv_photolab_ajax',  array( $this, 'photolab_woocommerce_ajax_cb' ) );
    }

    function woocommerce_ajax( ) {
        wp_enqueue_script( 'photolab-woocommerce-ajax',
            get_template_directory_uri().'/assets/js/woocommerce-ajax.js',
            []
        );
        wp_localize_script( 'photolab-woocommerce-ajax',
            'woocommerce_ajax',
            array(
                'ajax_url'         => admin_url( 'admin-ajax.php' ),
                'nonce'            => wp_create_nonce('photolab-woocommerce-ajax'),
        ));
    }

    function photolab_woocommerce_ajax_cb() {

        $woocommerce = new Client(
              get_home_url(),
              'ck_3ed122b0cb9c2b77ed3cc89f3fa5feda77c20097',
              'cs_195f5acafb97d3ce7609d48b2a74a0efc4c66bd3',
              [
                'version' => 'wc/v3',
              ]
        );

        $task = $_GET['task'];
        $limit = $_GET['limit'];
        $offset = $_GET['offset'];
        $category = $_GET['category'];
        $category_param = $task === 'get' ? 'category' : 'categories';

        $response = $woocommerce->get( 'products', [ 'status' => 'publish', $category_param => $category, 'limit' => $limit, 'offset' => $offset ] );
        echo json_encode($response);
        exit;

    }

}

?>
