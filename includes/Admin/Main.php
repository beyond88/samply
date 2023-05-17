<?php

namespace Samply\Admin;
use Samply\Helper as Helpers;

/**
 * Settings Handler class
 */
class Main 
{

    public $_optionName  = 'samply_settings';
    public $_optionGroup = 'samply_options_group';
    public $_defaultOptions = [
		'button_label'      	=> 'Order a Sample',
		'max_qty_per_order'		=> 5
	];

	public function __construct() {
		add_action( 'plugins_loaded', [ $this, 'set_default_options' ] );
		add_action( 'admin_init', [ $this, 'menu_register_settings' ] );

		SamplySettings::init();
	}    
    
    /**
     * Plugin page handler
     *
     * @return void
     */
    public function plugin_page() {
        $settings = SamplySettings::setting_fields();
        $template = __DIR__ . '/views/samply-settings.php';

        if ( file_exists( $template ) ) {
            include $template;
        }
    }

    /**
	 * Save the setting options		
	 * 
	 * @since    1.0.0
	 * @param    array
	 */
	public function menu_register_settings() {
		add_option( $this->_optionName, $this->_defaultOptions );	
		register_setting( $this->_optionGroup, $this->_optionName );
	}

	/**
	 * Apply filter with default options
	 * 
	 * @since    1.0.0
	 * @param    none
	 */
	public function set_default_options() {
		return apply_filters( 'samply_default_options', $this->_defaultOptions );
	}
}
