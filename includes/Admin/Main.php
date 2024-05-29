<?php

namespace Samply\Admin;

use Samply\Helper as Helpers;

/**
 * Settings Handler class
 */
class Main
{

	/**
	 * Settings otpions field
	 * 
	 * @var string
	 */
	public $_optionName  = 'samply_settings';

	/**
	 * Settings otpions group field
	 * 
	 * @var string
	 */
	public $_optionGroup = 'samply_options_group';

	/**
	 * Settings otpions field default values
	 * 
	 * @var array
	 */
	public $_defaultOptions = array(
		'button_label'      	=> 'Order a Sample',
		'max_qty_per_order'		=> 5
	);

	/**
	 * Initial the class and its all methods
	 *
	 * @since 1.0.0
	 * @access	public
	 * @param	none
	 * @return	void
	 */
	public function __construct()
	{
		add_action('plugins_loaded', array($this, 'set_default_options'));
		add_action('admin_init', array($this, 'menu_register_settings'));

		SamplySettings::init();
	}

	/**
	 * Plugin page handler
	 *
	 * @since 1.0.0
	 * @access	public
	 * @param	none
	 * @return	void
	 */
	public function plugin_page()
	{
		$settings = SamplySettings::setting_fields();
		$template = __DIR__ . '/views/samply-settings.php';

		if (file_exists($template)) {
			include $template;
		}
	}

	/**
	 * Save the setting options		
	 * 
	 * @since	1.0.0
	 * @access 	public
	 * @param	array
	 * @return	void
	 */
	public function menu_register_settings()
	{
		add_option($this->_optionName, $this->_defaultOptions);
		register_setting($this->_optionGroup, $this->_optionName);
	}

	/**
	 * Apply filter with default options
	 * 
	 * @since	1.0.0
	 * @access	public
	 * @param	none
	 * @return	void
	 */
	public function set_default_options()
	{
		return apply_filters('samply_default_options', $this->_defaultOptions);
	}
}
