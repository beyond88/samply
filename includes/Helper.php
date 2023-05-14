<?php

namespace Samply;

class Helper {

    /**
	 * The option of this plugin.
	 *
	 * @since    1.0.0
	 * @param    string 
	 */
	public static $_optionName  = 'samply_settings';
	
	/**
	 * The option group of this plugin.
	 *
	 * @since    1.0.0
	 * @param    string 
	 */	
	public static $_optionGroup = 'samply_options_group';
	
	/**
	 * The default option of this plugin.
	 *
	 * @since    1.0.0
	 * @param    array 
	 */	
	public static $_defaultOptions = array(
		'button_label'          => 'Order a Sample',
		'max_qty_per_order'		=> 5,
		'maximum_qty_message'	=> '' 
	);

	/**
	 * Check product is in stock
	 * 
	 * @since    1.0.0
	 * @param    none
	 */	
	public static function samply_settings() {
		return wp_parse_args( get_option(self::$_optionName), self::$_defaultOptions );
	}	
	
	/**
	 * Check product is in stock
	 * 
	 * @since    1.0.0
	 * @param    none
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
	 * @param    none$product_id
	 *@since    1.0.0
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
	 * @since    1.0.0
	 * @param    none
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
	 * @since    1.0.0
	 * @param    none
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
     * @return string
     * @since    1.0.0
     */
    public static function request_button() : string {
        $button = match (self::product_type()) {
            "simple" => '<button type="submit" name="simple-add-to-cart" value="' . get_the_ID() . '" id="samply-button" class="samply-button">' . sprintf(esc_html__('%s', 'samply'), self::button_text()) . '</button>',
            "variable" => '<button type="submit" name="variable-add-to-cart" value="' . get_the_ID() . '" id="samply-button" class="samply-button">' . sprintf(esc_html__('%s', 'samply'), self::button_text()) . '</button>',
            default => '',
        };
        return $button; 
    }

    /**
     * Retrieve button label
     *
     * @return string
     * @since    1.0.0
     */
	public static function button_text() : string {
		$setting_options   = self::samply_settings();
		return isset( $setting_options['button_label'] ) ? esc_html__( $setting_options['button_label'], 'samply' ) : esc_html__( 'Order a Free Sample', 'samply' );
	}

    /**
     * Return sample price
     * @return mixed|null
     * @since    1.0.0
     */
	public static function sample_price( $product_id ): mixed {
		return apply_filters( 'samply_price', 0.00, $product_id );
	}

	/**
	 * Sample Qty
	 *
	 * @since    1.0.0
	 * @param    none
     * @return   void
	 */		
	public static function sample_qty() { 

		if ( class_exists( 'SPQ_Smart_Product_Quantity' ) ) {
			return empty( $_REQUEST['quantity'] ) ? 1 : wc_stock_amount( wp_unslash( $_REQUEST['quantity'] ) ); 
		}
		
		return 1;
	}

	/**
	 * Retrieve all products in the store
	 *
	 * @since    1.0.0
	 * @param    none
     * @return   array
	 */	
	public static function products() {
		
		global $wpdb;
		$table 	= $wpdb->prefix . 'posts'; 
		$sql 	= $wpdb->prepare("SELECT ID, `post_title` FROM $table WHERE `post_type` = %s AND `post_status`= 'publish' ORDER BY post_title", 'product');
		$data 	= [];
		$data 	= $wpdb->get_results($sql, ARRAY_A);
		return $data;

	}

	/**
	 * Retrieve all categories of the products
	 *
	 * @since    1.0.0
	 * @param    none
     * @return   array
	 */	
	public static function categories() {

		$orderby 	= 'name';
		$order 		= 'asc';
		$hide_empty = false ;
		$cat_args 	= array(
			'orderby'    => $orderby,
			'order'      => $order,
			'hide_empty' => $hide_empty,
		);

		$data 		= array();
		$categories = get_terms( 'product_cat', $cat_args );
		$inc 		= 0;
		foreach( $categories as $cat ) {
			$data[$inc]['ID']  		   = $cat->term_id;
			$data[$inc]['post_title']  = $cat->name;
			$inc++;
		}
		return $data;

    }

	/**
	 * Check dokan seller
	 *
	 * @since    1.0.0
	 * @param    integer
     * @return   boolean
	 */		
	public static function dokan_is_user_seller( $user_id ) {
		if ( ! user_can( $user_id, 'dokandar' ) ) {
			return false;
		}
	
		return true;
	}

}