<?php
// $price_style = !empty( $args->sale_price ) ? 'line-through' : null;
// $sale_price  = !empty( $args->sale_price ) ? '<h5 class="red">'. wc_price( $args->sale_price ) .'</h5>' : null;
// $price_diff  = !empty( $args->sale_price ) ? ( 1 - $args->regular_price / $args->sale_price ) * 100 : null;
// $discount    = !empty( $args->sale_price ) ? '<h5 class="red">'. round( intval( $price_diff ) ) .'%</h5>' : null;

$price = $args->get_type() === 'variable' ? $args->get_variation_price( 'min' ) : $args->get_price();
$price_from = $args->get_type() === 'variable' ? '<span class="price-from">från </span>' : null;
$image = wp_get_attachment_image_src( $args->image_id, '' );
$image_class = $image[1] > $image[2] ? "landscape-img" : "portrait-img";
?>
<div class="product">
    <div class="image">
        <img class="<?php echo $image_class; ?>" src="<?php esc_attr_e( $image[0] ); ?>" alt="">
    </div>
    <h5><?php esc_html_e( $args->name ); ?></h5>
    <div class="price">
        <?php echo $price_from; ?>
        <h5><?php echo wc_price( $price ); ?></h5>
    </div>
</div>
<?php
