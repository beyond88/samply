<?php

namespace Samply\Admin;
use Samply\Helper as Helpers;

/**
 * Settings Handler class
 */
class Main {

    public $_optionName  = 'samply_settings';
    public $_optionGroup = 'samply_options_group';
    public $_defaultOptions = array(
		'button_label'      	=> 'Order a Sample',
		'max_qty_per_order'		=> 5
	);

	public function __construct()
	{
		add_action( 'plugins_loaded', [ $this, 'setDefaultOptions' ] );
		add_action( 'admin_init', [ $this, 'menuRegisterSettings' ] );
	}
    
    
    /**
     * Plugin page handler
     *
     * @return void
     */
    public function plugin_page() 
	{

        $settings = SamplySettings::settingFields();
        $template = __DIR__ . '/views/samply-settings.php';

        if ( file_exists( $template ) ) {
            include $template;
        }
    }

    /**
	 * Save the setting options		
	 * 
	 * @since    2.0.0
	 * @param    array
	 */
	public function menuRegisterSettings() 
    {

		add_option( $this->_optionName, $this->_defaultOptions );	
		register_setting( $this->_optionGroup, $this->_optionName );
		
	}

	/**
	 * Apply filter with default options
	 * 
	 * @since    2.0.0
	 * @param    none
	 */
	public function setDefaultOptions() 
    {
		return apply_filters( 'samply_default_options', $this->_defaultOptions );
	}
}
