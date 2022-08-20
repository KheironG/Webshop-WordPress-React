<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title></title>
    <?php wp_head(); ?>
</head>
<body>
<header>
    <h1>LOGO</h1>
    <div class="mobile-menu">
        <a href="/konto/">
            <i class="fa-solid fa-user fa-lg"></i>
        </a>
        <a href="/cart/">
            <i class="fa-solid fa-cart-shopping fa-lg"></i>
        </a>
        <div class="hamburger" id="hamburger" onclick="toggleMobileMenu(this);">
            <i class="fa-solid fa-bars fa-lg"></i>
        </div>
    </div>

    <nav class="main-menu" id="main-menu">
        <div class="hamburger-close" id="hamburger-close" onclick="toggleMobileMenu(this);">
            <i class="fa-solid fa-xmark fa-lg"></i>
        </div>
        <h1>LOGO</h1>
        <?php
        $get_main_menu = wp_get_nav_menu_items( 'main-menu' );
        $menu_items = [];
        //Sets items in $menu_items array
        foreach ( $get_main_menu as $menu_item ) {
            if ( $menu_item->menu_item_parent == 0 ) {
                $menu_items[$menu_item->db_id] = array(
                    'parent'   => $menu_item,
                    'children' => array()
                );
            }
        }
        //If parent has children, add children
        foreach ( $get_main_menu as $menu_item ) {
            if ( $menu_item->menu_item_parent != 0 ) {
                array_push( $menu_items[$menu_item->menu_item_parent]['children'], $menu_item );
            }
        }
        ?>
        <ul>
            <?php
            foreach ( $menu_items as $item ) {
                if ( empty( $item['children'] ) ) {
                    ?>
                    <li class="parent">
                        <a href="<?php echo $item['parent']->url; ?>">
                            <?php esc_html_e( $item['parent']->title ); ?>
                        </a>
                    </li>
                    <?php
                } else {
                    $title = esc_html( $item['parent']->title );
                    ?>
                    <li class="parent-expander" onclick="mainMenu(this);">
                            <?php echo $title; ?>
                    <i class="fa-solid fa-angle-down"></i>
                    </li>
                        <ul class="menu-children hidden" id="<?php echo strtolower( $title ); ?>-children">
                            <?php
                            foreach ( $item['children'] as $child ) {
                                ?>
                                <li class="child">
                                    <a href="<?php echo $child->url; ?>">
                                        <?php esc_html_e( $child->title ); ?>
                                    </a>
                                </li>
                                <?php
                            }
                             ?>
                        </ul>
                    <?php
                }
            }
            ?>
        </ul>
        <div class="nav-icons">
            <a href="/konto/">
                <i class="fa-solid fa-user fa-lg"></i>
            </a>
            <a href="/cart/">
                <i class="fa-solid fa-cart-shopping fa-lg"></i>
            </a>
        </div>
    </nav>

</header>
<main>
