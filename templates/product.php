<?php
/**
* Template Name: Product
*
* @since Photolab 1.0
*/
get_header();
?>
<div class="page-header">
    <h2><?php esc_html_e( get_the_title() ); ?></h2>
    <p><?php esc_html_e( get_the_excerpt() )  ?></p>
</div>
<?php
the_content();
get_footer();
?>
