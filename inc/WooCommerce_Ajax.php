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
              [ 'version' => 'wc/v3' ]
        );

        $task = filter_var( $_GET['task'], FILTER_SANITIZE_STRING );
        $limit = filter_var( $_GET['limit'], FILTER_VALIDATE_INT );
        $offset = filter_var( $_GET['offset'], FILTER_SANITIZE_NUMBER_INT );
        $category = filter_var( $_GET['category'], FILTER_SANITIZE_STRING );
        $attributes = explode( ',' , filter_var( $_GET['attributes'], FILTER_SANITIZE_STRING ) );
        $category_param = $task == 'get' ? 'category' : 'categories';

        //Constructs tax_query logic
        $attributes_array = [];
        foreach ( $attributes as $attribute ) {
            $instance = explode( ":", $attribute );
            if ( !array_key_exists( $instance[0], $attributes_array )) {
                $attributes_array[$instance[0]] = [];
            }
        }
        foreach ( $attributes as $attribute ) {
            $instance = explode( ":", $attribute );
            array_push(
                $attributes_array[$instance[0]],
                filter_var( $instance[1], FILTER_SANITIZE_NUMBER_INT )
            );
        }
        $filters_tax_query = [ 'relation' => 'AND', ];
        foreach ( $attributes_array as $key => $attribute ) {
            $tax_query['taxonomy'] = filter_var( $key, FILTER_SANITIZE_STRING );
            $tax_query['fields'] = 'term_id';
            $tax_query['terms'] = $attribute;
            $tax_query['operators'] = 'IN';
            array_push( $filters_tax_query, $tax_query );
        }

        //Product query starts here
        $query = new WC_Product_Query( array(
					 'limit' => 25,
					 'status' => 'publish',
					 'tax_query' => $filters_tax_query,
					) );
		$get_products = $query->get_products();
        $products = [];
        foreach ( $get_products as $product ) {
            array_push( $products, $product->get_data() );
        }

        echo json_encode( $products );
        exit;

        // if ( $task === 'total' ) {
        //     $count = get_term( intval( $category ), 'product_cat' );
        //     echo json_encode($count->count);
        //     exit;
        // }

        // $query = $woocommerce->get( 'products', [ 'status' => 'publish', $category_param => $category, 'per_page' => $limit, 'offset' => $offset ] );
        //
        // ob_start();
        // foreach ( $query as $args ) {
        //     get_template_part( 'template-parts/part', 'product-preview', $args );
        // }
        // echo ob_get_clean();
        // exit;
    }

}

?>
