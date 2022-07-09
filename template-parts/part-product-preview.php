<?php
$price_style = !empty( $args->sale_price ) ? 'line-through' : '';
$sale_price =  !empty( $args->sale_price ) ? '<h5 class="red">'.$args->sale_price.'</h5>' : '';
?>

<div class="photolab-product-preview">
    <div class="image-container">
        <img src="<?php echo wp_get_attachment_url( $args->image_id ); ?>" alt="">
    </div>
    <div class="info-container">
        <p><?php echo $args->name; ?></p>
        <div class="flex-start-center c-gap-20">
            <?php echo $sale_price; ?>
            <h5 class="<?php echo $price_style; ?>"><?php echo $args->price; ?></h5>
        </div>
    </div>
    <div class="button-container">
        <a class="more-info-button" href="#"><?php echo __('Mer info'); ?></a>
        <a class="select-product-button" href="#"><?php echo __('välj'); ?></a>
    </div>
</div>
