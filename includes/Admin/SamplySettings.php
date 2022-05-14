<?php

namespace Samply\Admin;
use Samply\Helper as Helpers;

class SamplySettings {

    /**
	 * Initialize the class and set its settings options.
	 *
	 * @since    2.0.0
	 * @param    none 
	 */
    public function __construct() {}

    /**
	 * Define setting options as array
	 *
	 * @since    2.0.0
	 * @param    none
     * @return   array 
	 */
    public static function settingFields() {

        $setting_fields = array(  
                'tabs' => apply_filters( 'wfps_builder_tabs', array(
                    'settings_tab'    => array(
                        'title'       => __('Sample Settings', 'samply'),
                        'icon'        => '<svg fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18px" height="18px"><path d="M 9.6679688 2 L 9.1757812 4.5234375 C 8.3550224 4.8338012 7.5961042 5.2674041 6.9296875 5.8144531 L 4.5058594 4.9785156 L 2.1738281 9.0214844 L 4.1132812 10.707031 C 4.0445153 11.128986 4 11.558619 4 12 C 4 12.441381 4.0445153 12.871014 4.1132812 13.292969 L 2.1738281 14.978516 L 4.5058594 19.021484 L 6.9296875 18.185547 C 7.5961042 18.732596 8.3550224 19.166199 9.1757812 19.476562 L 9.6679688 22 L 14.332031 22 L 14.824219 19.476562 C 15.644978 19.166199 16.403896 18.732596 17.070312 18.185547 L 19.494141 19.021484 L 21.826172 14.978516 L 19.886719 13.292969 C 19.955485 12.871014 20 12.441381 20 12 C 20 11.558619 19.955485 11.128986 19.886719 10.707031 L 21.826172 9.0214844 L 19.494141 4.9785156 L 17.070312 5.8144531 C 16.403896 5.2674041 15.644978 4.8338012 14.824219 4.5234375 L 14.332031 2 L 9.6679688 2 z M 12 8 C 14.209 8 16 9.791 16 12 C 16 14.209 14.209 16 12 16 C 9.791 16 8 14.209 8 12 C 8 9.791 9.791 8 12 8 z"/></svg>',
                        'sections'     => apply_filters('samply_settings_tab_sections', array(
                                'settings' => array(
                                    'title'  => __('Settings', 'samply'),
                                    'fields' => array(
                                            array(
                                                'name'          => 'samply_enable',
                                                'label'         => __( 'Enable', 'samply' ),
                                                'type'          => 'checkbox',
                                                'class'         => 'form-control',
                                                'description'   => __( '', 'samply' ),
                                                'placeholder'   => __( '', 'samply' ),
                                            ),                                        
                                            array(
                                                'name'          => 'button_label',
                                                'label'         => __( 'Button Label', 'samply' ),
                                                'type'          => 'text',
                                                'class'         => 'form-control',
                                                'description'   => __( 'Set Button Label', 'samply' ),
                                                'placeholder'   => __( 'Set Button Label', 'samply' ),
                                            ),
                                            array(
                                                'name'          => 'disable_limit_per_order',
                                                'label'         => __( 'Disable Maximum Limit', 'samply' ),
                                                'type'          => 'checkbox',
                                                'class'         => 'form-control',
                                                'description'   => __( 'Disable maximum order limit validation', 'samply' ),
                                            ),            
                                            array(
                                                'name'          => 'limit_per_order',
                                                'label'         => __( 'Maximum Limit Type', 'samply' ),
                                                'type'          => 'select',
                                                'class'         => 'form-control',
                                                'description'   => __( 'Maximum Limit Type', 'samply' ),
                                                'default'       => array(
                                                    'product'   => 'Product',
                                                    'all'       => 'Order',
                                                ),
                                                'style'			=> 'class="limit_per_order_area"',
                                                'position'		=> 'tr'                
                                            ),            
                                            array(
                                                'name'          => 'max_qty_per_order',
                                                'label'         => __( 'Maximum Quantity Per Order', 'samply' ),
                                                'type'          => 'number',
                                                'class'         => 'form-control',
                                                'description'   => __( 'Maximum Quantity Per Order', 'samply' ),
                                                'placeholder'   => 5,
                                                'style'			=> 'class="max_qty_per_order_area"',
                                                'position'		=> 'tr'                
                                            ),
                                            // array(
                                            //     'name'          => 'enable_type',
                                            //     'label'         => __( 'Enable Type', 'samply' ),
                                            //     'type'          => 'select',
                                            //     'class'         => 'form-control',
                                            //     'description'   => __( 'Enable Type', 'samply' ),
                                            //     'default'       => array(                    
                                            //         'product'     => 'Product wise',
                                            //         'category'    => 'Categories wise',
                                            //     )
                                            // ),
                                            // array(
                                            //     'name'          => 'enable_product',
                                            //     'label'         => __( 'Enable Products', 'samply' ),
                                            //     'class'         => 'form-control',
                                            //     'type'          => 'multi-select',
                                            //     'description'   => __( 'Products', 'samply' ),
                                            //     'default'		=> Helpers::Products(),
                                            //     'style'			=> 'class="wfps-enable-product-area"',
                                            //     'position'		=> 'tr'
                                            // ),	
                                            // array(
                                            //     'name'          => 'enable_category',
                                            //     'label'         => __( 'Enable Categories', 'samply' ),
                                            //     'class'         => 'form-control',
                                            //     'type'          => 'multi-select',
                                            //     'description'   => __( 'Categories', 'samply' ),
                                            //     'default'		=> Helpers::Categories(),
                                            //     'style'			=> 'class="wfps-enable-category-area"',
                                            //     'position'		=> 'tr'
                                            // ),
                                            // array(
                                            //     'name'          => 'sample_price',
                                            //     'label'         => __( 'Sample Price', 'samply' ),
                                            //     'class'         => 'form-control',
                                            //     'type'          => 'number',
                                            //     'description'   => __( 'Set Sample Price', 'samply' ),
                                            //     'placeholder'   => '0.00',
                                            //     'value'			=> 0.00
                                            // ),					
                                            // array(
                                            //     'name'          => 'exclude_shop_page',
                                            //     'label'         => __( 'Hide in Shop/Categories Page', 'samply' ),
                                            //     'type'          => 'checkbox',
                                            //     'class'         => 'form-control',
                                            //     'description'   => __( 'Hide in Shop/Categories Page', 'samply' )
                                            // ),
                                            // array(
                                            //     'name'          => 'shipping_class',
                                            //     'label'         => __( 'Shipping Class', 'samply' ),
                                            //     'type'          => 'select',
                                            //     'class'         => 'form-control',
                                            //     'description'   => __( 'Shipping Class', 'samply' ),
                                            //     'default'       => Helpers::shippingClass()
                                            // ),
                                            // array(
                                            //     'name'          => 'tax_class',
                                            //     'label'         => __( 'Tax Class', 'samply' ),
                                            //     'type'          => 'select',
                                            //     'class'         => 'form-control',
                                            //     'description'   => __( 'Tax Class', 'samply' ),
                                            //     'default'       => Helpers::taxClass()
                                            // ),                                                                                   
                                        )                                        
                                    ) 
                                )
                            )
                    ),
                    'others_tab'   => array(
                        'title'     => __('Others', 'samply'),
                        'icon'      => '<svg fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="18px" height="18px"><path d="M30.5,5C23.596,5,18,10.596,18,17.5c0,1.149,0.168,2.257,0.458,3.314L5.439,33.833C5.158,34.114,5,34.496,5,34.894V41.5	C5,42.328,5.671,43,6.5,43h7c0.829,0,1.5-0.672,1.5-1.5V39h3.5c0.829,0,1.5-0.672,1.5-1.5V34h3.5c0.829,0,1.5-0.672,1.5-1.5v-3.788	C26.661,29.529,28.524,30,30.5,30C37.404,30,43,24.404,43,17.5S37.404,5,30.5,5z M32,19c-1.657,0-3-1.343-3-3s1.343-3,3-3	s3,1.343,3,3S33.657,19,32,19z"/></svg>',
                        'sections'   => apply_filters('wfps_message_tab_sections', array(
                                'message' => array(
                                    'title'  => __('Message', 'samply'),
                                    'fields' => array(
                                        array(
                                            'name'          => 'maximum_qty_message',
                                            'label'         => __( 'Maximum quantity message', 'samply' ),
                                            'type'          => 'text',
                                            'class'         => 'widefat',
                                            'description'   => __( '{product} and {qty} for dynamic content.', 'samply' ),
                                            'placeholder'   => __( '', 'samply' ),
                                        ),
                                    )
                                )
                            )
                        ),                    
                    )                       
                )
            )    
        );
		return apply_filters( 'samply_setting_fields', $setting_fields );
    }    
}