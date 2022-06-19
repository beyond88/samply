<?php

namespace Samply;

class Helper 
{

    /**
	 * The option of this plugin.
	 *
	 * @since    2.0.0
	 * @param    string 
	 */
	public static $_optionName  = 'samply_settings';
	
	/**
	 * The option group of this plugin.
	 *
	 * @since    2.0.0
	 * @param    string 
	 */	
	public static $_optionGroup = 'samply_options_group';
	
	/**
	 * The default option of this plugin.
	 *
	 * @since    2.0.0
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
	 * @since    2.0.0
	 * @param    none
	 */	
	public static function samplySettings() 
	{
		return wp_parse_args( get_option(self::$_optionName), self::$_defaultOptions );
	}	
	
	/**
	 * Check product is in stock
	 * 
	 * @since    2.0.0
	 * @param    none
	 */	
	public static function productIsInStock() 
	{
        global $product;
        return $product->is_in_stock(); 
	}
	
	/**
	 * Check product already is in cart
	 * 
	 * @since    2.0.0
	 * @param    none
	 */	
	public static function checkIsInCart( $product_id ) 
	{ 

		global $woocommerce;
		$setting_options   = self::samplySettings();
		$disable_limit 	   = isset( $setting_options['disable_limit_per_order'] ) ? $setting_options['disable_limit_per_order'] : null;
		$notice_type 	   = isset( $setting_options['limit_per_order'] ) ? $setting_options['limit_per_order'] : 'all';

		if( isset( $disable_limit ) ) {
			return TRUE;
		}  else {
			foreach( $woocommerce->cart->get_cart() as $key => $val ) {
				if( 'product' == $notice_type ) {
					if( ( isset( $val['free_sample'] ) && $product_id == $val['free_sample'] ) && ( $setting_options['max_qty_per_order'] <= $val['quantity'] ) ) {
						return FALSE;
					}
				} else if( 'all' == $notice_type ) {
					if( ( isset( $val['free_sample'] ) ) && ( $setting_options['max_qty_per_order'] <= self::cartTotal() ) ) {
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
	 * @since    2.0.0
	 * @param    none
	 */	
	public static function cartTotal( )
	{

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
	 * @since    2.0.0
	 * @param    none
	 */	
	public static function productType() 
	{
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
	 * @since    2.0.0
	 * @param    none
	 */    
    public static function requestButton() 
	{

        $button  = '';
        switch ( self::productType() ) {
            case "simple":
                $button = '<button type="submit" name="simple-add-to-cart" value="'.get_the_ID().'" id="samply-button" class="samply-button">'.sprintf( esc_html__( '%s', 'samply' ), self::buttonText() ).'</button>';
                break;
            case "variable":
                $button = '<button type="submit" name="variable-add-to-cart" value="'.get_the_ID().'" id="samply-button" class="samply-button">'.sprintf( esc_html__( '%s', 'samply' ), self::buttonText() ).'</button>';
                break;			
            default:
                $button = '';
        }         
        return $button; 
    }
    
	/**
	 * Retrive button label	
	 * 
	 * @since    2.0.0
	 * @param    none
	 */	
	public static function buttonText() 
	{
		$setting_options   = self::samplySettings();
		return isset( $setting_options['button_label'] ) ? esc_html__( $setting_options['button_label'], 'samply' ) : esc_html__( 'Order a Free Sample', 'samply' );
	}
	
	/**
	 * Return sample price
	 * 
	 * @since    2.0.0
	 * @param    none
	 */
	public static function samplePrice( $product_id ) 
	{		
		return apply_filters( 'samply_price', 0.00, $product_id );
	}

	/**
	 * Sample Qty
	 *
	 * @since    1.0.0
	 * @param    none
     * @return   void
	 */		
	public static function sampleQty() 
	{ 

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
	public static function products() 
	{
		
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
	public static function categories() 
	{

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
	 * Get all shipping classes
	 *
	 * @since    1.0.0
	 * @param    none
     * @return   void
	 */	
	public static function shippingClass() 
	{

		$data 		= array();
		$data[-1] 	= __( 'No Shipping Class', 'samply' );
		$shipping_classes = get_terms( array( 'taxonomy' => 'product_shipping_class', 'hide_empty' => false ) );
		foreach( $shipping_classes as $sc ) {
			$data[$sc->term_id]  = $sc->name;
		}
		return $data; 

	}

	/**
	 * Get all tax classes
	 *
	 * @since    1.0.0
	 * @param    none
     * @return   void
	 */	
	public static function taxClass() 
	{

		$data 		= array();
		$options = array(
			'' => __( 'Standard', 'woocommerce' ),
		);

		$tax_classes = \WC_Tax::get_tax_classes();

		if ( ! empty( $tax_classes ) ) {
			foreach ( $tax_classes as $class ) {
				$options[ sanitize_title( $class ) ] = esc_html( $class );
			}
		}

		foreach ( $options as $key => $value ) {
			$data[$key] = $value;
		}
		return $data; 

	}
}