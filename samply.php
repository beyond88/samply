<?php

/**
 * Plugin Name: Samply - WooCommerce Product Sample Solution
 * Description: An ultimate plugin to replicate an actual product with custom prices to order as a sample product.
 * Plugin URI: https://github.com/beyond88/samply
 * Author: Mohiuddin Abdul Kader
 * Author URI: https://github.com/beyond88
 * Version: 1.0.11
 * License: GPL2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       samply
 * Domain Path:       /languages
 * Requires PHP:      5.6
 * Requires at least: 4.4
 * Tested up to:      6.2
 * @package Samply
 *
 * WC requires at least: 3.1
 * WC tested up to:   7.0.0
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html 
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * The main plugin class
 */
final class Samply
{

    /**
     * Plugin version
     *
     * @var string
     */
    const version = '1.0.11';

    /**
     * Class constructor
     */
    private function __construct()
    {
        $this->define_constants();

        register_activation_hook(__FILE__, [$this, 'activate']);

        add_action('plugins_loaded', [$this, 'init_plugin']);
    }

    /**
     * Initializes a singleton instance
     *
     * @return \Samply
     */
    public static function init()
    {
        static $instance = false;

        if (!$instance) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define the required plugin constants
     *
     * @return void
     */
    public function define_constants()
    {
        define('SAMPLY_VERSION', self::version);
        define('SAMPLY_FILE', __FILE__);
        define('SAMPLY_PATH', __DIR__);
        define('SAMPLY_URL', plugins_url('', SAMPLY_FILE));
        define('SAMPLY_ASSETS', SAMPLY_URL . '/assets');
        define('SAMPLY_BASENAME', plugin_basename(__FILE__));
        define('SAMPLY_PLUGIN_NAME', 'Samply');
        define('SAMPLY_MIN_WC_VERSION', '3.1');
        define('SAMPLY_MINIMUM_PHP_VERSION', '5.6.0');
        define('SAMPLY_MINIMUM_WP_VERSION', '4.4');
        define('SAMPLY_MINIMUM_WC_VERSION', '3.1');
    }

    /**
     * Initialize the plugin
     *
     * @return void
     */
    public function init_plugin()
    {

        new Samply\Assets();
        new Samply\Samplyi18n();

        if (defined('DOING_AJAX') && DOING_AJAX) {
            new Samply\Ajax();
        }

        if (is_admin()) {
            new Samply\Admin();
        } else {
            new Samply\Frontend();
        }
    }

    /**
     * Do stuff upon plugin activation
     *
     * @return void
     */
    public function activate()
    {
        $installer = new Samply\Installer();
        $installer->run();
    }
}

/**
 * Initializes the main plugin
 */
function samply()
{
    return Samply::init();
}

// kick-off the plugin
samply();
