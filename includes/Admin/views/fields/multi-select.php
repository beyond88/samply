
<select class="<?php echo esc_attr( $value['class'] ); ?>" id="<?php echo esc_attr($value['name']); ?>" name="<?php echo esc_html($this->_optionName."[".$value['name']."]"); ?>[]" multiple="multiple">
    <option value=""><?php esc_html_e( 'All', 'samply' ); ?></option>
    <?php 

        foreach( $value['default'] as $val ) :

            $option_value = $option_title = '';
            if( is_object( $val ) ) {
                $option_value = $val->ID;
                $option_title = $val->post_title;
            } else {
                $option_value = $val['ID'];
                $option_title = $val['post_title'];   
            } 

            $selected = '';
            if( isset( $setting_options[ $value['name'] ] ) ) :
                if( in_array( $option_value, $setting_options[ $value['name'] ] ) ) :
                    $selected ='selected';
                endif;
            endif;    
    ?>
    <option value="<?php echo esc_attr($option_value); ?>" <?php echo esc_attr($selected); ?>><?php echo esc_attr($option_title); ?></option>
    <?php 
        endforeach;
    ?>
</select>