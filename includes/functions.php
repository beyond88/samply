<?php 

if( class_exists( 'BeRocket_MM_Quantity' ) ) 
{
    add_action( 'woocommerce_after_calculate_totals', 'samply_new_calculate_total', 10, 1 );
    if( ! function_exists( 'samply_new_calculate_total' ) ) {
        function samply_new_calculate_total()
        {
            if( samply_check_product_sample_is_added_in_cart() == true ) {
                add_action( 'woocommerce_after_cart_table',  'samply_footer_hide' );
                add_action( 'woocommerce_after_mini_cart',  'samply_footer_hide' );
            }    
        }
    }
    
    if( ! function_exists( 'samply_footer_hide' ) ) {
        function samply_footer_hide() 
        {
            echo '<style>
                .checkout-button{display:block!important;}
                .checkout{display:block!important;}
            </style>';
        }
    }
    
    if( ! function_exists( 'samply_check_product_sample_is_added_in_cart' ) ) {
        function samply_check_product_sample_is_added_in_cart() 
        {
            foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
                if( isset( $cart_item['free_sample'] ) && isset( $cart_item['sample_price'] ) ) {
                    return true;
                }
            }
            return false;
        }
    }
}



/**
 * Admin notice if WooCommerce is missing
 * @return void
 */
if( ! function_exists( 'samply_woocommerce_missing_wc_notice' ) ) {
    function samply_woocommerce_missing_wc_notice() 
    {
        $screen = get_current_screen();
    
        if( ( $screen->base == 'toplevel_page_samply' ) )
        {
            $samply_notice = sprintf(
                __( 'samply requires WooCommerce to be installed and active to working properly. %s', 'samply' ),
                '<a href="' . esc_url( admin_url( 'plugin-install.php?s=WooCommerce&tab=search&type=term' ) ) . '">' . __( 'Please click on this link and install WooCommerce', 'samply' ) . '</a>'
            );
            printf( '<div class="error notice notice-warning is-dismissible"><p style="padding: 5px 0">%s</p></div>', $samply_notice );
        }
    }
}


/**
 * Thing need to process once the samply plugin activation is done and loaded.
 * @return void
 */
add_action( 'admin_init', 'samply_get_started' );

if( ! function_exists( 'samply_get_started' ) ) {
    function samply_get_started() 
    {    
        if ( ( is_admin() && current_user_can( 'activate_plugins' ) &&  ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) ) {
            add_action( 'admin_notices', 'samply_woocommerce_missing_wc_notice' );
        }
    }
}