<?php
namespace Samply\Frontend;
use Samply\Helper;
use Samply\SamplyMessage as Message; 
/**
 * Load storefront functionality
 */
class SamplyWooCommerce {

	/**
	 * Initial all methods
	 * 
	 * @since	1.0.0
	 * @access	public
	 * @param	none
	 * @return	void
	 */
    public function __construct() {

        add_action( 'woocommerce_init', array( $this, 'init' ) );
		// add_filter( 'plugins_loaded', array( $this, 'sample_price' ) );	
		add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'sample_button' ), 5 );
        add_action( 'woocommerce_after_shop_loop_item', array( $this, 'samply_button_on_shop_page' ), 5 );
		add_action( 'wp_loaded', array( $this, 'add_to_cart_action' ), 10 );	
		add_filter( 'woocommerce_before_calculate_totals', array( $this, 'apply_sample_price_to_cart_item' ), 10 );			
		add_filter( 'woocommerce_add_cart_item_data', array( $this, 'store_id' ), 10, 2 );
		add_filter( 'wc_add_to_cart_message_html', array( $this, 'add_to_cart_message' ), 99, 4 );
		add_filter( 'woocommerce_add_to_cart_validation', array( $this, 'set_limit_per_order' ), 99, 4 );
		add_filter( 'woocommerce_get_cart_item_from_session', array( $this, 'get_cart_items_from_session' ), 10, 2 );
		add_action( 'woocommerce_add_order_item_meta', array( $this, 'save_posted_data_into_order' ), 10, 3 );
		add_filter( 'woocommerce_locate_template', array( $this, 'set_locate_template' ), 10, 3 );	
		add_filter( 'woocommerce_cart_item_name', array( $this, 'alter_item_name' ), 10, 3 );	
		add_filter( 'woocommerce_cart_item_price', array( $this, 'cart_item_price_filter' ), 10, 3 );
		add_filter( 'woocommerce_update_cart_validation', array( $this, 'cart_update_limit_order' ), PHP_INT_MAX, 4 );		
		add_filter( 'woocommerce_cart_item_subtotal',  array( $this, 'item_subtotal' ), 99, 3 );
		
		// filter for Minimum/Maximum plugin override overriding
		add_action( 'woocommerce_before_template_part', array( $this, 'check_cart_items' ) );
		add_action( 'woocommerce_check_cart_items', array( $this, 'check_cart_items' ) );
		add_filter( 'wc_min_max_quantity_minmax_do_not_count', array( $this, 'cart_exclude' ), 10, 4 );
		add_filter( 'wc_min_max_quantity_minmax_cart_exclude', array( $this, 'cart_exclude' ), 10, 4 );

		add_action( 'woocommerce_checkout_order_processed', array( $this, 'sample_update_stock'), PHP_INT_MAX, 1 );
		add_action( 'template_redirect', array( $this, 'handle_dokan_product_update' ), 11 );	
		add_action( 'dokan_product_edit_after_inventory_variants', array( $this, 'load_dokan_template' ), 85, 2 );
		add_filter( 'samply_price', array( $this, 'samply_price' ), PHP_INT_MAX, 2 );

    }

	/**
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	none
	 * @return	void
	 */
	public function init() {
		
		// filter for Measurement Price Calculator plugin override overriding
		if ( in_array( 'woocommerce-measurement-price-calculator/woocommerce-measurement-price-calculator.php', apply_filters( 'active_plugins', get_option('active_plugins') ) ) ) {
			add_filter( 'wc_measurement_price_calculator_add_to_cart_validation', array( $this, 'measurement_price_calculator_add_to_cart_validation' ), 10, 4 );
		}

		// filter for Minimum/Maximum plugin override overriding
		if ( in_array( 'woocommerce-min-max-quantities/min-max-quantities.php', apply_filters( 'active_plugins', get_option('active_plugins') ) ) ) {
			add_filter( 'wc_min_max_quantity_minimum_allowed_quantity', array( $this, 'minimum_quantity' ), 10, 4 );
			add_filter( 'wc_min_max_quantity_maximum_allowed_quantity', array( $this, 'maximum_quantity' ), 10, 4 );
			add_filter( 'wc_min_max_quantity_group_of_quantity', array( $this, 'group_of_quantity' ), 10, 4 );
			// Check items.			
		}

		// filter for WooCommerce Chained Products plugin override overriding
		if ( in_array( 'woocommerce-chained-products/woocommerce-chained-products.php', apply_filters( 'active_plugins', get_option('active_plugins') ) ) ) {
			add_action( 'wc_after_chained_add_to_cart', array( $this, 'remove_chained_products' ), 20, 6 );
		}

	}	

	/**
	 * Display sample button
	 * 
	 * @since  	1.0.0
	 * @access	public
	 * @param  	none  
	 * @return 	html
	 */
	public function sample_button() {
		if ( Helper::product_is_in_stock() && Helper::check_is_in_cart( get_the_ID() ) ) {
			$button = Helper::request_button(); 
			echo apply_filters( 'samply_sample_button', $button );								
		}
	}

    /**
     * Display sample button in the shop page
     *
     * @since	1.0.0
	 * @access	public
     * @param	string
     * @return	void
     */
    public function samply_button_on_shop_page() {
        global $product;
        $product_id 			= $product->get_id();
        $sku 					= $product->get_sku();
        $product_cat_id 		= array();
        $setting				= Helper::samply_settings();
        $enable_type 			= isset( $setting['enable_type'] ) ? $setting['enable_type'] : '';
        $exclude_shop 			= isset( $setting['exclude_shop_page'] ) ? $setting['exclude_shop_page'] : '';
        $category_ids 			= isset( $setting['enable_category'] ) ? $setting['enable_category'] : array();
        $product_ids 			= isset( $setting['enable_product'] ) ? $setting['enable_product'] : array();
        $button_label 			= isset( $setting['button_label'] ) ? sprintf(__( '%s', 'samply' ),$setting['button_label']) : __( 'Order a Sample', 'samply' );
        $terms 					= get_the_terms( get_the_ID(), 'product_cat' );

        if ($terms) {
            foreach ($terms as $term) {
                array_push($product_cat_id, $term->term_id);
            }
        }

        if( $exclude_shop != 1 && Helper::check_is_in_cart( get_the_ID() ) ) {

            if( $enable_type == "product" ) {

                if( empty( $product_ids[0] ) ) {

                    if( $product->is_type('variable') || $product->is_type('grouped') ) return;
                    if( Helper::product_is_in_stock() ) {
                        echo '<div style="margin-bottom:10px;">';
                        echo '<a href="?add-to-cart='.$product_id.'" data-quantity="1" class="button product_type_simple samply_ajax_add_to_cart ajax_add_to_cart" data-product_id="'.$product_id.'" data-product_sku="'.$sku.'" rel="nofollow">'.$button_label.'</a>';
                        echo '</div>';
                    }

                } else if( in_array(get_the_ID(), $product_ids) ) {

                    if( $product->is_type('variable') || $product->is_type('grouped') ) return;
                    if( Helper::product_is_in_stock() ) {
                        echo '<div style="margin-bottom:10px;">';
                        echo '<a href="?add-to-cart='.$product_id.'" data-quantity="1" class="button product_type_simple samply_ajax_add_to_cart ajax_add_to_cart" data-product_id="'.$product_id.'" data-product_sku="'.$sku.'" rel="nofollow">'.$button_label.'</a>';
                        echo '</div>';
                    }

                }

            } else {

                if( empty($category_ids) ) {

                    if( $product->is_type('variable') || $product->is_type('grouped') ) return;
                    if( Helper::product_is_in_stock() ) {
                        echo '<div style="margin-bottom:10px;">';
                        echo '<a href="?add-to-cart='.$product_id.'" data-quantity="1" class="button product_type_simple samply_ajax_add_to_cart ajax_add_to_cart" data-product_id="'.$product_id.'" data-product_sku="'.$sku.'" rel="nofollow">'.$button_label.'</a>';
                        echo '</div>';
                    }

                } else if( count( array_intersect( $product_cat_id, $category_ids ) ) == count( $product_cat_id ) ) {

                    if( $product->is_type('variable') || $product->is_type('grouped') ) return;
                    if( Helper::product_is_in_stock() ) {
                        echo '<div style="margin-bottom:10px;">';
                        echo '<a href="?add-to-cart='.$product_id.'" data-quantity="1" class="button product_type_simple samply_ajax_add_to_cart ajax_add_to_cart" data-product_id="'.$product_id.'" data-product_sku="'.$sku.'" rel="nofollow">'.$button_label.'</a>';
                        echo '</div>';
                    }

                }

            }
        }

    }

	/**
	 * Handle add to cart
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	string
	 * @return	redirect
	 */
	public static function add_to_cart_action( $url = false ) {

		if ( ! isset( $_REQUEST['simple-add-to-cart'] ) || ! is_numeric( wp_unslash( $_REQUEST['simple-add-to-cart'] ) ) )			 
		{
			return;
		}

		wc_nocache_headers();

		$product_id        = apply_filters( 'woocommerce_add_to_cart_product_id', absint( wp_unslash( $_REQUEST['simple-add-to-cart'] ) ) );
		$was_added_to_cart = false;
		$adding_to_cart    = wc_get_product( $product_id );

		if ( ! $adding_to_cart ) {
			return;
		}
		
		$add_to_cart_handler = apply_filters( 'woocommerce_add_to_cart_handler', $adding_to_cart->get_type(), $adding_to_cart );

		if ( 'variable' === $add_to_cart_handler || 'variation' === $add_to_cart_handler ) {
			$was_added_to_cart = self::add_to_cart_handler_variable( $product_id );
		} else {
			$was_added_to_cart = self::add_to_cart_handler_simple( $product_id );
		}

		// If we added the product to the cart we can now optionally do a redirect.
		if ( $was_added_to_cart && 0 === wc_notice_count( 'error' ) ) {
			$url = apply_filters( 'woocommerce_add_to_cart_redirect', $url, $adding_to_cart );

			if ( $url ) {
				wp_safe_redirect( $url );
				exit;
			} elseif ( 'yes' === get_option( 'woocommerce_cart_redirect_after_add' ) ) {
				wp_safe_redirect( wc_get_cart_url() );
				exit;
			}
		}
	}

	/**
	 * Handle adding simple products to the cart.
	 *
	 * @since	2.4.6 Split from add_to_cart_action.
	 * @access	public
	 * @param	int $product_id Product ID to add to the cart.
	 * @return	bool success or not
	 */
	private static function add_to_cart_handler_simple( $product_id ) {

		$quantity          = Helper::sample_qty();
		$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );	

		if ( $passed_validation && false !== WC()->cart->add_to_cart( $product_id, $quantity ) ) {
			wc_add_to_cart_message( array( $product_id => $quantity ), true );
			return true;
		}
		return false;
	}
	
	/**
	 * Handle adding variable products to the cart.
	 *
	 * @since	2.4.6 Split from add_to_cart_action.
	 * @access	private
	 * @throws	Exception If add to cart fails.
	 * @param	int $product_id Product ID to add to the cart.
	 * @return	bool success or not
	 */
	private static function add_to_cart_handler_variable( $product_id ) {
		try {
			$variation_id       = empty( $_REQUEST['variation_id'] ) ? '' : absint( wp_unslash( $_REQUEST['variation_id'] ) );
			$quantity           = empty( $_REQUEST['quantity'] ) ? 1 : wc_stock_amount( wp_unslash( $_REQUEST['quantity'] ) );
			$missing_attributes = array();
			$variations         = array();
			$adding_to_cart     = wc_get_product( $product_id );

			if ( ! $adding_to_cart ) {
				return false;
			}				

			// If the $product_id was in fact a variation ID, update the variables.
			if ( $adding_to_cart->is_type( 'variation' ) ) {
				$variation_id   = $product_id;
				$product_id     = $adding_to_cart->get_parent_id();
				$adding_to_cart = wc_get_product( $product_id );

				if ( ! $adding_to_cart ) {
					return false;
				}
			}

			// Gather posted attributes.
			$posted_attributes = array();

			foreach ( $adding_to_cart->get_attributes() as $attribute ) 
            {
				if ( ! $attribute['is_variation'] ) {
					continue;
				}
				$attribute_key = 'attribute_' . sanitize_title( $attribute['name'] );

				if ( isset( $_REQUEST[ $attribute_key ] ) ) { 
					if ( $attribute['is_taxonomy'] ) {
						// Don't use wc_clean as it destroys sanitized characters.
						$value = sanitize_title( wp_unslash( $_REQUEST[ $attribute_key ] ) );
					} else {
						$value = html_entity_decode( wc_clean( wp_unslash( $_REQUEST[ $attribute_key ] ) ), ENT_QUOTES, get_bloginfo( 'charset' ) );
					}

					$posted_attributes[ $attribute_key ] = $value;
				}
			}

			// If no variation ID is set, attempt to get a variation ID from posted attributes.
			if ( empty( $variation_id ) ) {
				$data_store   = \WC_Data_Store::load( 'product' );
				$variation_id = $data_store->find_matching_product_variation( $adding_to_cart, $posted_attributes );
			}

			// Do we have a variation ID?
			if ( empty( $variation_id ) ) {
				throw new \Exception( __( 'Please choose product options&hellip;', 'woocommerce' ) );
			}

			// Check the data we have is valid.
			$variation_data = wc_get_product_variation_attributes( $variation_id );

			foreach ( $adding_to_cart->get_attributes() as $attribute ) {
				if ( ! $attribute['is_variation'] ) {
					continue;
				}

				// Get valid value from variation data.
				$attribute_key = 'attribute_' . sanitize_title( $attribute['name'] );
				$valid_value   = isset( $variation_data[ $attribute_key ] ) ? $variation_data[ $attribute_key ] : '';

				/**
				 * If the attribute value was posted, check if it's valid.
				 *
				 * If no attribute was posted, only error if the variation has an 'any' attribute which requires a value.
				 */
				if ( isset( $posted_attributes[ $attribute_key ] ) ) {
					$value = $posted_attributes[ $attribute_key ];

					// Allow if valid or show error.
					if ( $valid_value === $value ) {
						$variations[ $attribute_key ] = $value;
					} elseif ( '' === $valid_value && in_array( $value, $attribute->get_slugs(), true ) ) {
						// If valid values are empty, this is an 'any' variation so get all possible values.
						$variations[ $attribute_key ] = $value;
					} else {
						/* translators: %s: Attribute name. */
						throw new \Exception( sprintf( __( 'Invalid value posted for %s', 'woocommerce' ), wc_attribute_label( $attribute['name'] ) ) );
					}
				} elseif ( '' === $valid_value ) {
					$missing_attributes[] = wc_attribute_label( $attribute['name'] );
				}
			}
			if ( ! empty( $missing_attributes ) ) {
				/* translators: %s: Attribute name. */
				throw new \Exception( sprintf( _n( '%s is a required field', '%s are required fields', count( $missing_attributes ), 'woocommerce' ), wc_format_list_of_items( $missing_attributes ) ) );
			}
		} catch ( \Exception $e ) {
			wc_add_notice( $e->getMessage(), 'error' );
			return false;
		}

		$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity, $variation_id, $variations );

		if ( $passed_validation && false !== WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variations ) ) {
			wc_add_to_cart_message( array( $product_id => $quantity ), true );
			return true;
		}

		return false;
	}	
	 
	/**
	 * Set sample price in the cart
	 * 
	 * @since	1.0.0
	 * @access	public      
	 * @param	string, string
	 * @return	array    	 
	 */
	public function store_id( $cart_item ) {

		if( isset( $_REQUEST['simple-add-to-cart'] ) || isset( $_REQUEST['variable-add-to-cart'] ) ) {
			$cart_item['free_sample']  = isset( $_REQUEST['simple-add-to-cart'] ) ? sanitize_text_field( $_REQUEST['simple-add-to-cart'] ) : sanitize_text_field( $_REQUEST['variable-add-to-cart'] );
			$product_id = isset( $_REQUEST['simple-add-to-cart'] ) ? sanitize_text_field( $_REQUEST['simple-add-to-cart'] ) : sanitize_text_field( $_REQUEST['variable-add-to-cart'] );
			$cart_item['sample_price'] = (float) Helper::sample_price( $product_id );
			$cart_item['line_subtotal']= (float) Helper::sample_price( $product_id );
			$cart_item['line_total']   = (float) Helper::sample_price( $product_id );				
		}			
		return $cart_item; 
	}	

	/**
	 * Set sample price in session
	 * 
	 * @since	1.0.0
	 * @access	public
	 * @param	array, array
	 * @return	array  
	 */
	public function get_cart_items_from_session( $cart_item, $values ) {
	
		if ( isset( $values['simple-add-to-cart'] ) || isset( $values['variable-add-to-cart'] ) ) {
			$product_id 					= isset( $_REQUEST['simple-add-to-cart'] ) ? sanitize_text_field( $_REQUEST['simple-add-to-cart'] ) : sanitize_text_field( $_REQUEST['variable-add-to-cart'] );
			$cart_item['free_sample'] 		= isset( $values['simple-add-to-cart'] ) ? $values['simple-add-to-cart'] : $values['variable-add-to-cart'];			
			$cart_item['line_subtotal'] 	= (float) Helper::sample_price( $product_id );
			$cart_item['line_total'] 	  	= (float) Helper::sample_price( $product_id );	
		}    

		return $cart_item;
	}
	 
	/**
	 * Add product meta for sample to indentity in the admin order details
	 * 
	 * @since	1.0.0
	 * @access	public
	 * @param	int, array
	 * @return	void    	 
	 */
	public function save_posted_data_into_order( $itemID, $values ) {

		if ( isset( $values['free_sample'] ) ) {
			$sample 		= __( 'Sample', 'samply' );
			if( get_locale() == 'de_DE' ) {
				wc_add_order_item_meta( $itemID, 'Produkt', 'MUSTERBESTELLUNG' );
				wc_add_order_item_meta( $itemID, 'Preis', 'Wir übernehmen die Kosten für Sie!' );
			} else {
				wc_add_order_item_meta( $itemID, 'PRODUCT_TYPE', $sample );
				wc_add_order_item_meta( $itemID, 'SAMPLE_PRICE', (float)$values["sample_price"] );
			}
		}
		
	}
	
	/**
	 * Return plugin directory
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	none
	 * @return	string
	 */
	public static function get_plugin_path() {		
		return untrailingslashit( plugin_dir_path( __FILE__ ) );
	}

	/**
	 * Return WooCommerce template path
	 * 
	 * @since	1.0.0
	 * @access	public
	 * @param	string, string, string
	 * @return	string
	 */
	public function set_locate_template( $template, $template_name, $template_path ) {

		global $woocommerce;
		$_template = $template;
		if ( ! $template_path ) {
			$template_path = $woocommerce->template_url;
		}		

	  	$plugin_path  = self::get_plugin_path() . '/views/woocommerce/';
	  	$template = locate_template(
	    	array(
	      		$template_path . $template_name,
	      		$template_name
	    	)
	  	);

	  	if ( ! $template && file_exists( $plugin_path . $template_name ) )
	    	$template = $plugin_path . $template_name;

	  	if ( ! $template )
	    	$template = $_template;

		return $template;		
		  
	}

	/**
	 * Set sample price in the order meta
	 * 
	 * @since	1.0.0
	 * @param	object, array
	 * @return	void     	 
	 */
    public function apply_sample_price_to_cart_item( $cart ) {

		if ( is_admin() && ! defined( 'DOING_AJAX' ) )
		return;

		// Avoiding hook repetition (when using price calculations for example)
		if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 )
		return;	
	
		foreach ( $cart->get_cart() as $key => $value ) {
			if( isset( $value["sample_price"] ) ) {	
				$product = $value['data'];
				method_exists( $product, 'set_price' ) ? $product->set_price( (float) $value["sample_price"] ) : $product->price = $value["sample_price"];			
			}			

		}   
	}

	/**
	 * Display validation message when order a product sample 
	 *
	 * @since	1.0.0
	 * @param	int, array
	 * @return	boolean
	 */		
	public function set_limit_per_order( $valid, $product_id ) {
	
		global $woocommerce;
		$setting_options   = Helper::samply_settings();
		$notice_type 	   = isset( $setting_options['limit_per_order'] ) ? $setting_options['limit_per_order'] : null;
		$disable_limit 	   = isset( $setting_options['disable_limit_per_order'] ) ? $setting_options['disable_limit_per_order'] : null;

		if( ! isset( $disable_limit ) ) :
			foreach( $woocommerce->cart->get_cart() as $key => $val ) :
				
				if( 'product' == $notice_type ) {

					if( ( isset( $val['free_sample'] ) && $product_id == $val['free_sample'] ) && ( $setting_options['max_qty_per_order'] <= $val['quantity'] ) && ( isset( $_REQUEST['simple-add-to-cart'] ) || isset( $_REQUEST['variable-add-to-cart'] ) ) ) {
						if( get_locale() == 'ja' ) {
							wc_add_notice( esc_html__( 'この商品を注文できます '.$setting_options['max_qty_per_order'].' 注文あたりの数量。', 'samply' ), 'error' );
						} else {
							wc_add_notice( esc_html__( 'You can order this product '.$setting_options['max_qty_per_order'].' quantity per order.', 'samply' ), 'error' );
						}						
						exit( wp_redirect( get_permalink($product_id) ) );						
					}	

				} else if( 'all' == $notice_type ) {

					if( ( isset( $val['free_sample'] ) ) && ( $setting_options['max_qty_per_order'] <= Helper::cart_total() ) && ( isset( $_REQUEST['simple-add-to-cart'] ) || isset( $_REQUEST['variable-add-to-cart'] ) ) ) {
						if( get_locale() == 'ja' ) {
							wc_add_notice( esc_html__( 'サンプル商品を最大で注文できます '.$setting_options['max_qty_per_order'].' 注文あたりの数量。', 'samply' ), 'error' );
						} else {
							wc_add_notice( esc_html__( 'You can order sample product maximum '.$setting_options['max_qty_per_order'].' quantity per order.', 'samply' ), 'error' );
						}						
						exit( wp_redirect( get_permalink($product_id) ) );						
					}

				}
			endforeach; 
		endif; 
		return $valid;

	}	

	/**
	 * Show validation message in the cart page 
	 * for maximum order
	 * 
	 * @since	1.0.0
	 * @param	boolean, array, array, int
	 * @return	boolean
	 */
	public function cart_update_limit_order( $passed, $cart_item_key, $values, $updated_quantity ) {

		$product 		   = wc_get_product( $values['product_id'] );	
		$setting_options   = Helper::samply_settings();
		$notice_type 	   = isset( $setting_options['limit_per_order'] ) ? $setting_options['limit_per_order'] : 'all';
		$disable_limit 	   = isset( $setting_options['disable_limit_per_order'] ) ? $setting_options['disable_limit_per_order'] : null;
		$message 		   = Message::validation_notice( $product->get_id() );
		
		if( ! isset( $disable_limit ) ) :

			if( 'product' == $notice_type ) {

				if( ( $values['free_sample'] == $values['product_id'] ) && ( $setting_options['max_qty_per_order'] < $updated_quantity ) ) {						
					
					if( get_locale() == "ja" ) {
						wc_add_notice( esc_html__( '注文できます '.$product->get_name().' 最大 '.$setting_options['max_qty_per_order'].'  注文ごと。', 'samply' ), 'error' );
					} else {

						wc_add_notice( sprintf(
							__( '%1$s.', 'samply' ),
							$message
						), 'error');
						
					}
					$passed = false;
				}

			} else if( 'all' == $notice_type ) {

				if( ( isset( $values['free_sample'] ) ) && ( $setting_options['max_qty_per_order'] <= Helper::cart_total() ) ) {
					if( get_locale() == 'ja' ) {
						wc_add_notice( esc_html__( 'サンプル商品を最大で注文できます '.$setting_options['max_qty_per_order'].' 注文あたりの数量。', 'samply' ), 'error' );
					} else {
						wc_add_notice( sprintf(
							__( '%1$s.', 'samply' ),
							$message
						), 'error');
					}
						
					$passed = false;				
				}
			}

		endif; 
		return $passed;

	}		

	/**
	 * Sample product added in the cart message
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	int, array
	 * @return	string 
	 */	
	public function add_to_cart_message ( $message, $products ) {

		$titles = '';
		if( isset( $_REQUEST['simple-add-to-cart'] ) || isset( $_REQUEST['variable-add-to-cart'] ) ) {
			
			$count = 0;
			$titles = array();
			foreach ( $products as $product_id => $qty ) {
				if( get_locale() == "ja" ) {
					$sample =  esc_html__( 'サンプル - ', 'samply' );
				} else if( get_locale() == 'de_DE' ) {
					$sample =  esc_html__( 'Testzugang - ', 'samply' );					
				} else {
					$sample =  esc_html__( 'Sample - ', 'samply' );
				}
				
				$titles[] = apply_filters( 'woocommerce_add_to_cart_qty_html', ( $qty > 1 ? absint( $qty ) . ' &times; ' : '' ), $product_id ) . apply_filters( 'woocommerce_add_to_cart_item_name_in_quotes', sprintf( _x( '&ldquo;%s&rdquo;', 'Item name in quotes', 'woocommerce' ), strip_tags( $sample . get_the_title( $product_id ) ) ), $product_id );
				$count   += $qty;
			}
			
			$titles = array_filter( $titles );
			/* translators: %s: product name */
			$added_text = sprintf( _n( '%s has been added to your cart.', '%s have been added to your cart.', $count, 'woocommerce' ), wc_format_list_of_items( $titles ) );		
	
			// Output success messages.
			$message = sprintf( '<a href="%s" tabindex="1" class="button wc-forward">%s</a> %s', esc_url( wc_get_cart_url() ), esc_html__( 'View cart', 'woocommerce' ), esc_html( $added_text ) );
			return $message;
	
		} 
	
		return $message;

	}

	/**
	 * Add sample label before the product 
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	string, array, array
	 * @return	string 
	 */	
	public function alter_item_name ( $product_name, $cart_item, $cart_item_key ) {

		$product 			= $cart_item['data']; // Get the WC_Product Object
		$sample_price 		= (float) Helper::sample_price( $cart_item['product_id'] );
		$sample_price 		= str_replace( ",",".", $sample_price );
		$prod_price 		= str_replace( ",",".", $product->get_price() );	
		if( $sample_price == $prod_price ) {
			if( get_locale() == 'ja' ) {
				$product_name   = esc_html__( 'サンプル - ', 'samply' ) . $product_name;	
			} else if( get_locale() == 'de_DE' ) {
				$product_name   = esc_html__( 'Testzugang - ', 'samply' ) . $product_name;						
			} else {
				$product_name   = esc_html__( 'Sample - ', 'samply' ) . $product_name;
			}			
		}

		return $product_name;

	}

   	/**
	 * Set sample price instead real price
	 * 
	 * @since	1.0.0
	 * @access	public
	 * @param	float, array, array
	 * @return	integer|float
	 */
    public function cart_item_price_filter( $price, $cart_item, $cart_item_key ) {
	
		$product 			= $cart_item['data']; // Get the WC_Product Object
		$sample_price 		= (float)Helper::sample_price( $cart_item['product_id'] );
		$set_price 			= str_replace( ",", ".", $sample_price );
		if( isset( $cart_item['sample_price'] ) ) {
			$price         = wc_price( $set_price );
		}
		
		return $price;
	}

	/**
	 * Set subtotal
	 * 
	 * @since	1.0.0
	 * @access	public
	 * @param	float, array, array
	 * @return	integer|float
	 */	
	public function item_subtotal( $subtotal, $cart_item, $cart_item_key ) {
		
		if( isset( $cart_item['sample_price'] ) ) {
			if(empty($cart_item['sample_price'])) {
				$price = 0.00;
			} else {
				$price = (float)$cart_item['sample_price'];
			}

			$newsubtotal = wc_price( (float)$price * (int)$cart_item['quantity'] ); 		 
			$subtotal = $newsubtotal; 			
		}		 
		 
		return $subtotal;
	}

	/**
	 * Check Measurement Price Calculation Validation
	 * 
	 * @since	1.0.0
	 * @access	public
	 * @param	boolean, integer, integer, array
	 * @return	boolean
	 */		
	public function measurement_price_calculator_add_to_cart_validation ($valid, $product_id, $quantity, $measurements) {
		global $woocommerce;
		$validation = $valid;
		if ( $_REQUEST['simple-add-to-cart'] || $_REQUEST['variable-add-to-cart'] ) {
			$woocommerce->session->set( 'wc_notices', null );
			$validation = true;
		}
		return $validation;
	}
	
	/**
	 * Filter for Minimum/Maximum plugin overriding
	 * 
	 * @since	1.0.0
	 * @access	public
	 * @param	integer, integer, integer, array, array
	 * @return	integer
	 */		
	public function minimum_quantity($minimum_quantity, $checking_id, $cart_item_key, $values) {
		if ( $_REQUEST['simple-add-to-cart'] || $_REQUEST['variable-add-to-cart'] )
			$minimum_quantity = 1;
		return $minimum_quantity;
	}

	/**
	 * Filter for Minimum/Maximum plugin overriding
	 * 
	 * @since	1.0.0
	 * @access	public
	 * @param	integer, integer, integer, array, array
	 * @return	integer
	 */		
	public function maximum_quantity($maximum_quantity, $checking_id, $cart_item_key, $values) {
		if ( $_REQUEST['simple-add-to-cart'] || $_REQUEST['variable-add-to-cart'] )
			$maximum_quantity = 1;
		return $maximum_quantity;
	}

	/**
	 * Filter for Minimum/Maximum plugin overriding
	 * 
	 * @since	1.0.0
	 * @access	public
	 * @param	integer, integer, integer, array, array
	 * @return	integer
	 */		
	public function group_of_quantity($group_of_quantity, $checking_id, $cart_item_key, $values) {
		if ( $_REQUEST['simple-add-to-cart'] || $_REQUEST['variable-add-to-cart'] ) 
			$group_of_quantity = 1;
		return $group_of_quantity;
	}
	
	/**
	 * Filter for Minimum/Maximum plugin overriding
	 * 
	 * @since      1.0.0
	 * @param      integer, integer, integer, array, array 
	 */		
	public function remove_chained_products ($chained_parent_id, $quantity, $chained_variation_id, $chained_variation_data, $chained_cart_item_data, $cart_item_key) {
		global $woocommerce;
		$cart = $woocommerce->cart->get_cart();
		$main_is_sample = $cart[$cart_item_key]['sample'];
		if ($main_is_sample) {
			$main_product_id = $cart[$cart_item_key]['product_id'];
			if ( !get_post_meta($main_product_id, 'sample_chained_enambled', true) ) {
				foreach ($cart as $cart_key => $cart_item) {
					if ($cart_item['product_id'] == $chained_parent_id) {
						$woocommerce->cart->remove_cart_item($cart_key);
						break;
					}
				}
			}
		}
	}
	
	/**
	 * Check WooCommerce min/max quantities validation message
	 * 
	 * @since      1.0.0
	 * @param      array 
	 */	
	public function check_cart_items() {
		if( ! is_admin() ) {
			if ( class_exists('WC_Min_Max_Quantities') && WC()->cart->get_cart_contents_count() != 0 ) {			
				foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
					if(isset($values['free_sample']) && $values['free_sample'] == $values['product_id']) {
						wc_clear_notices();
					}
				}
			}
		}

	}

	/**
	 * Check WooCommerce min/max quantities validation message
	 * 
	 * @since	2.0.0
	 * @access	public
	 * @param	array
	 * @return	string|null
	 */	
	public function cart_exclude( $exclude, $checking_id, $cart_item_key, $values ) {
		if ( class_exists('WC_Min_Max_Quantities') ) {
			foreach ( WC()->cart->get_cart() as $cart_item_key => $values ) {
				if(isset($values['free_sample']) && $values['free_sample'] == $values['product_id']) {
					return 'yes';
				}
			}
		}
	}    

	/**
	 * Update stock quantity
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	integer
     * @return	void
	 */	
	public function sample_update_stock( $order_id ) {

		$order 				= \wc_get_order( $order_id );
		$items 				= $order->get_items();
		$sample_status		= 0;

		foreach ( $items as $key => $value ) {
			$prod_id 		= $value['product_id'];
			$prod_qty		= $value['quantity'];
			
			$_manage_stock 	= get_post_meta( $prod_id, '_manage_stock', true );			
			$_stock 		= get_post_meta( $prod_id, '_stock', true );			
			$manage_stock   = get_post_meta( $prod_id, 'samply_manage_stock', true );
			$get_old_qty 	= get_post_meta( $prod_id, 'samply_qty', true );

			if( $value->get_meta('PRODUCT_TYPE') ) {
				$sample_status = 1;
			}
			
			if( $sample_status && 1 == $manage_stock ) {
				
				if( $get_old_qty > $prod_qty ) {
					update_post_meta( $prod_id, 'samply_qty', ( $get_old_qty - $prod_qty ) );
				}

				if( isset( $_manage_stock )  && $_manage_stock == "yes" ) {
					update_post_meta( $prod_id, '_stock',  $_stock + $value['quantity'] );
				}

			}
		}
		
	}

	/**
	 * Handle product update
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	object, integer
     * @return	void
	 */		
    public function handle_dokan_product_update() {
		
		if ( ! is_user_logged_in() ) {
            return;
		}

        if ( ! Helper::dokan_is_user_seller( get_current_user_id() ) && ! class_exists('WeDevs_Dokan') ) {
            return;
		}

        if ( ! isset( $_POST['dokan_update_product'] ) ) {
            return;
        }

		$postdata = wp_unslash( $_POST );

        if ( ! wp_verify_nonce( sanitize_key( $postdata['dokan_edit_product_nonce'] ), 'dokan_edit_product' ) ) {
            return;
		}

		$post_id    = isset( $postdata['dokan_product_id'] ) ? absint( $postdata['dokan_product_id'] ) : 0;

		if ( isset( $postdata['samply_manage_stock'] ) ) {
			update_post_meta( $post_id, 'samply_manage_stock', wc_clean( $postdata['samply_manage_stock'] ) );
		}

		if ( isset( $postdata['samply_qty'] ) ) {
			update_post_meta( $post_id, 'samply_qty', wc_clean( $postdata['samply_qty'] ) );
		}

	}

	/**
	 * Add product sample tab in the dokan dashboard
	 *
	 * @since	1.0.0
	 * @access	public
	 * @param	object, integer
     * @return	template
	 */	
	public function load_dokan_template( $post, $post_id ) {
		if( ! class_exists('WeDevs_Dokan') || Helper::is_pro() ) {
			return;
		}
		return include_once self::get_plugin_path() . '/views/dokan-template.php';
	}


	/**
	 * Add samply price filter
	 *
	 * @since	1.0.8
	 * @access	public
	 * @param	object, integer
     * @return	integer|float
	 */	
	public function samply_price( $price, $product_id ) {

		$setting    	= Helper::samply_settings();
		$_product       = wc_get_product($product_id);
		
		if( $_product->is_type( 'simple' ) ) {
			$samply_price     = get_post_meta( $product_id, 'samply_price', true );
			if( ! empty( $samply_price ) ) {
				$samply_price = str_replace( ",", ".", $samply_price );
				return $samply_price;	 
			}
		}
		if( $_product->is_type( 'variable' ) ) {
			$variation_id = empty( $_REQUEST['variation_id'] ) ? '' : absint( wp_unslash( $_REQUEST['variation_id'] ) );
			$samply_price = get_post_meta( $variation_id, 'samply_price', true );
			if( ! empty( $samply_price ) ) {
				$samply_price = str_replace( ",", ".", $samply_price );
				return $samply_price;	 
			}
		}

		return isset( $setting['sample_price'] ) ? ( str_replace( ",", ".", $setting['sample_price'] ) ) : ( str_replace( ",", ".", $price ) );

	}
    
}