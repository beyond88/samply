<?php

namespace Samply;

/**
 * The admin class
 */
class Admin {

    /**
     * Initialize the class
     * 
     * @since   1.0.0
     * @access  public
     * @param   none
     * @return  void
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
     * @since   1.0.0
     * @access  public
     * @param   string
     * @return  void
     */
    public function dispatch_actions( $main ) {

    }
}