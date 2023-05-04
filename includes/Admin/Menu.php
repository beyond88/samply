<?php

namespace Samply\Admin;

/**
 * The Menu handler class
 */
class Menu {

    /**
    * Plugin lisence
    *
    */
    public $licence;

    /**
    * Plugin main file
    *
    */
    public $main;

    /**
     * Initialize the class
     */
    function __construct( $main, $licence ) 
    {
        $this->main = $main;
        $this->licence = $licence;

        add_action( 'admin_menu', [ $this, 'admin_menu' ] );
    }

    /**
     * Register admin menu
     *
     * @return void
     */
    public function admin_menu() 
    {
        $parent_slug = 'samply';
        $capability = 'manage_options';
        $icon_url = SAMPLY_ASSETS . '/img/samply-icon.svg';

        $hook = add_menu_page( __( 'Samply Settings', 'samply' ), __( 'Samply', 'samply' ), $capability, $parent_slug, [ $this->main, 'plugin_page' ], $icon_url, 50 );
        add_action( 'admin_head-' . $hook, [ $this, 'enqueue_assets' ] );
    }

    /**
     * Enqueue scripts and styles
     *
     * @return void
     */
    public function enqueue_assets() 
    {
        wp_enqueue_style( 'samply-admin-boostrap' );
        wp_enqueue_style( 'samply-admin-style' );
        wp_enqueue_script( 'samply-admin-script' );
    }


}
