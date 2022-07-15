<?php
/**
* Template Name: Photolab login
*
* @since Photolab 1.0
*/

get_header();

if ( !is_user_logged_in() ) {

    the_content();

    ?>
    <div class="login-container box-shadow">
        <div class="buttons">
            <div id="sign-in-button" class="button">
                <?php echo __('logga in'); ?>
            </div>
            <div id="sign-up-button" class="button button-inactive">
                <?php echo __('registrera'); ?>
            </div>
        </div>
        <div id="sign-in-form">
            <h3 class="orange-600"><?php echo __('logga in'); ?></h3>
            <?php echo do_shortcode('[photolab-login-form]'); ?>
        </div>
        <div id="sign-up-form" class="hidden">
            <h3 class="orange-600"><?php echo __('registrera'); ?></h3>
            <?php echo do_shortcode('[photolab-registration-form]'); ?>
        </div>
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

    wp_redirect( get_home_url() . '/my-account' );
    exit;

}

get_footer(); ?>
