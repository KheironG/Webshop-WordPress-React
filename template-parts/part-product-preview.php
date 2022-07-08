<div class="photolab-product-preview">
    <div class="image-container">
        <img src="<?php echo wp_get_attachment_url( $args->image_id ); ?>" alt="">
    </div>
    <p><?php echo $args->name; ?></p>
    <h5><?php echo $args->price; ?></h5>
    <a class="more-info-button" href="#"><?php echo __('Mer info'); ?></a>
    <a class="select-product-button" href="#"><?php echo __('köp'); ?></a>
</div>
