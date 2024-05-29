<?php
settings_errors();
$setting_options = wp_parse_args(get_option($this->_optionName), $this->_defaultOptions);

if (!isset($setting_options['builder_id'])) {
    $current_tab = 'general_settings';
} else {
    $current_tab = $setting_options['builder_id'];
}
?>
<div class="samply-settings-wrap">
    <?php do_action('samply_settings_header'); ?>

    <div class="samply-left-right-settings">
        <div class="samply-settings">
            <div class="samply-settings-menu">
                <ul>
                    <?php
                    $i = 1;
                    foreach ($settings['tabs'] as $key => $setting) {
                        $active = $current_tab == $key ? 'active' : '';

                        echo '<li class="' . esc_attr($active) . '" data-tab="' . esc_attr($key) . '"><a href="#' . esc_attr($key) . '">' . esc_attr($setting['title']) . '</a></li>';
                    }
                    ?>
                </ul>
            </div>
            <div class="samply-settings-content">
                <div class="samply-settings-form-wrapper">
                    <form method="post" id="samply-settings-form" action="options.php" novalidate="novalidate">
                        <input id="samply_builder_id" type="hidden" name="samply_settings[builder_id]" value="<?php echo esc_attr($current_tab); ?>">
                        <?php settings_fields($this->_optionGroup); ?>
                        <?php
                        $i = 1;
                        foreach ($settings['tabs'] as $sec_id => $section) :
                            $active = $current_tab == $sec_id ? 'active' : '';

                            $child_sections = $section['sections'];
                        ?>
                            <div id="samply-<?php echo esc_attr($sec_id); ?>" class="samply-settings-tab <?php echo esc_attr($active); ?>">
                                <div id="samply-settings-general_settings" class="samply-settings-section samply-<?php echo esc_attr($sec_id); ?>">
                                    <?php
                                    foreach ($child_sections as $sec_id => $grand_child_section) :
                                        $fields = $grand_child_section['fields'];
                                    ?>
                                        <table>
                                            <tbody>
                                                <?php foreach ($fields as  $key => $value) : ?>
                                                    <?php $file_name = isset($value['type']) ? $value['type'] : 'text'; ?>
                                                    <?php $style = isset($value['style']) ? $value['style'] : ''; ?>
                                                    <tr data-id="<?php echo esc_attr($value['name']); ?>" id="samply-meta-<?php echo esc_attr($value['name']); ?>" class="samply-field samply-meta-<?php echo esc_attr($file_name); ?> type-<?php echo esc_attr($file_name); ?> <?php echo esc_attr($style); ?>">
                                                        <th class="samply-label">
                                                            <label for="<?php echo esc_attr($value['name']); ?>">
                                                                <?php echo esc_attr($value['label']); ?>
                                                            </label>
                                                        </th>
                                                        <td class="samply-control">
                                                            <div class="samply-control-wrapper">
                                                                <?php
                                                                if ($file_name) {
                                                                    include 'fields/' . $file_name . '.php';
                                                                }
                                                                $whitelisted_tag = [
                                                                    'strong' => []
                                                                ];
                                                                ?>
                                                                <?php if (isset($value['description'])  && !empty($value['description'])) { ?>
                                                                    <p class="samply-field-help"><?php echo sprintf(wp_kses(__('%s', 'sample'), $whitelisted_tag), $value['description']); ?></p>
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
                        <?php do_settings_fields($this->_optionGroup, 'default'); ?>
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

            <?php do_action('samply_settings_footer'); ?>
        </div>
    </div>
</div>