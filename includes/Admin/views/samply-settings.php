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
                <div class="samply_setting_tab_heading">
                    <h2><?php echo $tab['title']; ?></h2>
                </div>

                <div class="samply_setting_form_setting_tab">
                    <div class="samply_settings_outer_left">
                        <div class="samply_inside">
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


<div class="betterdocs-settings-wrap">
    <div class="betterdocs-settings-header">
        <div class="betterdocs-header-full">
            <img src="<?php echo BETTERDOCS_ADMIN_URL ?>assets/img/betterdocs-icon.svg" alt="">
            <h2 class="title"><?php _e( 'BetterDocs Settings', 'betterdocs' ); ?></h2>
        </div>
    </div>

    <div class="betterdocs-left-right-settings">
        <div class="betterdocs-settings">
            <div class="betterdocs-settings-menu">
                <ul>
                    <li class="active" data-tab="general">
                        <a href="#general">General</a>
                    </li>
                    <li class="" data-tab="layout">
                        <a href="#layout">Layout</a>
                    </li>
                    <li class="" data-tab="design">
                        <a href="#design">Design</a>
                    </li>
                    <li class="" data-tab="shortcodes">
                        <a href="#shortcodes">Shortcodes</a>
                    </li>
                    <li class="" data-tab="betterdocs_advanced_settings">
                        <a href="#betterdocs_advanced_settings">Advanced Settings</a>
                    </li>
                    <li class="" data-tab="betterdocs_instant_answer">
                        <a href="#betterdocs_instant_answer">Instant Answer</a>
                    </li>                
                </ul>
            </div>
            <div class="betterdocs-settings-content" bis_skin_checked="1">
                <div class="betterdocs-settings-form-wrapper" bis_skin_checked="1">
                    <form method="post" id="betterdocs-settings-form" action="#">
                        <div id="betterdocs-general" class="betterdocs-settings-tab betterdocs-settings-betterdocs_instant_answer active" bis_skin_checked="1">
                            <div id="betterdocs-settings-general_settings" class="betterdocs-settings-section betterdocs-general_settings" bis_skin_checked="1">
                            <table>
                                <tbody>
                                    <tr data-id="multiple_kb" id="betterdocs-meta-multiple_kb" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                        <th class="betterdocs-label">
                                        <label for="multiple_kb">
                                        Enable Multiple Knowledge Base<sup class="pro-label">Pro</sup>
                                        </label>
                                        </th>
                                        <td class="betterdocs-control">
                                        <div class="betterdocs-control-wrapper betterdocs-opt-alert" bis_skin_checked="1">
                                            <input class="betterdocs-settings-field" type="checkbox" id="multiple_kb" name="multiple_kb" value="1" disabled="">            
                                        </div>
                                        </td>
                                    </tr>
                                    <tr data-id="builtin_doc_page" id="betterdocs-meta-builtin_doc_page" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                        <th class="betterdocs-label">
                                        <label for="builtin_doc_page">
                                        Enable Built-in Documentation Page
                                        </label>
                                        </th>
                                        <td class="betterdocs-control">
                                        <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                            <input class="betterdocs-settings-field" type="checkbox" id="builtin_doc_page" name="builtin_doc_page" value="1" checked="&quot;checked&quot;/">                        
                                            <p class="betterdocs-field-help"><strong>Note:</strong> if you disable built-in documentation page, you can use shortcode or page builder widgets to design your documentation page.</p>
                                        </div>
                                        </td>
                                    </tr>
                                    <tr data-id="breadcrumb_doc_title" id="betterdocs-meta-breadcrumb_doc_title" class="betterdocs-field betterdocs-meta-text type-text">
                                        <th class="betterdocs-label">
                                        <label for="breadcrumb_doc_title">
                                        Documentation Page Title
                                        </label>
                                        </th>
                                        <td class="betterdocs-control">
                                        <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                            <div class="betterdocs-settings-input-text" bis_skin_checked="1"><input class="betterdocs-settings-field" id="breadcrumb_doc_title" type="text" name="breadcrumb_doc_title" placeholder="" value="Docs" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%; cursor: auto;"></div>
                                        </div>
                                        </td>
                                    </tr>
                                    <tr data-id="docs_slug" id="betterdocs-meta-docs_slug" class="betterdocs-field betterdocs-meta-text type-text" style="">
                                        <th class="betterdocs-label">
                                        <label for="docs_slug">
                                        BetterDocs Root Slug
                                        </label>
                                        </th>
                                        <td class="betterdocs-control">
                                        <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                            <div class="betterdocs-settings-input-text" bis_skin_checked="1"><input class="betterdocs-settings-field" id="docs_slug" type="text" name="docs_slug" placeholder="" value="docs"></div>
                                        </div>
                                        </td>
                                    </tr>
                                    <tr data-id="docs_page" id="betterdocs-meta-docs_page" class="betterdocs-field betterdocs-meta-select type-select" style="display: none;">
                                        <th class="betterdocs-label">
                                        <label for="docs_page">
                                        Docs Page
                                        </label>
                                        </th>
                                        <td class="betterdocs-control">
                                        <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                            <select data-value="" class="betterdocs-settings-field betterdocs-select select2-hidden-accessible" name="docs_page" id="docs_page" data-select2-id="select2-data-docs_page" tabindex="-1" aria-hidden="true">
                                                <option value="0" data-select2-id="select2-data-2-kj36">Select a Page</option>
                                                <option value="189">Jobs</option>
                                                <option value="186">ReviewX Schedule Email Unsubscribe</option>
                                                <option value="177">Cancelled Vipps Purchase</option>
                                                <option value="9">My account</option>
                                                <option value="8">Checkout</option>
                                                <option value="7">Cart</option>
                                                <option value="6">Shop</option>
                                                <option value="2">Sample Page</option>
                                            </select>
                                            <span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-1-1w3m" style="width: 277px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-docs_page-container"><span class="select2-selection__rendered" id="select2-docs_page-container" role="textbox" aria-readonly="true" title="Select a Page">Select a Page</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>                        
                                            <p class="betterdocs-field-help">Note: You will need to insert BetterDocs Shortcode inside the page. This page will be used as docs permalink.</p>
                                        </div>
                                        </td>
                                    </tr>
                                    <tr data-id="category_slug" id="betterdocs-meta-category_slug" class="betterdocs-field betterdocs-meta-text type-text">
                                        <th class="betterdocs-label">
                                        <label for="category_slug">
                                        Custom Category Slug
                                        </label>
                                        </th>
                                        <td class="betterdocs-control">
                                        <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                            <div class="betterdocs-settings-input-text" bis_skin_checked="1"><input class="betterdocs-settings-field" id="category_slug" type="text" name="category_slug" placeholder="" value="docs-category"></div>
                                        </div>
                                        </td>
                                    </tr>
                                    <tr data-id="tag_slug" id="betterdocs-meta-tag_slug" class="betterdocs-field betterdocs-meta-text type-text">
                                        <th class="betterdocs-label">
                                        <label for="tag_slug">
                                        Custom Tag Slug
                                        </label>
                                        </th>
                                        <td class="betterdocs-control">
                                        <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                            <div class="betterdocs-settings-input-text" bis_skin_checked="1"><input class="betterdocs-settings-field" id="tag_slug" type="text" name="tag_slug" placeholder="" value="docs-tag"></div>
                                        </div>
                                        </td>
                                    </tr>
                                    <tr data-id="disable_root_slug_mkb" id="betterdocs-meta-disable_root_slug_mkb" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                        <th class="betterdocs-label">
                                        <label for="disable_root_slug_mkb">
                                        Disable Root slug for KB Archives<sup class="pro-label">Pro</sup>
                                        </label>
                                        </th>
                                        <td class="betterdocs-control">
                                        <div class="betterdocs-control-wrapper betterdocs-opt-alert" bis_skin_checked="1">
                                            <input class="betterdocs-settings-field" type="checkbox" id="disable_root_slug_mkb" name="disable_root_slug_mkb" value="1" disabled="">                        
                                            <p class="betterdocs-field-help"><strong>Note:</strong> if you disable root slug for KB Archives, your individual knowledge base URL will be like this: <b><i>https://example.com/knowledgebase-1</i></b></p>
                                        </div>
                                        </td>
                                    </tr>
                                    <tr data-id="permalink_structure" id="betterdocs-meta-permalink_structure" class="betterdocs-field betterdocs-meta-text type-text">
                                        <th class="betterdocs-label">
                                        <label for="permalink_structure">
                                        Single Docs Permalink
                                        </label>
                                        </th>
                                        <td class="betterdocs-control">
                                        <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                            <div class="betterdocs-settings-input-text" bis_skin_checked="1"><input class="betterdocs-settings-field" id="permalink_structure" type="text" name="permalink_structure" placeholder="" value="docs"></div>
                                            <p class="betterdocs-field-help"><b>Note:</b> Make sure to keep <b>Docs Root Slug</b> in the <b>Single Docs Permalink</b>. You are not able to keep it blank. You can use the available tags from below.
                                            </p>
                                            <div class="form-table permalink-structure" bis_skin_checked="1">
                                                <div class="available-structure-tags hide-if-no-js" bis_skin_checked="1">
                                                    <div id="custom_selection_updated" aria-live="assertive" class="screen-reader-text" bis_skin_checked="1"></div>
                                                    <ul role="list">
                                                    <li class="">
                                                        <button type="button" class="button button-secondary" aria-label="Docs Categories" data-added="doc_category added to permalink structure" data-used="doc_category (already used in permalink structure)">%doc_category%</button>
                                                    </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <p></p>
                                        </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                            <button type="submit" class="btn-settings betterdocs-settings-button betterdocs-submit-general" data-nonce="c058fbb317" data-key="general" id="betterdocs-submit-general">Save Settings</button>
                        </div>
                        <div id="betterdocs-layout" class="betterdocs-settings-tab betterdocs-settings-betterdocs_instant_answer" bis_skin_checked="1">
                            <div id="betterdocs-settings-layout_inner_tab" class="betterdocs-settings-section betterdocs-layout_inner_tab" bis_skin_checked="1">
                            <div class="betterdocs-section-inner-tab" bis_skin_checked="1">
                                <ul class="betterdocs-section-inner-tab-menu">
                                    <li data-target="documentation_page" class="betterdocs-active">Documentation Page</li>
                                    <li data-target="single_doc">Single Doc</li>
                                    <li data-target="archive_page">Archive Page</li>
                                </ul>
                                <div class="betterdocs-section-inner-tab-contents" bis_skin_checked="1">
                                    <div class="betterdocs-section-inner-tab-content" id="documentation_page" style="display: block;" bis_skin_checked="1">
                                        <table>
                                        <tbody>
                                            <tr data-id="doc_page" id="betterdocs-meta-doc_page" class="betterdocs-field betterdocs-meta-title type-title">
                                                <th colspan="2" class="betterdocs-control betterdocs-title">
                                                    <h3>Documentation Page</h3>
                                                </th>
                                            </tr>
                                            <tr data-id="live_search" id="betterdocs-meta-live_search" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                                <th class="betterdocs-label">
                                                    <label for="live_search">
                                                    Enable Live Search
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" type="checkbox" id="live_search" name="live_search" value="1" checked="&quot;checked&quot;/">            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="advance_search" id="betterdocs-meta-advance_search" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                                <th class="betterdocs-label">
                                                    <label for="advance_search">
                                                    Enable Advanced Search<sup class="pro-label">Pro</sup>
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper betterdocs-opt-alert" bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" type="checkbox" id="advance_search" name="advance_search" value="1" disabled="">            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="popular_keyword_limit" id="betterdocs-meta-popular_keyword_limit" class="betterdocs-field betterdocs-meta-number type-number">
                                                <th class="betterdocs-label">
                                                    <label for="popular_keyword_limit">
                                                    Minimum amount of Keywords Search<sup class="pro-label">Pro</sup>
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper betterdocs-opt-alert" bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" id="popular_keyword_limit" type="number" name="popular_keyword_limit" value="5">            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="search_placeholder" id="betterdocs-meta-search_placeholder" class="betterdocs-field betterdocs-meta-text type-text">
                                                <th class="betterdocs-label">
                                                    <label for="search_placeholder">
                                                    Search Placeholder
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <div class="betterdocs-settings-input-text" bis_skin_checked="1"><input class="betterdocs-settings-field" id="search_placeholder" type="text" name="search_placeholder" placeholder="" value="Search.."></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="search_button_text" id="betterdocs-meta-search_button_text" class="betterdocs-field betterdocs-meta-text type-text">
                                                <th class="betterdocs-label">
                                                    <label for="search_button_text">
                                                    Search Button Text<sup class="pro-label">Pro</sup>
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper betterdocs-opt-alert" bis_skin_checked="1">
                                                    <div class="betterdocs-settings-input-text" bis_skin_checked="1"><input class="betterdocs-settings-field" id="search_button_text" type="text" name="search_button_text" placeholder="" value="Search"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="search_not_found_text" id="betterdocs-meta-search_not_found_text" class="betterdocs-field betterdocs-meta-text type-text">
                                                <th class="betterdocs-label">
                                                    <label for="search_not_found_text">
                                                    Search Not Found Text
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <div class="betterdocs-settings-input-text" bis_skin_checked="1"><input class="betterdocs-settings-field" id="search_not_found_text" type="text" name="search_not_found_text" placeholder="" value="Sorry, no docs were found."></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="search_result_image" id="betterdocs-meta-search_result_image" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                                <th class="betterdocs-label">
                                                    <label for="search_result_image">
                                                    Search Result Image
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" type="checkbox" id="search_result_image" name="search_result_image" value="1" checked="&quot;checked&quot;/">            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="kb_based_search" id="betterdocs-meta-kb_based_search" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                                <th class="betterdocs-label">
                                                    <label for="kb_based_search">
                                                    Search Result based on KB<sup class="pro-label">Pro</sup>
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper betterdocs-opt-alert" bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" type="checkbox" id="kb_based_search" name="kb_based_search" value="1" disabled="">            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="masonry_layout" id="betterdocs-meta-masonry_layout" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                                <th class="betterdocs-label">
                                                    <label for="masonry_layout">
                                                    Enable Masonry
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" type="checkbox" id="masonry_layout" name="masonry_layout" value="1" checked="&quot;checked&quot;/">            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="terms_orderby" id="betterdocs-meta-terms_orderby" class="betterdocs-field betterdocs-meta-select type-select">
                                                <th class="betterdocs-label">
                                                    <label for="terms_orderby">
                                                    Terms Order By
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <select data-value="betterdocs_order" class="betterdocs-settings-field betterdocs-select select2-hidden-accessible" name="terms_orderby" id="terms_orderby" data-select2-id="select2-data-terms_orderby" tabindex="-1" aria-hidden="true">
                                                        <option value="none">No order</option>
                                                        <option value="name">Name</option>
                                                        <option value="slug">Slug</option>
                                                        <option value="term_group">Term Group</option>
                                                        <option value="term_id">Term ID</option>
                                                        <option value="id">ID</option>
                                                        <option value="description">Description</option>
                                                        <option value="parent">Parent</option>
                                                        <option value="betterdocs_order" selected="true" data-select2-id="select2-data-4-d9fe">BetterDocs Order</option>
                                                    </select>
                                                    <span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-3-bed3" style="width: auto;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-terms_orderby-container"><span class="select2-selection__rendered" id="select2-terms_orderby-container" role="textbox" aria-readonly="true" title="BetterDocs Order">BetterDocs Order</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="alphabetically_order_term" id="betterdocs-meta-alphabetically_order_term" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                                <th class="betterdocs-label">
                                                    <label for="alphabetically_order_term">
                                                    Order Terms Alphabetically
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" type="checkbox" id="alphabetically_order_term" name="alphabetically_order_term" value="1">            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="terms_order" id="betterdocs-meta-terms_order" class="betterdocs-field betterdocs-meta-select type-select">
                                                <th class="betterdocs-label">
                                                    <label for="terms_order">
                                                    Terms Order
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <select data-value="ASC" class="betterdocs-settings-field betterdocs-select select2-hidden-accessible" name="terms_order" id="terms_order" data-select2-id="select2-data-terms_order" tabindex="-1" aria-hidden="true">
                                                        <option value="ASC" selected="true" data-select2-id="select2-data-6-jgru">Ascending</option>
                                                        <option value="DESC">Descending</option>
                                                    </select>
                                                    <span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-5-2rrc" style="width: auto;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-terms_order-container"><span class="select2-selection__rendered" id="select2-terms_order-container" role="textbox" aria-readonly="true" title="Ascending">Ascending</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="alphabetically_order_post" id="betterdocs-meta-alphabetically_order_post" class="betterdocs-field betterdocs-meta-select type-select">
                                                <th class="betterdocs-label">
                                                    <label for="alphabetically_order_post">
                                                    Docs Order By
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <select data-value="none" class="betterdocs-settings-field betterdocs-select select2-hidden-accessible" name="alphabetically_order_post" id="alphabetically_order_post" data-select2-id="select2-data-alphabetically_order_post" tabindex="-1" aria-hidden="true">
                                                        <option value="none" selected="true" data-select2-id="select2-data-8-0edv">No order</option>
                                                        <option value="ID">Post ID</option>
                                                        <option value="author">Post Author</option>
                                                        <option value="1">Title</option>
                                                        <option value="date">Date</option>
                                                        <option value="modified">Last Modified Date</option>
                                                        <option value="parent">Parent Id</option>
                                                        <option value="rand">Random</option>
                                                        <option value="comment_count">Comment Count</option>
                                                        <option value="menu_order">Menu Order</option>
                                                    </select>
                                                    <span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-7-b7yu" style="width: auto;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-alphabetically_order_post-container"><span class="select2-selection__rendered" id="select2-alphabetically_order_post-container" role="textbox" aria-readonly="true" title="No order">No order</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="docs_order" id="betterdocs-meta-docs_order" class="betterdocs-field betterdocs-meta-select type-select">
                                                <th class="betterdocs-label">
                                                    <label for="docs_order">
                                                    Docs Order
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <select data-value="ASC" class="betterdocs-settings-field betterdocs-select select2-hidden-accessible" name="docs_order" id="docs_order" data-select2-id="select2-data-docs_order" tabindex="-1" aria-hidden="true">
                                                        <option value="ASC" selected="true" data-select2-id="select2-data-10-i6d8">Ascending</option>
                                                        <option value="DESC">Descending</option>
                                                    </select>
                                                    <span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="select2-data-9-lub3" style="width: auto;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-docs_order-container"><span class="select2-selection__rendered" id="select2-docs_order-container" role="textbox" aria-readonly="true" title="Ascending">Ascending</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="nested_subcategory" id="betterdocs-meta-nested_subcategory" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                                <th class="betterdocs-label">
                                                    <label for="nested_subcategory">
                                                    Nested Subcategory
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" type="checkbox" id="nested_subcategory" name="nested_subcategory" value="1">            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="column_number" id="betterdocs-meta-column_number" class="betterdocs-field betterdocs-meta-number type-number">
                                                <th class="betterdocs-label">
                                                    <label for="column_number">
                                                    Number of Columns
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" id="column_number" type="number" name="column_number" value="3">            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="posts_number" id="betterdocs-meta-posts_number" class="betterdocs-field betterdocs-meta-number type-number">
                                                <th class="betterdocs-label">
                                                    <label for="posts_number">
                                                    Number of Posts
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" id="posts_number" type="number" name="posts_number" value="10">            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="post_count" id="betterdocs-meta-post_count" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                                <th class="betterdocs-label">
                                                    <label for="post_count">
                                                    Enable Post Count
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" type="checkbox" id="post_count" name="post_count" value="1" checked="&quot;checked&quot;/">            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="count_text" id="betterdocs-meta-count_text" class="betterdocs-field betterdocs-meta-text type-text">
                                                <th class="betterdocs-label">
                                                    <label for="count_text">
                                                    Count Text
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <div class="betterdocs-settings-input-text" bis_skin_checked="1"><input class="betterdocs-settings-field" id="count_text" type="text" name="count_text" placeholder="" value="articles"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="count_text_singular" id="betterdocs-meta-count_text_singular" class="betterdocs-field betterdocs-meta-text type-text">
                                                <th class="betterdocs-label">
                                                    <label for="count_text_singular">
                                                    Count Text Singular
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <div class="betterdocs-settings-input-text" bis_skin_checked="1"><input class="betterdocs-settings-field" id="count_text_singular" type="text" name="count_text_singular" placeholder="" value="article"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="exploremore_btn" id="betterdocs-meta-exploremore_btn" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                                <th class="betterdocs-label">
                                                    <label for="exploremore_btn">
                                                    Enable Explore More Button
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" type="checkbox" id="exploremore_btn" name="exploremore_btn" value="1" checked="&quot;checked&quot;/">            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="exploremore_btn_txt" id="betterdocs-meta-exploremore_btn_txt" class="betterdocs-field betterdocs-meta-text type-text">
                                                <th class="betterdocs-label">
                                                    <label for="exploremore_btn_txt">
                                                    Button Text
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <div class="betterdocs-settings-input-text" bis_skin_checked="1"><input class="betterdocs-settings-field" id="exploremore_btn_txt" type="text" name="exploremore_btn_txt" placeholder="" value="Explore More"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                    <div class="betterdocs-section-inner-tab-content" id="single_doc" style="display: none;" bis_skin_checked="1">
                                        <table>
                                        <tbody>
                                            <tr data-id="doc_single" id="betterdocs-meta-doc_single" class="betterdocs-field betterdocs-meta-title type-title">
                                                <th colspan="2" class="betterdocs-control betterdocs-title">
                                                    <h3>Single Doc</h3>
                                                </th>
                                            </tr>
                                            <tr data-id="enable_toc" id="betterdocs-meta-enable_toc" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                                <th class="betterdocs-label">
                                                    <label for="enable_toc">
                                                    Enable Table of Contents (TOC)
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" type="checkbox" id="enable_toc" name="enable_toc" value="1" checked="&quot;checked&quot;/">            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="toc_title" id="betterdocs-meta-toc_title" class="betterdocs-field betterdocs-meta-text type-text">
                                                <th class="betterdocs-label">
                                                    <label for="toc_title">
                                                    TOC Title
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <div class="betterdocs-settings-input-text" bis_skin_checked="1"><input class="betterdocs-settings-field" id="toc_title" type="text" name="toc_title" placeholder="" value="Table of Contents"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="toc_hierarchy" id="betterdocs-meta-toc_hierarchy" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                                <th class="betterdocs-label">
                                                    <label for="toc_hierarchy">
                                                    TOC Hierarchy
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" type="checkbox" id="toc_hierarchy" name="toc_hierarchy" value="1" checked="&quot;checked&quot;/">            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="toc_list_number" id="betterdocs-meta-toc_list_number" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                                <th class="betterdocs-label">
                                                    <label for="toc_list_number">
                                                    TOC List Number
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" type="checkbox" id="toc_list_number" name="toc_list_number" value="1" checked="&quot;checked&quot;/">            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="enable_sticky_toc" id="betterdocs-meta-enable_sticky_toc" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                                <th class="betterdocs-label">
                                                    <label for="enable_sticky_toc">
                                                    Enable Sticky TOC
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" type="checkbox" id="enable_sticky_toc" name="enable_sticky_toc" value="1" checked="&quot;checked&quot;/">            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="sticky_toc_offset" id="betterdocs-meta-sticky_toc_offset" class="betterdocs-field betterdocs-meta-number type-number">
                                                <th class="betterdocs-label">
                                                    <label for="sticky_toc_offset">
                                                    Content Offset
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" id="sticky_toc_offset" type="number" name="sticky_toc_offset" value="100">                        
                                                    <p class="betterdocs-field-description">content offset from top on scroll.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="collapsible_toc_mobile" id="betterdocs-meta-collapsible_toc_mobile" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                                <th class="betterdocs-label">
                                                    <label for="collapsible_toc_mobile">
                                                    Collapsible TOC on small devices
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" type="checkbox" id="collapsible_toc_mobile" name="collapsible_toc_mobile" value="1">            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="supported_heading_tag" id="betterdocs-meta-supported_heading_tag" class="betterdocs-field betterdocs-meta-multi_checkbox type-multi_checkbox">
                                                <th class="betterdocs-label">
                                                    <label for="supported_heading_tag">
                                                    TOC Supported Heading Tag
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <label><input class="betterdocs-settings-field" type="checkbox" id="supported_heading_tag_1" name="supported_heading_tag[]" value="1" checked="checked">h1</label><br><label><input class="betterdocs-settings-field" type="checkbox" id="supported_heading_tag_2" name="supported_heading_tag[]" value="2" checked="checked">h2</label><br><label><input class="betterdocs-settings-field" type="checkbox" id="supported_heading_tag_3" name="supported_heading_tag[]" value="3" checked="checked">h3</label><br><label><input class="betterdocs-settings-field" type="checkbox" id="supported_heading_tag_4" name="supported_heading_tag[]" value="4" checked="checked">h4</label><br><label><input class="betterdocs-settings-field" type="checkbox" id="supported_heading_tag_5" name="supported_heading_tag[]" value="5" checked="checked">h5</label><br><label><input class="betterdocs-settings-field" type="checkbox" id="supported_heading_tag_6" name="supported_heading_tag[]" value="6" checked="checked">h6</label><br>            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="enable_post_title" id="betterdocs-meta-enable_post_title" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                                <th class="betterdocs-label">
                                                    <label for="enable_post_title">
                                                    Enable Post Title
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" type="checkbox" id="enable_post_title" name="enable_post_title" value="1" checked="&quot;checked&quot;/">            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="title_link_ctc" id="betterdocs-meta-title_link_ctc" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                                <th class="betterdocs-label">
                                                    <label for="title_link_ctc">
                                                    Title Link Copy To Clipboard
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" type="checkbox" id="title_link_ctc" name="title_link_ctc" value="1" checked="&quot;checked&quot;/">            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="enable_breadcrumb" id="betterdocs-meta-enable_breadcrumb" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                                <th class="betterdocs-label">
                                                    <label for="enable_breadcrumb">
                                                    Enable Breadcrumb
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" type="checkbox" id="enable_breadcrumb" name="enable_breadcrumb" value="1" checked="&quot;checked&quot;/">            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="breadcrumb_home_text" id="betterdocs-meta-breadcrumb_home_text" class="betterdocs-field betterdocs-meta-text type-text">
                                                <th class="betterdocs-label">
                                                    <label for="breadcrumb_home_text">
                                                    Breadcrumb Home Text
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <div class="betterdocs-settings-input-text" bis_skin_checked="1"><input class="betterdocs-settings-field" id="breadcrumb_home_text" type="text" name="breadcrumb_home_text" placeholder="" value="Home"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="breadcrumb_home_url" id="betterdocs-meta-breadcrumb_home_url" class="betterdocs-field betterdocs-meta-text type-text">
                                                <th class="betterdocs-label">
                                                    <label for="breadcrumb_home_url">
                                                    Breadcrumb Home URL
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <div class="betterdocs-settings-input-text" bis_skin_checked="1"><input class="betterdocs-settings-field" id="breadcrumb_home_url" type="text" name="breadcrumb_home_url" placeholder="" value="http://wordpress.test"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="enable_breadcrumb_category" id="betterdocs-meta-enable_breadcrumb_category" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                                <th class="betterdocs-label">
                                                    <label for="enable_breadcrumb_category">
                                                    Enable Category on Breadcrumb
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" type="checkbox" id="enable_breadcrumb_category" name="enable_breadcrumb_category" value="1" checked="&quot;checked&quot;/">            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="enable_breadcrumb_title" id="betterdocs-meta-enable_breadcrumb_title" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                                <th class="betterdocs-label">
                                                    <label for="enable_breadcrumb_title">
                                                    Enable Title on Breadcrumb
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" type="checkbox" id="enable_breadcrumb_title" name="enable_breadcrumb_title" value="1" checked="&quot;checked&quot;/">            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="enable_sidebar_cat_list" id="betterdocs-meta-enable_sidebar_cat_list" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                                <th class="betterdocs-label">
                                                    <label for="enable_sidebar_cat_list">
                                                    Enable Sidebar Category List
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" type="checkbox" id="enable_sidebar_cat_list" name="enable_sidebar_cat_list" value="1" checked="&quot;checked&quot;/">            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="enable_print_icon" id="betterdocs-meta-enable_print_icon" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                                <th class="betterdocs-label">
                                                    <label for="enable_print_icon">
                                                    Enable Print Icon
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" type="checkbox" id="enable_print_icon" name="enable_print_icon" value="1" checked="&quot;checked&quot;/">            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="enable_tags" id="betterdocs-meta-enable_tags" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                                <th class="betterdocs-label">
                                                    <label for="enable_tags">
                                                    Enable Tags
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" type="checkbox" id="enable_tags" name="enable_tags" value="1" checked="&quot;checked&quot;/">            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="email_feedback" id="betterdocs-meta-email_feedback" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                                <th class="betterdocs-label">
                                                    <label for="email_feedback">
                                                    Enable Email Feedback
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" type="checkbox" id="email_feedback" name="email_feedback" value="1" checked="&quot;checked&quot;/">            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="feedback_link_text" id="betterdocs-meta-feedback_link_text" class="betterdocs-field betterdocs-meta-text type-text">
                                                <th class="betterdocs-label">
                                                    <label for="feedback_link_text">
                                                    Feedback Link Text
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <div class="betterdocs-settings-input-text" bis_skin_checked="1"><input class="betterdocs-settings-field" id="feedback_link_text" type="text" name="feedback_link_text" placeholder="" value="Still stuck? How can we help?"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="feedback_url" id="betterdocs-meta-feedback_url" class="betterdocs-field betterdocs-meta-text type-text">
                                                <th class="betterdocs-label">
                                                    <label for="feedback_url">
                                                    Feedback URL
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <div class="betterdocs-settings-input-text" bis_skin_checked="1"><input class="betterdocs-settings-field" id="feedback_url" type="text" name="feedback_url" placeholder="" value=""></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="feedback_form_title" id="betterdocs-meta-feedback_form_title" class="betterdocs-field betterdocs-meta-text type-text">
                                                <th class="betterdocs-label">
                                                    <label for="feedback_form_title">
                                                    Feedback Form Title
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <div class="betterdocs-settings-input-text" bis_skin_checked="1"><input class="betterdocs-settings-field" id="feedback_form_title" type="text" name="feedback_form_title" placeholder="" value="How can we help?"></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="email_address" id="betterdocs-meta-email_address" class="betterdocs-field betterdocs-meta-text type-text">
                                                <th class="betterdocs-label">
                                                    <label for="email_address">
                                                    Email Address
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <div class="betterdocs-settings-input-text" bis_skin_checked="1"><input class="betterdocs-settings-field" id="email_address" type="text" name="email_address" placeholder="" value="muhin.cse.diu@gmail.com"></div>
                                                    <p class="betterdocs-field-description">The email address where the Feedback from will be sent</p>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="show_last_update_time" id="betterdocs-meta-show_last_update_time" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                                <th class="betterdocs-label">
                                                    <label for="show_last_update_time">
                                                    Show Last Update Time
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" type="checkbox" id="show_last_update_time" name="show_last_update_time" value="1" checked="&quot;checked&quot;/">            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="enable_navigation" id="betterdocs-meta-enable_navigation" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                                <th class="betterdocs-label">
                                                    <label for="enable_navigation">
                                                    Enable Navigation
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" type="checkbox" id="enable_navigation" name="enable_navigation" value="1" checked="&quot;checked&quot;/">            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="enable_comment" id="betterdocs-meta-enable_comment" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                                <th class="betterdocs-label">
                                                    <label for="enable_comment">
                                                    Enable Comment
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" type="checkbox" id="enable_comment" name="enable_comment" value="1">            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="enable_credit" id="betterdocs-meta-enable_credit" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                                <th class="betterdocs-label">
                                                    <label for="enable_credit">
                                                    Enable Credit
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" type="checkbox" id="enable_credit" name="enable_credit" value="1" checked="&quot;checked&quot;/">            
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                    <div class="betterdocs-section-inner-tab-content" id="archive_page" style="display: none;" bis_skin_checked="1">
                                        <table>
                                        <tbody>
                                            <tr data-id="archive_page_title" id="betterdocs-meta-archive_page_title" class="betterdocs-field betterdocs-meta-title type-title">
                                                <th colspan="2" class="betterdocs-control betterdocs-title">
                                                    <h3>Archive Page</h3>
                                                </th>
                                            </tr>
                                            <tr data-id="enable_archive_sidebar" id="betterdocs-meta-enable_archive_sidebar" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                                <th class="betterdocs-label">
                                                    <label for="enable_archive_sidebar">
                                                    Enable Sidebar Category List
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" type="checkbox" id="enable_archive_sidebar" name="enable_archive_sidebar" value="1" checked="&quot;checked&quot;/">            
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr data-id="archive_nested_subcategory" id="betterdocs-meta-archive_nested_subcategory" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                                <th class="betterdocs-label">
                                                    <label for="archive_nested_subcategory">
                                                    Nested Subcategory
                                                    </label>
                                                </th>
                                                <td class="betterdocs-control">
                                                    <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                                    <input class="betterdocs-settings-field" type="checkbox" id="archive_nested_subcategory" name="archive_nested_subcategory" value="1" checked="&quot;checked&quot;/">            
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <button type="submit" class="btn-settings betterdocs-settings-button betterdocs-submit-layout" data-nonce="11791c6cee" data-key="layout" id="betterdocs-submit-layout">Save Settings</button>
                        </div>
                        <div id="betterdocs-design" class="betterdocs-settings-tab betterdocs-settings-betterdocs_instant_answer" bis_skin_checked="1">
                            <div id="betterdocs-settings-design_settings" class="betterdocs-settings-section betterdocs-design_settings" bis_skin_checked="1">
                            <table>
                                <tbody>
                                    <tr data-id="customizer_link" id="betterdocs-meta-customizer_link" class="betterdocs-field betterdocs-meta-card type-card">
                                        <td class="betterdocs-control betterdocs-card">
                                        <a href="http://wordpress.test/wp-admin/customize.php?autofocus[panel]=betterdocs_customize_options&amp;return=http://wordpress.test/wp-admin/edit.php?post_type=docs&amp;url=http://wordpress.test/docs">
                                            <div class="betterdocs-card-content" bis_skin_checked="1">
                                                <img src="http://wordpress.test/wp-content/plugins/betterdocs/admin//assets/img/betterdocs-customize.svg" alt="betterdocs-documentation">
                                                <p>Design your templates and pages with live customizer.</p>
                                                <p class="betterdocs-customize-button">Customize BetterDocs</p>
                                            </div>
                                        </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                        <div id="betterdocs-shortcodes" class="betterdocs-settings-tab betterdocs-settings-betterdocs_instant_answer" bis_skin_checked="1">
                            <div id="betterdocs-settings-shortcodes_settings" class="betterdocs-settings-section betterdocs-shortcodes_settings" bis_skin_checked="1">
                            <table>
                                <tbody>
                                    <tr data-id="search_form" id="betterdocs-meta-search_form" class="betterdocs-field betterdocs-meta-text type-text">
                                        <th class="betterdocs-label">
                                        <label for="search_form">
                                        Search Form
                                        </label>
                                        </th>
                                        <td class="betterdocs-control">
                                        <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                            <div class="betterdocs-settings-input-text" bis_skin_checked="1"><input readonly="" class="betterdocs-settings-field" id="search_form" type="text" name="search_form" placeholder="" value="[betterdocs_search_form]"><span id="copy-clipboard"><span>Click To Copy!</span></span></div>
                                            <p class="betterdocs-field-help"><strong>You can use:</strong> [betterdocs_search_form placeholder="Search..." heading="Heading" subheading="Subheading" category_search="true" search_button="true" popular_search="true"]</p>
                                        </div>
                                        </td>
                                    </tr>
                                    <tr data-id="feedback_form" id="betterdocs-meta-feedback_form" class="betterdocs-field betterdocs-meta-text type-text">
                                        <th class="betterdocs-label">
                                        <label for="feedback_form">
                                        Feedback Form
                                        </label>
                                        </th>
                                        <td class="betterdocs-control">
                                        <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                            <div class="betterdocs-settings-input-text" bis_skin_checked="1"><input readonly="" class="betterdocs-settings-field" id="feedback_form" type="text" name="feedback_form" placeholder="" value="[betterdocs_feedback_form]"><span id="copy-clipboard"><span>Click To Copy!</span></span></div>
                                            <p class="betterdocs-field-help"><strong>You can use:</strong> [betterdocs_feedback_form button_text="Send"]</p>
                                        </div>
                                        </td>
                                    </tr>
                                    <tr data-id="category_grid" id="betterdocs-meta-category_grid" class="betterdocs-field betterdocs-meta-text type-text">
                                        <th class="betterdocs-label">
                                        <label for="category_grid">
                                        Category Grid- Layout 1
                                        </label>
                                        </th>
                                        <td class="betterdocs-control">
                                        <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                            <div class="betterdocs-settings-input-text" bis_skin_checked="1"><input readonly="" class="betterdocs-settings-field" id="category_grid" type="text" name="category_grid" placeholder="" value="[betterdocs_category_grid]"><span id="copy-clipboard"><span>Click To Copy!</span></span></div>
                                            <p class="betterdocs-field-help"><strong>You can use:</strong> [betterdocs_category_grid post_counter="true" icon="true" masonry="true" column="3" posts_per_grid="5" nested_subcategory="true" terms="term_ID, term_ID" terms_orderby="" terms_order="" multiple_knowledge_base="" disable_customizer_style="" kb_slug="" title_tag="h2" orderby="" order="" ]</p>
                                        </div>
                                        </td>
                                    </tr>
                                    <tr data-id="category_box" id="betterdocs-meta-category_box" class="betterdocs-field betterdocs-meta-text type-text">
                                        <th class="betterdocs-label">
                                        <label for="category_box">
                                        Category Box- Layout 2
                                        </label>
                                        </th>
                                        <td class="betterdocs-control">
                                        <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                            <div class="betterdocs-settings-input-text" bis_skin_checked="1"><input readonly="" class="betterdocs-settings-field" id="category_box" type="text" name="category_box" placeholder="" value="[betterdocs_category_box]"><span id="copy-clipboard"><span>Click To Copy!</span></span></div>
                                            <p class="betterdocs-field-help"><strong>You can use:</strong> [betterdocs_category_box post_type="docs" category="doc_category" orderby="" column="" nested_subcategory="" terms="" terms_orderby="" icon="" kb_slug="" title_tag="h2" multiple_knowledge_base="false" disable_customizer_style="false" border_bottom="false"]</p>
                                        </div>
                                        </td>
                                    </tr>
                                    <tr data-id="category_list" id="betterdocs-meta-category_list" class="betterdocs-field betterdocs-meta-text type-text">
                                        <th class="betterdocs-label">
                                        <label for="category_list">
                                        Category List
                                        </label>
                                        </th>
                                        <td class="betterdocs-control">
                                        <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                            <div class="betterdocs-settings-input-text" bis_skin_checked="1"><input readonly="" class="betterdocs-settings-field" id="category_list" type="text" name="category_list" placeholder="" value="[betterdocs_category_list]"><span id="copy-clipboard"><span>Click To Copy!</span></span></div>
                                            <p class="betterdocs-field-help"><strong>You can use:</strong> [betterdocs_category_list post_type="docs" category="doc_category" orderby="" order="" masonry="" column="" posts_per_page="" nested_subcategory="" terms="" terms_orderby="" terms_order="" kb_slug="" multiple_knowledge_base="false" title_tag="h2"]</p>
                                        </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                        <div id="betterdocs-betterdocs_advanced_settings" class="betterdocs-settings-tab betterdocs-settings-betterdocs_instant_answer" bis_skin_checked="1">
                            <div id="betterdocs-settings-role_management_section" class="betterdocs-settings-section betterdocs-role_management_section" bis_skin_checked="1">
                            <table>
                                <tbody>
                                    <tr data-id="rms_title" id="betterdocs-meta-rms_title" class="betterdocs-field betterdocs-meta-title type-title">
                                        <th colspan="2" class="betterdocs-control betterdocs-title">
                                        <h3>Role Management</h3>
                                        </th>
                                    </tr>
                                    <tr data-id="article_roles" id="betterdocs-meta-article_roles" class="betterdocs-field betterdocs-meta-select type-select">
                                        <th class="betterdocs-label">
                                        <label for="article_roles">
                                        Who Can Write Docs?<sup class="pro-label">Pro</sup>
                                        </label>
                                        </th>
                                        <td class="betterdocs-control">
                                        <div class="betterdocs-control-wrapper betterdocs-opt-alert" bis_skin_checked="1">
                                            <select data-value="administrator" class="betterdocs-settings-field betterdocs-select select2-hidden-accessible" multiple="" name="article_roles[]" id="article_roles" disabled="" data-select2-id="select2-data-article_roles" tabindex="-1" aria-hidden="true">
                                                <option value="administrator" selected="true" data-select2-id="select2-data-12-gzbz">Administrator</option>
                                                <option value="editor">Editor</option>
                                                <option value="author">Author</option>
                                                <option value="contributor">Contributor</option>
                                                <option value="customer">Customer</option>
                                                <option value="shop_manager">Shop manager</option>
                                            </select>
                                            <span class="select2 select2-container select2-container--default select2-container--disabled" dir="ltr" data-select2-id="select2-data-11-24kv" style="width: auto;">
                                                <span class="selection">
                                                    <span class="select2-selection select2-selection--multiple" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-disabled="true">
                                                    <ul class="select2-selection__rendered" id="select2-article_roles-container">
                                                        <li class="select2-selection__choice" title="Administrator" data-select2-id="select2-data-29-q97m"><button type="button" class="select2-selection__choice__remove" tabindex="-1" title="Remove item" aria-label="Remove item" aria-describedby="select2-article_roles-container-choice-iw2g-administrator"><span aria-hidden="true">×</span></button><span class="select2-selection__choice__display" id="select2-article_roles-container-choice-iw2g-administrator">Administrator</span></li>
                                                    </ul>
                                                    <span class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="0" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" autocomplete="off" aria-describedby="select2-article_roles-container" placeholder="" disabled="" style="width: 0.75em;"></span>
                                                    </span>
                                                </span>
                                                <span class="dropdown-wrapper" aria-hidden="true"></span>
                                            </span>
                                        </div>
                                        </td>
                                    </tr>
                                    <tr data-id="settings_roles" id="betterdocs-meta-settings_roles" class="betterdocs-field betterdocs-meta-select type-select">
                                        <th class="betterdocs-label">
                                        <label for="settings_roles">
                                        Who Can Edit Settings?<sup class="pro-label">Pro</sup>
                                        </label>
                                        </th>
                                        <td class="betterdocs-control">
                                        <div class="betterdocs-control-wrapper betterdocs-opt-alert" bis_skin_checked="1">
                                            <select data-value="administrator" class="betterdocs-settings-field betterdocs-select select2-hidden-accessible" multiple="" name="settings_roles[]" id="settings_roles" disabled="" data-select2-id="select2-data-settings_roles" tabindex="-1" aria-hidden="true">
                                                <option value="administrator" selected="true" data-select2-id="select2-data-15-htq1">Administrator</option>
                                                <option value="editor">Editor</option>
                                                <option value="author">Author</option>
                                                <option value="contributor">Contributor</option>
                                                <option value="customer">Customer</option>
                                                <option value="shop_manager">Shop manager</option>
                                            </select>
                                            <span class="select2 select2-container select2-container--default select2-container--disabled" dir="ltr" data-select2-id="select2-data-14-dxwh" style="width: auto;">
                                                <span class="selection">
                                                    <span class="select2-selection select2-selection--multiple" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-disabled="true">
                                                    <ul class="select2-selection__rendered" id="select2-settings_roles-container">
                                                        <li class="select2-selection__choice" title="Administrator" data-select2-id="select2-data-30-liv3"><button type="button" class="select2-selection__choice__remove" tabindex="-1" title="Remove item" aria-label="Remove item" aria-describedby="select2-settings_roles-container-choice-cr9v-administrator"><span aria-hidden="true">×</span></button><span class="select2-selection__choice__display" id="select2-settings_roles-container-choice-cr9v-administrator">Administrator</span></li>
                                                    </ul>
                                                    <span class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="0" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" autocomplete="off" aria-describedby="select2-settings_roles-container" placeholder="" disabled="" style="width: 0.75em;"></span>
                                                    </span>
                                                </span>
                                                <span class="dropdown-wrapper" aria-hidden="true"></span>
                                            </span>
                                        </div>
                                        </td>
                                    </tr>
                                    <tr data-id="analytics_roles" id="betterdocs-meta-analytics_roles" class="betterdocs-field betterdocs-meta-select type-select">
                                        <th class="betterdocs-label">
                                        <label for="analytics_roles">
                                        Who Can Check Analytics?<sup class="pro-label">Pro</sup>
                                        </label>
                                        </th>
                                        <td class="betterdocs-control">
                                        <div class="betterdocs-control-wrapper betterdocs-opt-alert" bis_skin_checked="1">
                                            <select data-value="administrator" class="betterdocs-settings-field betterdocs-select select2-hidden-accessible" multiple="" name="analytics_roles[]" id="analytics_roles" disabled="" data-select2-id="select2-data-analytics_roles" tabindex="-1" aria-hidden="true">
                                                <option value="administrator" selected="true" data-select2-id="select2-data-18-gwoi">Administrator</option>
                                                <option value="editor">Editor</option>
                                                <option value="author">Author</option>
                                                <option value="contributor">Contributor</option>
                                                <option value="customer">Customer</option>
                                                <option value="shop_manager">Shop manager</option>
                                            </select>
                                            <span class="select2 select2-container select2-container--default select2-container--disabled" dir="ltr" data-select2-id="select2-data-17-l94z" style="width: auto;">
                                                <span class="selection">
                                                    <span class="select2-selection select2-selection--multiple" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-disabled="true">
                                                    <ul class="select2-selection__rendered" id="select2-analytics_roles-container">
                                                        <li class="select2-selection__choice" title="Administrator" data-select2-id="select2-data-31-y3uj"><button type="button" class="select2-selection__choice__remove" tabindex="-1" title="Remove item" aria-label="Remove item" aria-describedby="select2-analytics_roles-container-choice-ct17-administrator"><span aria-hidden="true">×</span></button><span class="select2-selection__choice__display" id="select2-analytics_roles-container-choice-ct17-administrator">Administrator</span></li>
                                                    </ul>
                                                    <span class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="0" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" autocomplete="off" aria-describedby="select2-analytics_roles-container" placeholder="" disabled="" style="width: 0.75em;"></span>
                                                    </span>
                                                </span>
                                                <span class="dropdown-wrapper" aria-hidden="true"></span>
                                            </span>
                                        </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                            <div id="betterdocs-settings-internal_kb_section" class="betterdocs-settings-section betterdocs-internal_kb_section" bis_skin_checked="1">
                            <table>
                                <tbody>
                                    <tr data-id="content_restriction_title" id="betterdocs-meta-content_restriction_title" class="betterdocs-field betterdocs-meta-title type-title">
                                        <th colspan="2" class="betterdocs-control betterdocs-title">
                                        <h3>Internal Knowledge Base</h3>
                                        </th>
                                    </tr>
                                    <tr data-id="enable_content_restriction" id="betterdocs-meta-enable_content_restriction" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                        <th class="betterdocs-label">
                                        <label for="enable_content_restriction">
                                        Enable/Disable<sup class="pro-label">Pro</sup>
                                        </label>
                                        </th>
                                        <td class="betterdocs-control">
                                        <div class="betterdocs-control-wrapper betterdocs-opt-alert" bis_skin_checked="1">
                                            <input class="betterdocs-settings-field" type="checkbox" id="enable_content_restriction" name="enable_content_restriction" value="1" disabled="">            
                                        </div>
                                        </td>
                                    </tr>
                                    <tr data-id="content_visibility" id="betterdocs-meta-content_visibility" class="betterdocs-field betterdocs-meta-select type-select" style="display: none;">
                                        <th class="betterdocs-label">
                                        <label for="content_visibility">
                                        Restrict Access to<sup class="pro-label">Pro</sup>
                                        </label>
                                        </th>
                                        <td class="betterdocs-control">
                                        <div class="betterdocs-control-wrapper betterdocs-opt-alert" bis_skin_checked="1">
                                            <select data-value="all" class="betterdocs-settings-field betterdocs-select select2-hidden-accessible" multiple="" name="content_visibility[]" id="content_visibility" disabled="" data-select2-id="select2-data-content_visibility" tabindex="-1" aria-hidden="true">
                                                <option value="all" selected="true" data-select2-id="select2-data-21-9npx">All logged in users</option>
                                                <option value="administrator">Administrator</option>
                                                <option value="editor">Editor</option>
                                                <option value="author">Author</option>
                                                <option value="contributor">Contributor</option>
                                                <option value="subscriber">Subscriber</option>
                                                <option value="customer">Customer</option>
                                                <option value="shop_manager">Shop manager</option>
                                            </select>
                                            <span class="select2 select2-container select2-container--default select2-container--disabled" dir="ltr" data-select2-id="select2-data-20-t8z2" style="width: auto;">
                                                <span class="selection">
                                                    <span class="select2-selection select2-selection--multiple" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-disabled="true">
                                                    <ul class="select2-selection__rendered" id="select2-content_visibility-container">
                                                        <li class="select2-selection__choice" title="All logged in users" data-select2-id="select2-data-32-2ckk"><button type="button" class="select2-selection__choice__remove" tabindex="-1" title="Remove item" aria-label="Remove item" aria-describedby="select2-content_visibility-container-choice-xs2s-all"><span aria-hidden="true">×</span></button><span class="select2-selection__choice__display" id="select2-content_visibility-container-choice-xs2s-all">All logged in users</span></li>
                                                    </ul>
                                                    <span class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="0" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" autocomplete="off" aria-describedby="select2-content_visibility-container" placeholder="" disabled="" style="width: 0.75em;"></span>
                                                    </span>
                                                </span>
                                                <span class="dropdown-wrapper" aria-hidden="true"></span>
                                            </span>
                                            <p class="betterdocs-field-help"><strong>Note:</strong> Only selected User Roles will be able to view your Knowledge Base</p>
                                        </div>
                                        </td>
                                    </tr>
                                    <tr data-id="restrict_template" id="betterdocs-meta-restrict_template" class="betterdocs-field betterdocs-meta-select type-select" style="display: none;">
                                        <th class="betterdocs-label">
                                        <label for="restrict_template">
                                        Restriction on Docs<sup class="pro-label">Pro</sup>
                                        </label>
                                        </th>
                                        <td class="betterdocs-control">
                                        <div class="betterdocs-control-wrapper betterdocs-opt-alert" bis_skin_checked="1">
                                            <select data-value="all" class="betterdocs-settings-field betterdocs-select select2-hidden-accessible" multiple="" name="restrict_template[]" id="restrict_template" disabled="" data-select2-id="select2-data-restrict_template" tabindex="-1" aria-hidden="true">
                                                <option value="all" selected="true" data-select2-id="select2-data-24-xrgo">All Docs Archive</option>
                                                <option value="docs">Docs Page</option>
                                                <option value="doc_category">Docs Categories</option>
                                            </select>
                                            <span class="select2 select2-container select2-container--default select2-container--disabled" dir="ltr" data-select2-id="select2-data-23-gtag" style="width: auto;">
                                                <span class="selection">
                                                    <span class="select2-selection select2-selection--multiple" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-disabled="true">
                                                    <ul class="select2-selection__rendered" id="select2-restrict_template-container">
                                                        <li class="select2-selection__choice" title="All Docs Archive" data-select2-id="select2-data-33-vezy"><button type="button" class="select2-selection__choice__remove" tabindex="-1" title="Remove item" aria-label="Remove item" aria-describedby="select2-restrict_template-container-choice-53uo-all"><span aria-hidden="true">×</span></button><span class="select2-selection__choice__display" id="select2-restrict_template-container-choice-53uo-all">All Docs Archive</span></li>
                                                    </ul>
                                                    <span class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="0" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" autocomplete="off" aria-describedby="select2-restrict_template-container" placeholder="" disabled="" style="width: 0.75em;"></span>
                                                    </span>
                                                </span>
                                                <span class="dropdown-wrapper" aria-hidden="true"></span>
                                            </span>
                                            <p class="betterdocs-field-help"><strong>Note:</strong> Selected Docs pages will be restricted</p>
                                        </div>
                                        </td>
                                    </tr>
                                    <tr data-id="restrict_category" id="betterdocs-meta-restrict_category" class="betterdocs-field betterdocs-meta-select type-select" style="display: none;">
                                        <th class="betterdocs-label">
                                        <label for="restrict_category">
                                        Restriction on Docs Categories<sup class="pro-label">Pro</sup>
                                        </label>
                                        </th>
                                        <td class="betterdocs-control">
                                        <div class="betterdocs-control-wrapper betterdocs-opt-alert" bis_skin_checked="1">
                                            <select data-value="all" class="betterdocs-settings-field betterdocs-select select2-hidden-accessible" multiple="" name="restrict_category[]" id="restrict_category" disabled="" data-select2-id="select2-data-restrict_category" tabindex="-1" aria-hidden="true">
                                                <option value="all" selected="true" data-select2-id="select2-data-27-huyo">All</option>
                                            </select>
                                            <span class="select2 select2-container select2-container--default select2-container--disabled" dir="ltr" data-select2-id="select2-data-26-g4hv" style="width: auto;">
                                                <span class="selection">
                                                    <span class="select2-selection select2-selection--multiple" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1" aria-disabled="true">
                                                    <ul class="select2-selection__rendered" id="select2-restrict_category-container">
                                                        <li class="select2-selection__choice" title="All" data-select2-id="select2-data-34-6l0z"><button type="button" class="select2-selection__choice__remove" tabindex="-1" title="Remove item" aria-label="Remove item" aria-describedby="select2-restrict_category-container-choice-sfl3-all"><span aria-hidden="true">×</span></button><span class="select2-selection__choice__display" id="select2-restrict_category-container-choice-sfl3-all">All</span></li>
                                                    </ul>
                                                    <span class="select2-search select2-search--inline"><input class="select2-search__field" type="search" tabindex="0" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" autocomplete="off" aria-describedby="select2-restrict_category-container" placeholder="" disabled="" style="width: 0.75em;"></span>
                                                    </span>
                                                </span>
                                                <span class="dropdown-wrapper" aria-hidden="true"></span>
                                            </span>
                                            <p class="betterdocs-field-help"><strong>Note:</strong> Selected Docs categories will be restricted </p>
                                        </div>
                                        </td>
                                    </tr>
                                    <tr data-id="restricted_redirect_url" id="betterdocs-meta-restricted_redirect_url" class="betterdocs-field betterdocs-meta-text type-text" style="display: none;">
                                        <th class="betterdocs-label">
                                        <label for="restricted_redirect_url">
                                        Redirect URL<sup class="pro-label">Pro</sup>
                                        </label>
                                        </th>
                                        <td class="betterdocs-control">
                                        <div class="betterdocs-control-wrapper betterdocs-opt-alert" bis_skin_checked="1">
                                            <div class="betterdocs-settings-input-text" bis_skin_checked="1"><input class="betterdocs-settings-field" id="restricted_redirect_url" type="text" name="restricted_redirect_url" placeholder="https://" value=""></div>
                                            <p class="betterdocs-field-help"><strong>Note:</strong> Set a custom URL to redirect users without permissions when they try to access internal knowledge base. By default, restricted content will redirect to the "404 not found" page</p>
                                        </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                            <button type="submit" class="btn-settings betterdocs-settings-button betterdocs-submit-betterdocs_advanced_settings" data-nonce="340cc3ca15" data-key="betterdocs_advanced_settings" id="betterdocs-submit-betterdocs_advanced_settings">Save Settings</button>
                        </div>
                        <div id="betterdocs-betterdocs_instant_answer" class="betterdocs-settings-tab betterdocs-settings-betterdocs_instant_answer" bis_skin_checked="1">
                            <div id="betterdocs-settings-enable_instant_answer" class="betterdocs-settings-section betterdocs-enable_instant_answer" bis_skin_checked="1">
                            <table>
                                <tbody>
                                    <tr data-id="ia_title" id="betterdocs-meta-ia_title" class="betterdocs-field betterdocs-meta-title type-title">
                                        <th colspan="2" class="betterdocs-control betterdocs-title">
                                        <h3>Enable/Disable Instant Answer</h3>
                                        </th>
                                    </tr>
                                    <tr data-id="ia_description" id="betterdocs-meta-ia_description" class="betterdocs-field betterdocs-meta-html type-html">
                                        <td class="betterdocs-control" colspan="2">
                                        <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                            <div class="betterdocs-html-description" bis_skin_checked="1">Display a list of articles or categories in a chat-like widget to give your visitors a chance of self-learning about your website.</div>
                                        </div>
                                        </td>
                                    </tr>
                                    <tr data-id="enable_disable_free" id="betterdocs-meta-enable_disable_free" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                        <th class="betterdocs-label">
                                        <label for="enable_disable_free">
                                        Enable/Disable<sup class="pro-label">Pro</sup>
                                        </label>
                                        </th>
                                        <td class="betterdocs-control">
                                        <div class="betterdocs-control-wrapper betterdocs-opt-alert" bis_skin_checked="1">
                                            <input class="betterdocs-settings-field" type="checkbox" id="enable_disable_free" name="enable_disable_free" value="1" disabled="">            
                                        </div>
                                        </td>
                                    </tr>
                                    <tr data-id="ia_enable_preview_free" id="betterdocs-meta-ia_enable_preview_free" class="betterdocs-field betterdocs-meta-checkbox type-checkbox">
                                        <th class="betterdocs-label">
                                        <label for="ia_enable_preview_free">
                                        Enable IA Live Preview<sup class="pro-label">Pro</sup>
                                        </label>
                                        </th>
                                        <td class="betterdocs-control">
                                        <div class="betterdocs-control-wrapper betterdocs-opt-alert" bis_skin_checked="1">
                                            <input class="betterdocs-settings-field" type="checkbox" id="ia_enable_preview_free" name="ia_enable_preview_free" value="1" disabled="">            
                                        </div>
                                        </td>
                                    </tr>
                                    <tr data-id="ia_image" id="betterdocs-meta-ia_image" class="betterdocs-field betterdocs-meta-image type-image">
                                        <td class="betterdocs-control" colspan="2">
                                        <div class="betterdocs-control-wrapper " bis_skin_checked="1">
                                            <div class="betterdocs-settings-image-field" bis_skin_checked="1"><img src="http://wordpress.test/wp-content/plugins/betterdocs/admin/assets/img/ia-preview.gif" alt=""></div>
                                        </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="betterdocs-settings-right" bis_skin_checked="1">
                    <div class="betterdocs-sidebar" bis_skin_checked="1">
                        <div class="betterdocs-sidebar-block" bis_skin_checked="1">
                            <div class="betterdocs-admin-sidebar-logo" bis_skin_checked="1">
                            <img alt="BetterDocs" src="http://wordpress.test/wp-content/plugins/betterdocs/admin/partials/../assets/img/betterdocs-icon.svg">
                            </div>
                            <div class="betterdocs-admin-sidebar-cta" bis_skin_checked="1">
                            <a rel="nofollow" href="https://betterdocs.co/upgrade" target="_blank">Upgrade to Pro</a>            
                            </div>
                        </div>
                        <div class="betterdocs-sidebar-block betterdocs-license-block" bis_skin_checked="1">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="betterdocs-settings-documentation" bis_skin_checked="1">
                <div class="betterdocs-settings-row" bis_skin_checked="1">
                    <div class="betterdocs-admin-block betterdocs-admin-block-docs" bis_skin_checked="1">
                        <header class="betterdocs-admin-block-header">
                            <div class="betterdocs-admin-block-header-icon" bis_skin_checked="1">
                                <img src="http://wordpress.test/wp-content/plugins/betterdocs/admin//assets/img/icons/icon-documentation.svg" alt="betterdocs-documentation">
                            </div>
                            <h4 class="betterdocs-admin-title">Documentation</h4>
                        </header>
                        <div class="betterdocs-admin-block-content" bis_skin_checked="1">
                            <p>Get started by spending some time with the documentation to get familiar with BetterDocs. Build an awesome Knowledge Base for your customers with ease.</p>
                            <a rel="nofollow" href="https://betterdocs.co/docs/" class="betterdocs-button" target="_blank">Documentation</a>
                        </div>
                    </div>
                    <div class="betterdocs-admin-block betterdocs-admin-block-contribute" bis_skin_checked="1">
                        <header class="betterdocs-admin-block-header">
                            <div class="betterdocs-admin-block-header-icon" bis_skin_checked="1">
                                <img src="http://wordpress.test/wp-content/plugins/betterdocs/admin//assets/img/icons/icon-join-community.svg" alt="betterdocs-contribute">
                            </div>
                            <h4 class="betterdocs-admin-title">Join Our Community</h4>
                        </header>
                        <div class="betterdocs-admin-block-content" bis_skin_checked="1">
                            <p>Join the Facebook community and discuss with fellow developers and users. Best way to connect with people and get feedback on your projects.</p>
                            <a rel="nofollow" href="https://www.facebook.com/groups/wpdeveloper.net/" class="betterdocs-button" target="_blank">Join Now</a>
                        </div>
                    </div>
                    <div class="betterdocs-admin-block betterdocs-admin-block-need-help" bis_skin_checked="1">
                        <header class="betterdocs-admin-block-header">
                            <div class="betterdocs-admin-block-header-icon" bis_skin_checked="1">
                                <img src="http://wordpress.test/wp-content/plugins/betterdocs/admin//assets/img/icons/icon-need-help.svg" alt="betterdocs-help">
                            </div>
                            <h4 class="betterdocs-admin-title">Need Help?</h4>
                        </header>
                        <div class="betterdocs-admin-block-content" bis_skin_checked="1">
                            <p>Stuck with something? Get help from live chat or support ticket.</p>
                            <a rel="nofollow" href="https://wpdeveloper.com/support" class="betterdocs-button" target="_blank">Initiate a Chat</a>
                        </div>
                    </div>
                    <div class="betterdocs-admin-block betterdocs-admin-block-community" bis_skin_checked="1">
                        <header class="betterdocs-admin-block-header">
                            <div class="betterdocs-admin-block-header-icon" bis_skin_checked="1">
                                <img src="http://wordpress.test/wp-content/plugins/betterdocs/admin//assets/img/icons/icon-show-love.svg" alt="betterdocs-commuinity">
                            </div>
                            <h4 class="betterdocs-admin-title">Show Your Love</h4>
                        </header>
                        <div class="betterdocs-admin-block-content" bis_skin_checked="1">
                            <p>We love to have you in BetterDocs family. We are making it more awesome everyday. Take your 2 minutes to review the plugin and spread the love to encourage us to keep it going.</p>
                            <a rel="nofollow" href="https://betterdocs.co/wp/review" class="betterdocs-button" target="_blank">Leave a Review</a>
                        </div>
                    </div>
                </div>
            </div>            

        </div>
    </div>    
</div>    