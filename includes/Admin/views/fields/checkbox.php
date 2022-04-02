<?php

    $attrs = '';
    if ( isset( $setting_options[$value['name']] ) && absint( $setting_options[$value['name']] ) == 1 ) {
        $attrs .= ' checked="checked"';
    }

    if( $is_pro && ! Samply\Helper::isPro() ) {
        $attrs = '';
        if($default){
            $attrs .= ' checked="checked"';
        }
    }
?>
<label class="switch">
    <input class="<?php echo esc_attr( $value['class'] ); ?>" <?php if( isset($value['is_pro']) && $value['is_pro'] == true && ! Samply\Helper::isPro()) { ?>disabled<?php } ?> id="<?php echo $value['name']; ?>" type="checkbox" name="<?php echo $this->_optionName."[".$value['name']."]"; ?>" value="1" <?php echo $attrs; ?>>
    <div class="slider"></div>
</label>
