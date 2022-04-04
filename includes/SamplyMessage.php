<?php

namespace Samply;

class SamplyMessage {

    public static $_optionName  = 'woo_free_product_sample_settings';
    public static $_optionGroup = 'woo-free-product-sample-options-group';
    public static $_defaultOptions = array(
		'button_label'          	=> 'Order a Sample',
		'max_qty_per_order'			=> 5, 
		'maximum_qty_message'      	=> ''
	);

    /**
	 * Validation message
	 * 
	 * @since    2.0.0
	 * @param    none 
	 */    
    public static function validation_notice( $product_id ){

        $final_msg         = '';
		$setting_options   = wp_parse_args( get_option(self::$_optionName), self::$_defaultOptions );
		$message 		   = isset( $setting_options['maximum_qty_message'] ) ? $setting_options['maximum_qty_message'] : '';
        
        $product		   = wc_get_product( $product_id );
        $searchVal         = array("{product}", "{qty}");
        $replaceVal        = array($product->get_name(), $setting_options['max_qty_per_order'] );
        $final_msg         = str_replace($searchVal, $replaceVal, $message);         
        return $final_msg;    
           
    }
}