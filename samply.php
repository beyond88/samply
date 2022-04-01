<?php
/**
 * Plugin Name: Samply
 * Description: A plugin for WooCommerce Product Sample.
 * Plugin URI: https://github.com/beyond88/sample
 * Author: beyond88
 * Author URI: https://github.com/beyond88
 * Version: 1.0.0
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 */
final class Samply {

    /**
     * Plugin version
     *
     * @var string
     */
    const version = '1.0';

    /**
     * Class constructor
     */
    private function __construct() {
        $this->define_constants();

        register_activation_hook( __FILE__, [ $this, 'activate' ] );

        add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
    }

    /**
     * Initializes a singleton instance
     *
     * @return \Samply
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants() {
        define( 'SAMPLY_VERSION', self::version );
        define( 'SAMPLY_FILE', __FILE__ );
        define( 'SAMPLY_PATH', __DIR__ );
        define( 'SAMPLY_URL', plugins_url( '', SAMPLY_FILE ) );
        define( 'SAMPLY_ASSETS', SAMPLY_URL . '/assets' );
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin() {

        new Samply\Assets();

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            new Samply\Ajax();
        }

        if ( is_admin() ) {
            new Samply\Admin();
        } else {
            new Samply\Frontend();
        }

        new Samply\API();
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate() {
        $installer = new Samply\Installer();
        $installer->run();
    }
}

/**
 * Initializes the main plugin
 */
function samply() {
    return Samply::init();
}

// kick-off the plugin
samply();
