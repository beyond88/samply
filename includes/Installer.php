<?php
namespace Samply;

/**
 * Installer class
 */
class Installer {

    /**
     * Run the installer
     * 
     * @since   1.0.0
     * @access  public
     * @param   none
     * @return  void
    */
    public function run() {
        $this->add_version();
    }

    /**
     * Add time and version on DB
     * 
     * @since   1.0.0
     * @access  public
     * @param   none
     * @return  void
     */
    public function add_version() {
        $installed = get_option( 'samply_installed' );

        if ( ! $installed ) {
            update_option( 'samply_installed', time() );
        }

        update_option( 'samply_version', SAMPLY_VERSION );
    }

}
