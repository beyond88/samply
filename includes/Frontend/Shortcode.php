<?php

namespace Samply\Frontend;

/**
 * Shortcode handler class
 */
class Shortcode {

	/**
	 * Initializes the class
	 */
	function __construct() {
		add_shortcode( 'samply', array( $this, 'render_shortcode' ) );
	}

	/**
	 * Shortcode handler class
	 *
	 * @param  array  $atts
	 * @param  string $content
	 *
	 * @return string
	 */
	public function render_shortcode( $atts, $content = '' ) {
		wp_enqueue_script( 'samply-script' );
		wp_enqueue_style( 'samply-style' );

		return '<div class="samply-shortcode">Hola!</div>';
	}
}
