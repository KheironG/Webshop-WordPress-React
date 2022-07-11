<?php
get_header();
$product = wc_get_product( $post->ID );
$price_style = !empty( $product->sale_price ) ? 'line-through' : '';
$sale_price =  !empty( $product->sale_price ) ? '<h4 class="red">'.wc_price( $product->sale_price ).'</h4>' : '';
?>

<div class="photolab-single-product">
    <div class="single-product-images">
        <img src="<?php echo esc_attr( wp_get_attachment_url( $product->get_image_id() ) ); ?>" alt="">
    </div>
    <div class="single-product-info">
        <h2><?php echo esc_html_e( $post->post_title ); ?></h2>
        <div class="flex-start-center c-gap-20">
            <?php echo $sale_price; ?>
            <h4 class="<?php echo $price_style; ?>"><?php echo wc_price( $product->price ); ?></h4>
        </div>
        <p><?php echo esc_html_e( $product->short_description ); ?></p>
        <a href="#" class="select-product-button"> <?php echo __( 'välj och fortsätt' );  ?></a>
    </div>
</div>
<?php
get_footer();
?>
