<?php
/**
* Template Name: Gallery
*
* @since Art Shop 1.0
*/
get_header();
the_content();
echo do_shortcode('[photolab-gallery-app]');

?>
<div class="flex-center-column bg-orange-600">
    <p>test</p>
</div>
<?php
get_footer();
?>
