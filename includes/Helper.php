<?php
namespace Samply;

class Helper {

    /**
	 * The option of this plugin.
	 *
	 * @since	1.0.0
	 * @var	string 
	 */
	public static $_optionName  = 'samply_settings';
	
	/**
	 * The option group of this plugin.
	 *
	 * @since	1.0.0
	 * @var	string 
	 */	
	public static $_optionGroup = 'samply_options_group';
	
	/**
	 * The default option of this plugin.
	 *
	 * @since	1.0.0
	 * @var	array 
	 */	
	public static $_defaultOptions = array(
		'button_label'          => 'Order a Sample',
		'max_qty_per_order'		=> 5,
		'maximum_qty_message'	=> '' 
	);

	/**
	 * Check product is in stock
	 * 
	 * @since	1.0.0
	 * @access	public
	 * @param	none
	 * @return	array
	 */	
	public static function samply_settings() {
		return wp_parse_args( get_option(self::$_optionName), self::$_defaultOptions );
	}	
	
	/**
	 * Check product is in stock
	 * 
	 * @since	1.0.0
	 * @access	public
	 * @param	none
	 * @return	integer
	 */	
	public static function product_is_in_stock( $prodId = NULL ) {
		if( $prodId ){
			$product = wc_get_product($prodId);
		} else {
			global $product;
		}
       
        return $product->is_in_stock();
	}
	
	/**
	 * Check product already is in cart
	 * 
	 * @since	1.0.0
	 * @access	public
	 * @param	none$product_id
	 * @return	boolean
     */
	public static function check_is_in_cart( $product_id ) {
        // Make sure it's only on front end
        if (is_admin()) return false;

        defined( 'WC_ABSPATH' ) || exit;

        include_once WC_ABSPATH . 'includes/wc-cart-functions.php';
        include_once WC_ABSPATH . 'includes/class-wc-cart.php';

		global $woocommerce;
		$setting_options   = self::samply_settings();
		$disable_limit 	   = isset( $setting_options['disable_limit_per_order'] ) ? $setting_options['disable_limit_per_order'] : null;
		$notice_type 	   = isset( $setting_options['limit_per_order'] ) ? $setting_options['limit_per_order'] : 'all';

        if ( is_null( WC()->cart ) ) {
            wc_load_cart();
        }

        if( isset( $disable_limit ) ) {
			return TRUE;
        } else {
			foreach( $woocommerce->cart->get_cart() as $val ) {
				if( 'product' == $notice_type ) {
					if( ( isset( $val['free_sample'] ) && $product_id == $val['free_sample'] ) && ( $setting_options['max_qty_per_order'] <= $val['quantity'] ) ) {
						return FALSE;
					}
				} else if( 'all' == $notice_type ) {
					if( ( isset( $val['free_sample'] ) ) && ( $setting_options['max_qty_per_order'] <= self::cart_total() ) ) {
						return FALSE;
					}
				} 
			}	
		} 
		
		return TRUE; 
	}

	/**
	 * Check product quantity is in cart
	 * 
     * @since	1.0.0
	 * @access	public
	 * @param	none
     * @return	string
	 */	
	public static function cart_total( ) {
		global $woocommerce;
		$total = 0;
		foreach( $woocommerce->cart->get_cart() as $key => $val ) {
			if( isset( $val['free_sample'] ) ) {				
				$total += $val['quantity'];
			}
		}
		return $total;
	}		

	/**
	 * Check product type in product details page
	 * 
     * @since	1.0.0
	 * @access	public
	 * @param	none
     * @return	string|null
	 */	
	public static function product_type() {
		global $product;
		if( $product->is_type( 'simple' ) ) {
			return 'simple';
		} else if( $product->is_type( 'variable' ) ) {
			return 'variable';
		} else {
			return NULL;
		}
    }

    /**
     * Display sample button
	 * 
     * @since	1.0.0
	 * @access	public
     * @return	string
     */
    public static function request_button() : string {
        $button = '';
		$setting = Helper::samply_settings();
        $button_label = isset( $setting['button_label'] ) ? sprintf(__( '%s', 'samply' ),$setting['button_label']) : __( 'Order a Sample', 'samply' );
		
		switch (self::product_type()) {
			case 'simple':
				$button = sprintf(
					'<button type="submit" name="simple-add-to-cart" value="%d" id="samply-button" class="samply-button">%s</button>',
					get_the_ID(),
					$button_label
				);
				break;
			case 'variable':
				$button = sprintf(
					'<button type="submit" name="variable-add-to-cart" value="%d" id="samply-button" class="samply-button">%s</button>',
					get_the_ID(),
					$button_label
				);
				break;
			default:
				break;
		}

		return $button;
    }

    /**
     * Retrieve button label
	 * 
     * @since	1.0.0
	 * @access	public
     * @return	string
     */
	public static function button_text() : string {
		$setting_options   = self::samply_settings();
		return isset( $setting_options['button_label'] ) ? esc_html__( $setting_options['button_label'], 'samply' ) : esc_html__( 'Order a Free Sample', 'samply' );
	}

    /**
     * Return sample price
	 * 
	 * @since	1.0.0
	 * @access	public
	 * @param	integer
     * @return	mixed|null
     */
	public static function sample_price( $product_id ): mixed {
		return apply_filters( 'samply_price', 0.00, $product_id );
	}

	/**
	 * Sample Qty
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	none
     * @return	void
	 */		
	public static function sample_qty() { 
		if ( class_exists( 'SPQ_Smart_Product_Quantity' ) ) {
			return empty( $_REQUEST['quantity'] ) ? 1 : wc_stock_amount( wp_unslash( $_REQUEST['quantity'] ) ); 
		}
		
		return 1;
	}

	/**
	 * Check dokan seller
	 *
     * @since	1.0.0
     * @access	public
	 * @param	integer
     * @return	boolean
	 */		
	public static function dokan_is_user_seller( $user_id ) {
		if ( ! user_can( $user_id, 'dokandar' ) ) {
			return false;
		}
	
		return true;
	}

	/**
	 * Check PRO is exists
	 *
     * @since   1.0.0
     * @access  public
     * @param   none
     * @return	boolean
	 */		
	public static function is_pro() {
		return class_exists('SamplyPro');
	}

}