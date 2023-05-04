<?php

namespace Samply;

/**
 * The admin class
 */
class Admin 
{

    /**
     * Initialize the class
     */
    function __construct() 
    {
        $main = new Admin\Main();
        $licence = new Admin\Licence();

        $this->dispatch_actions( $main, $licence );

        new Admin\Menu( $main, $licence );
        new Admin\PluginMeta();
    }

    /**
     * Dispatch and bind actions
     *
     * @return void
     */
    public function dispatch_actions( $main, $licence ) 
    {

    }
}