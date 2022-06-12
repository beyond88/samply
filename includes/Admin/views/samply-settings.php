<?php 
	settings_errors(); 
	$setting_options = wp_parse_args( get_option($this->_optionName), $this->_defaultOptions );
?>
<div class="samply-settings-wrap">
    <?php do_action( 'samply_settings_header' ); ?>

    <div class="samply-left-right-settings">
        <div class="samply-settings">
            <div class="samply-settings-menu">
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
            <div class="samply-settings-content">
                <div class="samply-settings-form-wrapper">
                    <form method="post" id="samply-settings-form" action="#">
                    <?php
                        $i = 1;
                        foreach( $settings ['tabs'] as $sec_id => $section ) :
                            $active = $i++ === 1 ? 'active ' : '';
                            $child_sections = $section['sections'];
                        ?>
                        <div id="samply-<?php echo $sec_id; ?>" class="samply-settings-tab samply-settings-betterdocs_instant_answer <?php echo $active; ?>">
                            <div id="samply-settings-general_settings" class="samply-settings-section samply-<?php echo $sec_id; ?>">
                            <?php
                            foreach( $child_sections as $sec_id => $grand_child_section ) :
                                $fields = $grand_child_section['fields'];
                                ?>
                                <table>
                                    <tbody>
                                        <?php foreach( $fields as  $key => $value ) : ?>
                                        <?php $file_name = isset( $value['type'] ) ? $value['type'] : 'text'; ?>    
                                        <tr data-id="<?php echo $value['name']; ?>" id="samply-meta-<?php echo $value['name']; ?>" class="samply-field samply-meta-<?php echo $file_name; ?> type-<?php echo $file_name; ?>">
                                            <th class="samply-label">
                                                <label for="<?php echo $value['name']; ?>">
                                                    <?php echo $value['label']; ?>
                                                </label>
                                            </th>
                                            <td class="samply-control">
                                                <div class="samply-control-wrapper">
                                                    
                                                    <?php 
                                                        if( $file_name ) {
                                                            include 'fields/'. $file_name .'.php';
                                                        }                                                    
                                                    ?>
                                                    <?php if( isset( $value['description'] )  && ! empty( $value['description'] ) ) { ?>
                                                    <p class="samply-field-help"><?php echo $value['description']; ?></p>            
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
                    <?php submit_button('Save Settings', 'btn-settings samply-settings-button'); ?>
                    </form>
                </div>

                <div class="samply-settings-right">
                    <div class="samply-sidebar">
                        <div class="samply-sidebar-block">
                            <div class="samply-admin-sidebar-logo">
                                <img alt="Samply" src="<?php echo SAMPLY_ASSETS; ?>/img/samply-logo.svg">
                            </div>
                            <div class="samply-admin-sidebar-cta">
                                <a rel="nofollow" href="#" target="_blank"><?php echo __('Upgrade to Pro', 'samply'); ?></a>            
                            </div>
                        </div>
                        <div class="samply-sidebar-block samply-license-block">
                        </div>
                    </div>
                </div>
            </div>
            
            <?php do_action( 'samply_settings_footer' ); ?>
        </div>
    </div>    
</div>    