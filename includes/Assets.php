<?php

namespace Samply;

/**
 * Assets handlers class
 */
class Assets {


	/**
	 * Class constructor
	 */
	function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'register_assets' ) );

		if ( isset( $_GET['page'] ) && $_GET['page'] == 'samply' ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'register_admin_assets' ) );
		}

	}

	/**
	 * All available scripts
	 *
	 * @return array
	 */
	public function get_scripts() {
		 return array(
			 'samply-script' => array(
				 'src'     => SAMPLY_ASSETS . '/js/frontend.js',
				 'version' => filemtime( SAMPLY_PATH . '/assets/js/frontend.js' ),
				 'deps'    => array( 'jquery' ),
			 ),
		 );
	}

	/**
	 * All available styles
	 *
	 * @return array
	 */
	public function get_styles() {
		return array(
			'samply-style' => array(
				'src'     => SAMPLY_ASSETS . '/css/frontend.css',
				'version' => filemtime( SAMPLY_PATH . '/assets/css/frontend.css' ),
			),

		);
	}

	/**
	 * Register scripts and styles
	 *
	 * @return void
	 */
	public function register_assets() {
		$scripts = $this->get_scripts();
		$styles  = $this->get_styles();

		foreach ( $scripts as $handle => $script ) {
			$deps = isset( $script['deps'] ) ? $script['deps'] : false;
			$type = isset( $script['type'] ) ? $script['type'] : '';
			if ( isset( $_GET['page'] ) && $_GET['page'] == 'samply' ) {

			}
			wp_enqueue_script( $handle, $script['src'], $deps, $script['version'], true );
		}

		foreach ( $styles as $handle => $style ) {
			$deps = isset( $style['deps'] ) ? $style['deps'] : false;
			$type = isset( $script['type'] ) ? $script['type'] : '';

			wp_enqueue_style( $handle, $style['src'], $deps, $style['version'] );
		}
	}


	/**
	 * All available scripts
	 *
	 * @return array
	 */
	public function get_admin_scripts() {
		return array(
			'samply-admin-script' => array(
				'src'     => SAMPLY_ASSETS . '/js/admin.js',
				'version' => filemtime( SAMPLY_PATH . '/assets/js/admin.js' ),
				'deps'    => array( 'jquery' ),
			),
		);
	}

	/**
	 * All available styles
	 *
	 * @return array
	 */
	public function get_admin_styles() {
		return array(
			'samply-admin-style' => array(
				'src'     => SAMPLY_ASSETS . '/css/admin.css',
				'version' => filemtime( SAMPLY_PATH . '/assets/css/admin.css' ),
			),
		);
	}

	/**
	 * Register scripts and styles
	 *
	 * @return void
	 */
	public function register_admin_assets() {
		$scripts = $this->get_admin_scripts();
		$styles  = $this->get_admin_styles();

		foreach ( $scripts as $handle => $script ) {
			$deps = isset( $script['deps'] ) ? $script['deps'] : false;
			$type = isset( $script['type'] ) ? $script['type'] : '';
			if ( isset( $_GET['page'] ) && $_GET['page'] == 'samply' ) {

			}
			wp_enqueue_script( $handle, $script['src'], $deps, $script['version'], true );
		}

		foreach ( $styles as $handle => $style ) {
			$deps = isset( $style['deps'] ) ? $style['deps'] : false;
			$type = isset( $script['type'] ) ? $script['type'] : '';

			wp_enqueue_style( $handle, $style['src'], $deps, $style['version'] );
		}

		wp_localize_script(
			'samply-admin-script',
			'samply',
			array(
				'nonce'   => wp_create_nonce( 'samply-admin-nonce' ),
				'confirm' => __( 'Are you sure?', 'samply' ),
				'error'   => __( 'Something went wrong', 'samply' ),
			)
		);
	}
}
