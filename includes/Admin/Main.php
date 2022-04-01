<?php

namespace Samply\Admin;

/**
 * Settings Handler class
 */
class Main {
    /**
     * Plugin page handler
     *
     * @return void
     */
    public function plugin_page() {
        $template = __DIR__ . '/views/samply-settings.php';

        if ( file_exists( $template ) ) {
            include $template;
        }
    }
}
