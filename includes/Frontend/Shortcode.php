<?php

namespace Samply\Frontend;

use Samply\Frontend\Shortcodes\AddToCart;

/**
 * Shortcode handler class
 */
class Shortcode {

    /**
     * Initializes the class
     * 
     * @since   1.0.0
     * @access  public
     * @param   none
     * @return  void
     */
    function __construct() {
        new AddToCart();
    }
}
