<?php

namespace Samply;

/**
 * API Class
 */
class API {

    /**
     * Initialize the class
     * 
     * @since   1.0.0
     * @access  public
     * @param   none
     * @return  void
     */
    function __construct() {
        add_action( 'rest_api_init', array( $this, 'register_api' ) );
    }

    /**
     * Register the API
     *
     * @since   1.0.0
     * @access  public
     * @param   none
     * @return  void
     */
    public function register_api() {}
}
