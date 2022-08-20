<?php
/**
* Template Name: Gallery App
*
* @since Photolab 1.0
*/
get_header(); ?>

<main>
    <?php
    the_content();
    echo do_shortcode('[photolab-gallery-app]');
    ?>
</main>

<?php get_footer(); ?>
