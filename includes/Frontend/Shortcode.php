<?php

namespace Samply\Frontend;

use Samply\Frontend\Shortcodes\AddToCart;

/**
 * Shortcode handler class
 */
class Shortcode {

    /**
     * Initializes the class
     */
    function __construct() {
        new AddToCart();
    }
}
