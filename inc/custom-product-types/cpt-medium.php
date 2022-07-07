<?php

/**
 * Image Product Type
 */
class Photolab_Product_Medium extends WC_Product {

    public function get_type() {
        return 'medium';
    }

     public function get_price( $context = 'view' ) {

        if ( current_user_can('manage_options') ) {
            $price = $this->get_meta( '_member_price', true );
            if ( is_numeric( $price ) ) {
                return $price;
            }

        }
		return $this->get_prop( 'price', $context );
      }
}

?>
