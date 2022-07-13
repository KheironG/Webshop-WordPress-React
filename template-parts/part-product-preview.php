<?php
$price_style = !empty( $args->sale_price ) ? 'line-through' : null;
$sale_price  = !empty( $args->sale_price ) ? '<h5 class="red">'. wc_price( $args->sale_price ) .'</h5>' : null;
$price_diff  = !empty( $args->sale_price ) ? ( 1 - $args->regular_price / $args->sale_price ) * 100 : null;
$discount    = !empty( $args->sale_price ) ? '<h5 class="red">'. round( intval( $price_diff ) ) .'%</h5>' : null;
if ( $args->image_id ) {
    $image = wp_get_attachment_image_src( $args->image_id, 'full'  );
}
if ( $args->id ) {
    $image = wp_get_attachment_image_src( get_post_thumbnail_id( $args->id ), 'full'  );
}
$image_class = $image[1] > $image[2] ? "landscape-img" : "portrait-img" ;
?>

<div class="photolab-product-preview">
    <div class="image-container">
        <img class="<?php echo $image_class; ?>" src="<?php echo $image[0]; ?>" alt=""></img>
    </div>
    <div class="info-container">
        <p><?php echo $args->name; ?></p>
        <div class="flex-start-center c-gap-20">
            <?php echo $sale_price; ?>
            <div class="flex-start-center c-gap-10">
                <h5 class="<?php echo $price_style; ?>"><?php echo wc_price( $args->regular_price ); ?></h5>
                <?php echo $discount; ?>
            </div>
        </div>
    </div>
    <div class="button-container">
        <!-- <a class="more-info-button" href="<?php echo $permalink; ?>"><?php echo __('Mer info'); ?></a> -->
        <a class="select-product-button" href="#"><?php echo __('välj'); ?></a>
    </div>
</div>
