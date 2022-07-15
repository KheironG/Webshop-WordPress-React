<?php
/**
 *
 */
class Photolab_Shortcodes
{

    function __construct()
    {
        add_shortcode( 'photolab-registration-form',  array( $this, 'photolab_registration_form' ) );
        add_shortcode( 'photolab-login-form', array( $this, 'photolab_login_form' ) );
        add_shortcode('photolab-my-orders', array( $this, 'photolab_my_orders' ) );
    }

    function photolab_my_orders( $atts ) {
        extract( shortcode_atts( array(
            'order_count' => -1
        ), $atts ) );

        ob_start();
        get_template_part( 'template-parts/part', 'my-orders', array(
            'current_user'  => get_user_by( 'id', get_current_user_id() ),
            'order_count'   => $order_count
        ) );
        return ob_get_clean();
    }



    function photolab_login_form() {
        if ( is_admin() ) return;
        if ( is_user_logged_in() ) return;
        ob_start();
        woocommerce_login_form( array( 'redirect' => 'your-url' ) );
        return ob_get_clean();
    }


    function photolab_registration_form() {

        if ( is_admin() ) return;
        if ( is_user_logged_in() ) return;
        ob_start();

        do_action( 'woocommerce_before_customer_login_form' );

        ?>
        <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

             <?php do_action( 'woocommerce_register_form_start' ); ?>

             <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                   <label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?> <span class="required">*</span></label>
                   <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                </p>

             <?php endif; ?>

             <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                <label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
                <input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
             </p>

             <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

                <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
                   <label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
                   <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
                </p>

             <?php else : ?>

                <p><?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?></p>

             <?php endif; ?>

             <?php do_action( 'woocommerce_register_form' ); ?>

             <p class="woocommerce-FormRow form-row">
                <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                <button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Register', 'woocommerce' ); ?></button>
             </p>

             <?php do_action( 'woocommerce_register_form_end' ); ?>

        </form>
        <?php

        return ob_get_clean();

    }

}
?>
