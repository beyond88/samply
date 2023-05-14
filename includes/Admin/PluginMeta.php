<?php

namespace Samply\Admin;

/**
* Initiate plugin action links
*
* @since    1.0.0
*/
class PluginMeta {

    public function __construct() {
        add_filter( 'plugin_action_links_' . SAMPLY_BASENAME, [ $this, 'plugin_action_links' ] );
        add_filter( 'plugin_row_meta', [ $this, 'plugin_meta_links' ], 10, 2 );
    }

    /**
    * Create plugin action links
    *
    * @since    1.0.0
    * @param    array
    * @return   array
    */
    public function plugin_action_links( $links ) {

        $links[] = '<a href="' . admin_url( 'admin.php?page=samply#general_settings' ) . '">' . __( 'Settings', 'samply' ) . '</a>';
		$links[] = '<a href="https://github.com/beyond88/samply/wiki">' . __( 'Docs', 'samply' ) . '</a>';
        return $links;

    }

    /**
    * Create plugin meta links
    *
    * @since    1.0.0
    * @param    array string
    * @return   array
    */
    public function plugin_meta_links( $links, $file ) {
        
        if ($file !== plugin_basename( SAMPLY_FILE )) {
			return $links;
		}

		$support_link = '<a target="_blank" href="https://github.com/beyond88/samply/issues" title="' . __('Get help', 'samply') . '">' . __('Support', 'samply') . '</a>';
		$home_link = '<a target="_blank" href="https://github.com/beyond88/samply" title="' . __('Plugin Homepage', 'samply') . '">' . __('Plugin Homepage', 'samply') . '</a>';
		$rate_link = '<a target="_blank" href="https://wordpress.org/support/plugin/samply/reviews/#new-post" title="' . __('Rate the plugin', 'samply') . '">' . __('Rate the plugin ★★★★★', 'samply') . '</a>';

		$links[] = $support_link;
		$links[] = $home_link;
		$links[] = $rate_link;

		return $links;

    }
}