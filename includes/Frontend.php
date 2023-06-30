<?php
namespace Samply;

/**
* Frontend handler class
* 
* @since    1.0.0
* @param    none
* @return   object
*/
class Frontend {

    /**
    * Initialize the class
    *
    * @since    1.0.0
    * @param    none
    * @return   object
    */
    function __construct() {
        new Frontend\Shortcode();
        new Frontend\SamplyWooCommerce();
    }
}
