<?php

namespace Samply\Admin;

class PluginMeta {

    public function __construct(){

        add_filter( 'plugin_action_links_' . SAMPLY_BASENAME, [$this, 'pluginActionLinks'] );
        add_filter('plugin_row_meta', [$this, 'pluginMetaLinks'], 10, 2);

    }

    public function pluginActionLinks( $links ) {

        $links[] = '<a href="' . admin_url( 'admin.php?page=samply' ) . '">' . __( 'Settings', 'samply' ) . '</a>';
		$links[] = '<a href="https://ourtechbro.com/docs">' . __( 'Docs', 'samply' ) . '</a>';
        return $links;

    }

    public function pluginMetaLinks( $links, $file ){
        
        if ($file !== plugin_basename( SAMPLY_FILE )) {
			return $links;
		}

		$support_link = '<a target="_blank" href="https://ourtechbro.com/support" title="' . __('Get help', 'samply') . '">' . __('Support', 'samply') . '</a>';
		$home_link = '<a target="_blank" href="https://ourtechbro.com" title="' . __('Plugin Homepage', 'samply') . '">' . __('Plugin Homepage', 'samply') . '</a>';
		$rate_link = '<a target="_blank" href="https://ourtechbro.com" title="' . __('Rate the plugin', 'samply') . '">' . __('Rate the plugin ★★★★★', 'samply') . '</a>';

		$links[] = $support_link;
		$links[] = $home_link;
		$links[] = $rate_link;

		return $links;

    }
}