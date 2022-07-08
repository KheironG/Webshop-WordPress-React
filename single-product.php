<?php
get_header();

print_r($post);

$get_image_term = get_term_by( 'name', 'images', 'product_cat' );
$get_image_categories = get_term_children( $get_image_term->term_id, 'product_cat' );


?>
<div class="photolab-gallery-preview">
    <img src="" alt="">
    <h5>Title</h5>
    <p>Price</p>
    <a href="#">More info</a>
    <a href="#">Select</a>
</div>
<?php
get_footer();
?>
