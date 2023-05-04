<?php

    $attrs = '';
    if ( isset( $setting_options[$value['name']] ) && absint( $setting_options[$value['name']] ) == 1 ) {
        $attrs .= ' checked="checked"';
    }
?>
<label class="switch">
    <input class="<?php echo esc_attr( $value['class'] ); ?>" id="<?php echo esc_attr($value['name']); ?>" type="checkbox" name="<?php echo esc_html($this->_optionName."[".$value['name']."]"); ?>" value="1" <?php echo __($attrs); ?>>
    <div class="slider"></div>
</label>
