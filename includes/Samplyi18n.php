<?php

namespace Samply;

class Samplyi18n {

    public function __construct()
    {
        add_action( 'plugins_loaded', [ $this, 'load_plugin_textdomain' ] );
    }
	/**
	 *
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() 
	{

		load_plugin_textdomain(
			'samply',
			false,
			dirname( dirname( SAMPLY_BASENAME ) ) . '/languages/'
		);

	}


}