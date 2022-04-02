<?php

namespace Samply\Admin;

/**
 * The Menu handler class
 */
class Menu {

    public $licence;
    public $main;


    /**
     * Initialize the class
     */
    function __construct( $main, $licence ) 
    {
        $this->main = $main;
        $this->licence = $licence;

        add_action( 'admin_menu', [ $this, 'adminMenu' ] );
    }

    /**
     * Register admin menu
     *
     * @return void
     */
    public function adminMenu() 
    {
        $parent_slug = 'samply';
        $capability = 'manage_options';

        $hook = add_menu_page( __( 'Samply Settings', 'samply' ), __( 'Samply', 'samply' ), $capability, $parent_slug, [ $this->main, 'plugin_page' ], 'dashicons-yes-alt', 60 );
        //add_submenu_page( $parent_slug, __( 'Licence', 'samply' ), __( 'Licence', 'samply' ), $capability, 'samply-licence', [ $this->licence, 'licence_page' ] );

        add_action( 'admin_head-' . $hook, [ $this, 'enqueueAssets' ] );
    }

    /**
     * Enqueue scripts and styles
     *
     * @return void
     */
    public function enqueueAssets() 
    {
        wp_enqueue_style( 'samply-admin-style' );
        wp_enqueue_script( 'samply-admin-script' );
    }


}
