<?php 
	settings_errors(); 
	$setting_options = wp_parse_args( get_option($this->_optionName), $this->_defaultOptions );
?>
<div class="betterdocs-settings-wrap">
    <?php do_action( 'samply_settings_header' ); ?>

    <div class="betterdocs-left-right-settings">
        <div class="betterdocs-settings">
            <div class="betterdocs-settings-menu">
                <ul>
                    <?php
                        $i = 1;
                        foreach( $settings['tabs'] as $key => $setting ) {
                            $active = $i++ === 1 ? 'active ' : '';
                            echo '<li class="'. $active .'" data-tab="'. $key .'"><a href="#'. $key .'">'. $setting['title'] .'</a></li>';
                        }
                    ?>
                </ul>
            </div>
            <div class="betterdocs-settings-content">
                <div class="betterdocs-settings-form-wrapper">
                    <form method="post" id="betterdocs-settings-form" action="#">
                    <?php
                        $i = 1;
                        foreach( $settings ['tabs'] as $sec_id => $section ) :
                            $active = $i++ === 1 ? 'active ' : '';
                            $child_sections = $section['sections'];
                        ?>
                        <div id="betterdocs-<?php echo $sec_id; ?>" class="betterdocs-settings-tab betterdocs-settings-betterdocs_instant_answer <?php echo $active; ?>">
                            <div id="betterdocs-settings-general_settings" class="betterdocs-settings-section betterdocs-<?php echo $sec_id; ?>">
                            <?php
                            foreach( $child_sections as $sec_id => $grand_child_section ) :
                                $fields = $grand_child_section['fields'];
                                ?>
                                <table>
                                    <tbody>
                                        <?php foreach( $fields as  $key => $value ) : ?>
                                        <?php $file_name = isset( $value['type'] ) ? $value['type'] : 'text'; ?>    
                                        <tr data-id="<?php echo $value['name']; ?>" id="betterdocs-meta-<?php echo $value['name']; ?>" class="betterdocs-field betterdocs-meta-<?php echo $file_name; ?> type-<?php echo $file_name; ?>">
                                            <th class="betterdocs-label">
                                                <label for="<?php echo $value['name']; ?>">
                                                    <?php echo $value['label']; ?>
                                                </label>
                                            </th>
                                            <td class="betterdocs-control">
                                                <div class="betterdocs-control-wrapper">
                                                    
                                                    <?php 
                                                        if( $file_name ) {
                                                            include 'fields/'. $file_name .'.php';
                                                        }                                                    
                                                    ?>
                                                    <?php if( isset( $value['description'] )  && ! empty( $value['description'] ) ) { ?>
                                                    <p class="betterdocs-field-help"><?php echo $value['description']; ?></p>            
                                                    <?php } ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endforeach; ?>
                            </div>                            
                        </div>
                    <?php endforeach; ?>
                    <?php do_settings_fields( $this->_optionGroup, 'default' ); ?>
                    <?php do_settings_sections($this->_optionGroup, 'default'); ?>
                    <?php submit_button('Save Settings', 'btn-settings betterdocs-settings-button'); ?>
                    </form>
                </div>

                <div class="betterdocs-settings-right">
                    <div class="betterdocs-sidebar">
                        <div class="betterdocs-sidebar-block">
                            <div class="betterdocs-admin-sidebar-logo">
                            <img alt="BetterDocs" src="http://wordpress.test/wp-content/plugins/betterdocs/admin/partials/../assets/img/betterdocs-icon.svg">
                            </div>
                            <div class="betterdocs-admin-sidebar-cta">
                            <a rel="nofollow" href="https://betterdocs.co/upgrade" target="_blank">Upgrade to Pro</a>            
                            </div>
                        </div>
                        <div class="betterdocs-sidebar-block betterdocs-license-block">
                        </div>
                    </div>
                </div>
            </div>
            
            <?php do_action( 'samply_settings_footer' ); ?>
        </div>
    </div>    
</div>    