<?php 
	settings_errors(); 
	$setting_options = wp_parse_args( get_option($this->_optionName), $this->_defaultOptions );
?>
<div class="container-fluid">
	<?php include 'header.php'; ?>

    <div class="py-3">
    <form method="post" action="options.php" novalidate="novalidate">
        <?php settings_fields( $this->_optionGroup ); ?>
        <?php
        $is_pro = false;
        foreach( $settings['tabs'] as $id => $tab  ) {
            $sections = $tab['sections'];
            ?>
            <div data-id="wfps_<?php echo esc_attr($id); ?>">
                <div class="wfps_setting_tab_heading">
                    <h2><?php echo $tab['title']; ?></h2>
                </div>

                <div class="wfps_setting_form_setting_tab">
                    <div class="wfps_settings_outer_left">
                        <div class="wfps_inside">
                            <?php
                            foreach( $sections as $sec_id => $section ) {
                                $fields = $section['fields'];
                                ?>
                                <div class="container">
                                    <div class="row">
                                        <div class="card w-75">
                                            <div class="card-body">
                                                <?php foreach( $fields as  $key => $value ) : ?>
                                                    <div class="mb-3 row">
                                                        <label for="<?php echo $value['name']; ?>" class="col-sm-2 col-form-label"><?php echo $value['label']; ?></label>
                                                        <div class="col-sm-10">
                                                            <?php
                                                            $file_name = isset( $value['type'] ) ? $value['type'] : 'text';

                                                            if( $file_name ) {
                                                                include 'fields/'. $file_name .'.php';
                                                            }
                                                            if( isset( $value['description'] ) ) {
                                                                ?>
                                                                <small class="form-text text-muted">
                                                                    <?php echo $value['description']; ?>
                                                                </small>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <?php do_settings_fields( $this->_optionGroup, 'default' ); ?>
        <?php do_settings_sections($this->_optionGroup, 'default'); ?>
        <?php submit_button(); ?>
    </form>
    </div>
    <?php include 'footer.php'; ?>
</div> 