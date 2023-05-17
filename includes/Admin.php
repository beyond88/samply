<?php

namespace Samply;

/**
 * The admin class
 */
class Admin {

    /**
     * Initialize the class
     */
    function __construct() {
        $main = new Admin\Main();
        $this->dispatch_actions( $main );

        new Admin\Menu( $main );
        new Admin\PluginMeta();
    }

    /**
     * Dispatch and bind actions
     *
     * @return void
     */
    public function dispatch_actions( $main ) {

    }
}