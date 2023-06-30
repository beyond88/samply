<?php 

/**
 * Handle compability with BeRocket
 * 
 * @since   1.0.0
 * @return  void
 */
if( class_exists( 'BeRocket_MM_Quantity' ) ) {
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
 * 
 * @since   1.0.0
 * @param   nonne
 * @return  void
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
 * 
 * @since   1.0.0
 * @param   nonne
 * @return  void
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

/**
 * Get a refreshed cart fragment, including the mini cart HTML.
 *
 * @since    1.0.0
 * @param    string
 * @return   void
 */		
function get_samply_refreshed_fragments() {
    ob_start();

    woocommerce_mini_cart();
    $mini_cart = ob_get_clean();
    $data = array(
        'fragments' => apply_filters(
            'woocommerce_add_to_cart_fragments',
            array(
                'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>',
            )
        ),
        'cart_hash' => WC()->cart->get_cart_hash(),
    );

    wp_send_json( $data );
}

/**
 * Ajax add to cart and 
 * add samply to the cart.
 *
 * @since    1.0.0
 * @param    none
 * @return   array | json
 */	
function samply_ajax_add_to_cart() {
    ob_start();

    $data = $_POST['data'];

    if ( ! isset( $data['product_id'] ) ) {
    	return;
    }

    $product_id        = apply_filters( 'woocommerce_add_to_cart_product_id', absint( $data['product_id'] ) );
    $product           = wc_get_product( $product_id );
    $quantity          = empty( $data['quantity'] ) ? 1 : wc_stock_amount( wp_unslash( $data['quantity'] ) );
    $passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );
    $product_status    = get_post_status( $product_id );
    $variation_id      = 0;
    $variation         = array();

    if ( $product && 'variation' === $product->get_type() ) {
    	$variation_id = $product_id;
    	$product_id   = $product->get_parent_id();
    	$variation    = $product->get_variation_attributes();
    }

    $cart_item_data = array(
    	'free_sample'  => $data['product_id'],
    	'sample_price' => apply_filters( 'sample_price', 0, $data['product_id'] ),
    	'line_subtotal'=> apply_filters( 'sample_price', 0, $data['product_id'] ),
    	'line_total'   => apply_filters( 'sample_price', 0, $data['product_id'] ),
    );

    if ( $passed_validation && false !== WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variation, $cart_item_data ) && 'publish' === $product_status ) {
        
    	do_action( 'woocommerce_ajax_added_to_cart', $product_id );

    	if ( 'yes' === get_option( 'woocommerce_cart_redirect_after_add' ) ) {
    		wc_add_to_cart_message( array( $product_id => $quantity ), true );
    	}

    	get_samply_refreshed_fragments();

    } else {

    	$data = array(
    		'error'       => true,
    		'product_url' => apply_filters( 'woocommerce_cart_redirect_after_error', get_permalink( $product_id ), $product_id ),
    	);

    	wp_send_json( $data );
    }

}

add_action( 'wp_ajax_add_to_cart', 'samply_ajax_add_to_cart' );
add_action( 'wp_ajax_nopriv_add_to_cart', 'samply_ajax_add_to_cart' );