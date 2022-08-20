<?php
/**
* Template Name: Photolab My Account
*
* @since Photolab 1.0
*/

get_header();

if ( is_user_logged_in() ) {

    the_content();

    ?>
    <div class="my-account-container box-shadow">
        <div class="buttons">
            <div id="sign-in-button" class="button">
                <?php echo __('Dashboard'); ?>
            </div>
            <div id="sign-up-button" class="button button-inactive">
                <?php echo __('orders'); ?>
            </div>
            <div id="sign-up-button" class="button button-inactive">
                <?php echo __('addresses'); ?>
            </div>
            <div id="sign-up-button" class="button button-inactive">
                <?php echo __('addresses'); ?>
            </div>
        </div>
            <?php
            function get_all_orders() {
                $customer_orders = get_posts(apply_filters('woocommerce_my_account_my_orders_query', array(
                    'numberposts' => -1,
                    'meta_key' => '_customer_user',
                    'meta_value' => get_current_user_id(),
                    'post_type' => wc_get_order_types('view-orders'),
                    'post_status' => array_keys(wc_get_order_statuses())
                )));
                return $customer_orders;
            }
            print_r( get_all_orders() );
            ?>
    </div>

    <script type="text/javascript">
        (function() {

            document.addEventListener('DOMContentLoaded', initialize);

            function initialize() {

                let $signInButton = document.getElementById('sign-in-button');
                let $signUpButton = document.getElementById('sign-up-button');

                let $signInForm = document.getElementById('sign-in-form');
                let $signUpForm = document.getElementById('sign-up-form');

                $signInButton.addEventListener('click', toggleForms);
                $signUpButton.addEventListener('click', toggleForms);

                $signUpForm.classList.add('hidden');

                function toggleForms() {
                    if ( event.target.id === 'sign-in-button' ) {
                        $signInButton.classList.remove('button-inactive');
                        $signUpButton.classList.add('button-inactive');
                        $signInForm.classList.remove('hidden');
                        $signUpForm.classList.add('hidden');
                    } else {
                        $signInButton.classList.add('button-inactive');
                        $signUpButton.classList.remove('button-inactive');
                        $signInForm.classList.add('hidden');
                        $signUpForm.classList.remove('hidden');
                    }
                }

            }
        }());
    </script>
    <?php

} else {

    wp_redirect( get_home_url() . '/login' );
    exit;

}

get_footer(); ?>
