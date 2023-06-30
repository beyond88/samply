<?php

namespace Samply\Admin;
use Samply\Helper; 

/**
 * The Menu handler class
 */
class Menu {

    /**
     * Plugin main file
     *
     * @var string
    */
    public $main;

    /**
     * Initialize the class
     * 
     * @since   1.0.0
     * @access  public
     * @param   object
     * @return  void
     */
    function __construct( $main ) {
        $this->main = $main;
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }

    /**
     * Register admin menu
     *
     * @since   1.0.0
     * @access  public
     * @param   none   
     * @return  void
     */
    public function admin_menu() {
        $parent_slug = 'samply';
        $capability = 'manage_options';
        $icon_url = SAMPLY_ASSETS . '/img/samply-icon.svg';

        $settings   = apply_filters( 'samply_admin_menu', array() );        

        $hook = add_menu_page( __( 'Samply Settings', 'samply' ), __( 'Samply', 'samply' ), $capability, $parent_slug, [ $this->main, 'plugin_page' ], $icon_url, 50 );
        add_action( 'admin_head-' . $hook, array( $this, 'enqueue_assets' ) );

        foreach( $settings as $slug => $setting ) {
            $cap  = isset( $setting['capability'] ) ? $setting['capability'] : 'delete_users';
            if( Helper::is_pro() ) {
                add_submenu_page( $setting['parent_slug'], $setting['page_title'], $setting['menu_title'], $cap, $slug, $setting['callback'] );
            }
        }
    }

    /**
     * Enqueue scripts and styles
     *
     * @since   1.0.0
     * @access  public
     * @param   none   
     * @return  void
     */
    public function enqueue_assets() {
        wp_enqueue_style( 'samply-admin-boostrap' );
        wp_enqueue_style( 'samply-admin-style' );
        wp_enqueue_script( 'samply-admin-script' );
    }

}
