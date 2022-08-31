<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title></title>
    <?php wp_head(); ?>
</head>
<body>
<?php
$get_main_menu = wp_get_nav_menu_items( 'main-menu' );
if ( $get_main_menu !== false ) {
    $desktop_menu_items = [];
    $mobile_menu_items = [];
    //Sets items in $menu_items array
    foreach ( $get_main_menu as $menu_item ) {
        if ( $menu_item->menu_item_parent == 0 ) {
            $desktop_menu_items[$menu_item->db_id] = array(
                'parent'   => $menu_item,
                'children' => array()
            );
        }
        $mobile_menu_items[$menu_item->db_id] = $menu_item;
    }
    //DESKTOP MENU LOGIC - If parent has children, add children
    foreach ( $get_main_menu as $menu_item ) {
        if ( $menu_item->menu_item_parent != 0 ) {
            array_push( $desktop_menu_items[$menu_item->menu_item_parent]['children'], $menu_item );
        }
    }

    //MOBILE MENU LOGIC - If parent has children, remove parents
    foreach ( $get_main_menu as $menu_item ) {
        foreach ( $mobile_menu_items as $index => $item ) {
            if ( $index == $menu_item->menu_item_parent ) {
                unset($mobile_menu_items[$index]);
            }
        }
    }
}
?>
<header id="desktop-header">
    <nav>
        <h1>LOGO</h1>
        <ul>
        <?php
        if ( $get_main_menu !== false )  {
            foreach ( $desktop_menu_items as $item ) {
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


<header id="mobile-header">
    <div class="top">
        <h1>LOGO</h1>
        <div>
            <a href="/konto/">
                <i class="fa-solid fa-user fa-lg"></i>
            </a>
            <a href="/cart/">
                <i class="fa-solid fa-cart-shopping fa-lg"></i>
            </a>
        </div>
    </div>
    <div class="bottom">
        <?php
        if ( $get_main_menu !== false )  {
            ?>
            <img src="<?php echo get_template_directory_uri() . '/assets/images/swipe-right.svg' ?>" alt="">
            <nav>
            <?php
            foreach ( $mobile_menu_items as $mobile_menu_item ) {
                ?>
                <a href="<?php esc_attr_e($mobile_menu_item->url) ?>">
                    <?php esc_html_e( $mobile_menu_item->title); ?>
                </a>
                <?php
            }
            ?>
            </nav>
            <?php
        }
        ?>    
    </div>
</header>
<main>
