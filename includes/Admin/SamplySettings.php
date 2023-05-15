<?php

namespace Samply\Admin;

class SamplySettings {

    /**
	 * Initialize the class and set its settings options.
	 *
	 * @since    1.0.0
	 * @param    none 
	 */
    public function __construct() {}

    public static function init() {

        add_action( 'woocommerce_product_write_panel_tabs', [ __CLASS__, 'samply_render_tabs' ] );
		add_action( 'woocommerce_product_data_panels', [ __CLASS__, 'samply_tabs_panel' ] );

		// Save custom tab data
		add_action( 'woocommerce_process_product_meta', [ __CLASS__, 'samply_save_tab_data' ], 10, 2 );
        add_action( 'samply_settings_header', array( __CLASS__, 'header_template' ), 10 );
        add_action( 'samply_settings_footer', array( __CLASS__, 'footer_template' ), 10 );

        // Add sample price into variations
        add_action( 'woocommerce_variation_options_pricing', [ __CLASS__, 'sample_price_to_variations' ], 10, 3 );
        add_action( 'woocommerce_save_product_variation', [ __CLASS__, 'save_sample_price_variations' ], 10, 2 );
    }

    /**
     * This function is responsible for settings page header
     *
     * @hooked samply_settings_header
     * @return void
     */
    public static function header_template() {
        ?>
            <div class="samply-settings-header">
                <div class="samply-header-full">
                    <img src="<?php echo SAMPLY_ASSETS ?>/img/samply-logo.svg" alt="Samply">
                    <h2 class="title"><?php _e( 'Samply Settings', 'samply' ); ?></h2>
                </div>
            </div>
        <?php
    }
    
    /**
     * This function is responsible for settings page header
     *
     * @hooked samply_settings_header
     * @return void
     */
    public static function footer_template() {
        ?>
            <div class="samply-settings-documentation">
                <div class="samply-settings-row">
                    <div class="samply-admin-block samply-admin-block-docs">
                        <header class="samply-admin-block-header">
                            <div class="samply-admin-block-header-icon">
                                <svg enable-background="new 0 0 500 500" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="a" gradientUnits="userSpaceOnUse" x1="34.5243" x2="484" y1="249.6" y2="249.6"><stop offset="0" stop-color="#cc99c2"/><stop offset="1" stop-color="#a36597"/></linearGradient><path d="m266.7 500.83c-4.27 0-8.43-1.75-11.42-4.81-4.06-4.16-5.54-10.21-3.85-15.78l23.84-78.48c.76-2.5 2.14-4.81 4-6.66l109.47-109.22c10.52-10.52 24.53-16.31 39.46-16.31s28.95 5.8 39.48 16.33c10.52 10.52 16.32 24.54 16.32 39.47s-5.8 28.95-16.32 39.48l-109.24 109.02c-1.94 1.94-4.37 3.35-7.01 4.08l-80.48 22.29c-1.38.39-2.82.59-4.25.59zm37.93-85.97-14.25 46.9 48.49-13.43 76.99-76.85-33.84-33.84zm123.57-113.41c-6.4 0-12.41 2.49-16.92 7l-6.67 6.66 33.84 33.84 6.68-6.67c9.32-9.33 9.32-24.5-.01-33.83-4.51-4.51-10.52-7-16.92-7zm-317.91 199.38c-41.78 0-75.77-33.99-75.77-75.77v-350.92c0-41.78 33.99-75.77 75.77-75.77h245.13c41.78 0 75.77 33.99 75.77 75.77v122.62c0 8.8-7.16 15.95-15.95 15.95-8.8 0-15.95-7.16-15.95-15.95v-122.62c0-24.19-19.68-43.86-43.86-43.86h-245.14c-24.19 0-43.86 19.68-43.86 43.86v350.92c0 24.19 19.68 43.86 43.86 43.86h66.68c8.8 0 15.95 7.16 15.95 15.95s-7.16 15.95-15.95 15.95h-66.68zm19.83-191.41c-8.8 0-15.95-7.16-15.95-15.95s7.16-15.95 15.95-15.95h124.73c8.8 0 15.95 7.16 15.95 15.95s-7.16 15.95-15.95 15.95zm0-79.76c-8.8 0-15.95-7.16-15.95-15.95s7.16-15.95 15.95-15.95h205.37c8.8 0 15.95 7.16 15.95 15.95s-7.16 15.95-15.95 15.95zm0-79.75c-8.8 0-15.95-7.16-15.95-15.95s7.16-15.95 15.95-15.95h205.37c8.8 0 15.95 7.16 15.95 15.95s-7.16 15.95-15.95 15.95z" fill="url(#a)"/></svg>
                            </div>
                            <h4 class="samply-admin-title"><?php echo __('Documentation', 'samply'); ?> </h4>
                        </header>
                        <div class="samply-admin-block-content">
                            <p><?php echo __('Get started by spending some time with the documentation to get familiar with Samply. Build an awesome Knowledge Base for your customers with ease.', 'samply'); ?></p>
                            <a rel="nofollow" href="https://github.com/beyond88/samply/wiki" class="samply-button" target="_blank"><?php echo __('Documentation', 'samply'); ?></a>
                        </div>
                    </div>
                    <div class="samply-admin-block samply-admin-block-contribute">
                        <header class="samply-admin-block-header">
                            <div class="samply-admin-block-header-icon">
                            <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_60_29)">
                                    <path d="M31.122 21.1258L29.211 20.6708V20.3278C30.457 19.4598 31.269 18.0108 31.269 16.3798V13.8948C31.269 11.2418 29.106 9.07878 26.453 9.07878C25.263 9.07878 24.171 9.51278 23.331 10.2338C22.393 7.93778 20.139 6.3208 17.514 6.3208C14.882 6.3208 12.628 7.94478 11.69 10.2478C10.85 9.51978 9.75099 9.08578 8.55399 9.08578C5.901 9.08578 3.738 11.2488 3.738 13.9018V16.3798C3.738 18.0108 4.557 19.4528 5.796 20.3278V20.6708L3.885 21.1258C1.596 21.6718 0 23.6948 0 26.0398V28.0488C0 28.6438 0.483 29.1268 1.078 29.1268H6.02C6.013 29.2598 6.006 29.3858 6.006 29.5188V33.3898C6.006 33.9848 6.48899 34.4678 7.08399 34.4678H13.552C14.147 34.4678 14.63 33.9848 14.63 33.3898C14.63 32.7948 14.147 32.3118 13.552 32.3118H12.439H10.29H8.16199V29.5188C8.16199 27.4468 9.56899 25.6548 11.592 25.1718L14.546 24.4648L16.52 28.9588C16.695 29.3508 17.08 29.6028 17.507 29.6028C17.934 29.6028 18.319 29.3508 18.494 28.9588L20.468 24.4718L23.408 25.1718C25.424 25.6548 26.838 27.4398 26.838 29.5188V32.3048H21.343C20.748 32.3048 20.265 32.7878 20.265 33.3828C20.265 33.9778 20.748 34.4608 21.343 34.4608H27.916C28.511 34.4608 28.994 33.9778 28.994 33.3828V29.5188C28.994 29.3858 28.987 29.2528 28.98 29.1198H33.936C34.531 29.1198 35.014 28.6368 35.014 28.0418V26.0398C35 23.6948 33.404 21.6718 31.122 21.1258ZM23.786 16.2188C23.786 16.1698 23.793 16.1138 23.793 16.0648V15.1058C23.786 13.7408 23.786 13.6708 24.01 12.8378C24.416 11.8928 25.361 11.2278 26.453 11.2278C27.86 11.2278 29.022 12.3268 29.113 13.7128L29.12 15.8618V16.3728C29.12 17.8428 27.923 19.0328 26.46 19.0328C24.997 19.0328 23.8 17.8358 23.8 16.3728V16.2188H23.786ZM5.887 15.8688L5.894 13.7198C5.985 12.3338 7.13999 11.2348 8.55399 11.2348C9.64599 11.2348 10.591 11.8998 10.997 12.8448C11.214 13.7058 11.214 13.9928 11.214 15.1128V16.3798C11.214 17.8498 10.017 19.0398 8.55399 19.0398C7.08399 19.0398 5.894 17.8428 5.894 16.3798V15.8688H5.887ZM14.084 22.7498C13.811 22.6308 11.627 22.9528 11.627 22.9528L11.081 23.0858C8.96699 23.5898 7.30099 25.0668 6.51 26.9778H2.149V26.0398C2.149 24.6958 3.073 23.5268 4.382 23.2118L7.11899 22.5608C7.60199 22.4418 7.94499 22.0148 7.94499 21.5178V21.1538C8.14099 21.1818 8.34399 21.1958 8.54699 21.1958C8.74999 21.1958 8.95299 21.1818 9.14899 21.1538L9.20499 21.1468C9.95399 21.0278 10.668 20.7478 11.298 20.3278C11.648 20.0828 11.956 19.7958 12.229 19.4738C12.712 20.2158 13.342 20.8458 14.077 21.3288V22.7498H14.084ZM18.753 22.9948L17.493 25.8578L16.233 22.9878V22.2178C16.646 22.3018 17.066 22.3438 17.507 22.3438C17.934 22.3438 18.354 22.3018 18.76 22.2178V22.9948H18.753ZM17.507 20.1948C15.232 20.1948 13.377 18.3398 13.377 16.0648V14.9308V12.7818V12.5998C13.377 10.3248 15.232 8.46978 17.507 8.46978C19.565 8.46978 21.273 9.97478 21.588 11.9418L21.637 14.4688V16.2258C21.553 18.4308 19.733 20.1948 17.507 20.1948ZM32.851 26.9778H28.476C27.685 25.0668 26.019 23.5968 23.898 23.0858L23.359 22.9598C23.359 22.9598 21.189 22.4138 20.909 22.5398V21.3498C21.651 20.8668 22.288 20.2368 22.778 19.4878C23.051 19.8098 23.359 20.0898 23.702 20.3278C24.318 20.7618 25.032 21.0488 25.781 21.1468L25.851 21.1538C26.047 21.1818 26.25 21.1958 26.453 21.1958C26.656 21.1958 26.859 21.1818 27.055 21.1538V21.5178C27.055 22.0148 27.398 22.4488 27.881 22.5608L30.618 23.2188C31.934 23.5338 32.851 24.6958 32.851 26.0468V26.9778Z" fill="url(#paint0_linear_60_29)"/>
                                    <path d="M17.493 4.26991C18.088 4.26991 18.571 3.78691 18.571 3.19191V1.58191C18.571 0.986906 18.088 0.503906 17.493 0.503906C16.898 0.503906 16.415 0.986906 16.415 1.58191V3.19191C16.415 3.78691 16.898 4.26991 17.493 4.26991Z" fill="url(#paint1_linear_60_29)"/>
                                    <path d="M12.0121 5.53668C12.2221 5.74668 12.4951 5.85168 12.7751 5.85168C13.0481 5.85168 13.3281 5.74668 13.5381 5.53668C13.9581 5.11668 13.9581 4.43768 13.5381 4.01768L12.4111 2.89068C11.9911 2.47068 11.3121 2.47068 10.8921 2.89068C10.4721 3.31068 10.4721 3.98968 10.8921 4.40968L12.0121 5.53668Z" fill="url(#paint2_linear_60_29)"/>
                                    <path d="M22.197 5.873C22.47 5.873 22.75 5.768 22.96 5.558L24.08 4.438C24.5 4.018 24.5 3.339 24.08 2.919C23.66 2.499 22.981 2.499 22.561 2.919L21.441 4.039C21.021 4.459 21.021 5.138 21.441 5.558C21.651 5.768 21.924 5.873 22.197 5.873Z" fill="url(#paint3_linear_60_29)"/>
                                </g>
                                <defs>
                                <linearGradient id="paint0_linear_60_29" x1="-6.15982e-05" y1="20.3942" x2="35.0119" y2="20.3942" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#cc99c2"/>
                                    <stop offset="1" stop-color="#a36597"/>
                                </linearGradient>
                                <linearGradient id="paint1_linear_60_29" x1="16.415" y1="2.3869" x2="18.5709" y2="2.3869" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#cc99c2"/>
                                    <stop offset="1" stop-color="#a36597"/>
                                </linearGradient>
                                <linearGradient id="paint2_linear_60_29" x1="10.5771" y1="4.21368" x2="13.853" y2="4.21368" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#cc99c2"/>
                                    <stop offset="1" stop-color="#a36597"/>
                                </linearGradient>
                                <linearGradient id="paint3_linear_60_29" x1="21.126" y1="4.2385" x2="24.3948" y2="4.2385" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#cc99c2"/>
                                    <stop offset="1" stop-color="#a36597"/>
                                </linearGradient>
                                <clipPath id="clip0_60_29">
                                <rect width="35" height="35" fill="white"/>
                                </clipPath>
                                </defs>
                            </svg>

                            </div>
                            <h4 class="samply-admin-title"><?php echo __('Join Our Community', 'samply'); ?></h4>
                        </header>
                        <div class="samply-admin-block-content">
                            <p><?php echo __('Join the Facebook community and discuss with fellow developers and users. Best way to connect with people and get feedback on your projects.', 'samply'); ?></p>
                            <a rel="nofollow" href="https://github.com/beyond88/samply/issues" class="samply-button" target="_blank"><?php echo __('Join Now', 'samply'); ?> </a>
                        </div>
                    </div>
                    <div class="samply-admin-block samply-admin-block-need-help">
                        <header class="samply-admin-block-header">
                            <div class="samply-admin-block-header-icon">
                                <svg enable-background="new 0 0 500 500" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="a" gradientUnits="userSpaceOnUse" x1="22.1892" x2="476.903" y1="250.5491" y2="250.5491"><stop offset="0" stop-color="#cc99c2"/><stop offset="1" stop-color="#a36597"/></linearGradient><path d="m66.5 500.1c-24.43 0-44.31-19.93-44.31-44.42v-61.3c0-42.22 31.52-77.68 73.33-82.47l.48-.05c25.23-2.89 48.29-13.65 66.67-31.12l1.13-1.07-1.08-1.11c-13.44-13.81-23.51-30.8-29.11-49.12l-.33-1.09h-2.75c-36.51 0-66.22-29.71-66.22-66.22v-.19c0-36.26 29.5-65.97 65.75-66.22l1.21-.01.28-1.18c6.13-26.15 21.12-49.89 42.22-66.84 21.4-17.21 48.32-26.69 75.78-26.69s54.37 9.48 75.79 26.69c21.1 16.95 36.09 40.69 42.22 66.84l.28 1.18 1.21.01c36.18.26 65.61 30.01 65.61 66.32 0 36.57-29.65 66.31-66.09 66.31h-2.73l-.33 1.09c-5.66 18.55-15.9 35.71-29.59 49.62l-1.1 1.12 1.14 1.08c18.31 17.27 42.15 28.27 67.11 30.96 42.1 4.55 73.86 40.03 73.86 82.53v60.93c0 24.49-19.88 44.42-44.31 44.42zm132.32-194.8c-25.74 27.48-60.51 44.97-97.89 49.25l-.5.06c-20.1 2.3-35.26 19.39-35.26 39.77v62.73h368.73l.01-62.37c0-20.51-15.26-37.62-35.49-39.8-37.73-4.07-72.85-21.59-98.87-49.33l-.74-.79-.99.43c-15.28 6.66-31.53 10.03-48.28 10.03-17.03 0-33.51-3.48-48.98-10.34l-1-.44zm50.73-261.31c-43.13 0-78.21 35.09-78.21 78.21v71.9c0 43.13 35.09 78.21 78.21 78.21 29.02 0 55.52-15.98 69.16-41.71l1.2-2.25h-68.75c-11.85 0-21.49-9.64-21.49-21.49s9.64-21.49 21.49-21.49h76.61v-63.17c0-.98-.02-1.96-.05-2.93-.06-.68-.09-1.27-.1-1.86-2.56-41.21-36.84-73.42-78.07-73.42zm-123 95.05c-11.16 1.94-19.26 11.57-19.26 22.9v.19c0 11.34 8.1 20.97 19.27 22.9l1.8.31v-46.6zm244.19 46.28 1.8-.32c11.07-1.96 19.11-11.62 19.11-22.97 0-11.36-8.04-21.03-19.11-22.98l-1.8-.32z" fill="url(#a)"/></svg>
                            </div>
                            <h4 class="samply-admin-title"><?php echo __('Need Help?', 'samply'); ?></h4>
                        </header>
                        <div class="samply-admin-block-content">
                            <p><?php echo __('Stuck with something? Get help from live chat or support ticket.', 'samply'); ?></p>
                            <a rel="nofollow" href="https://github.com/beyond88/samply/issues" class="samply-button" target="_blank"><?php echo __('Initiate a Chat', 'samply'); ?></a>
                        </div>
                    </div>
                    <div class="samply-admin-block samply-admin-block-community">
                        <header class="samply-admin-block-header">
                            <div class="samply-admin-block-header-icon">
                                <svg enable-background="new 0 0 500 500" viewBox="0 0 500 500" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><linearGradient id="a" gradientUnits="userSpaceOnUse" x1="-.003528" x2="500" y1="251.0002" y2="251.0002"><stop offset="0" stop-color="#cc99c2"/><stop offset="1" stop-color="#a36597"/></linearGradient><path d="m460.77 80.19c-26.49-27.09-61.93-42.02-99.78-42.02-37.27 0-72.32 14.52-98.68 40.88l-12.05 12.05-12.06-12.05c-26.36-26.36-61.4-40.88-98.66-40.88-37.27 0-72.32 14.52-98.67 40.88-26.36 26.35-40.87 61.39-40.87 98.66s14.51 72.31 40.87 98.67l171.98 171.98c9.98 9.97 23.26 15.47 37.4 15.47 14.15 0 27.43-5.5 37.4-15.47l170.87-170.86c54.42-54.41 55.42-142.93 2.25-197.31zm-321.23-12.67c29.42 0 57.09 11.46 77.9 32.28l12.07 12.07-19.21 19.22c-5.72 5.72-5.72 15.03.01 20.76 2.77 2.77 6.46 4.29 10.37 4.29 3.92 0 7.61-1.53 10.38-4.3l52-52.04c20.81-20.82 48.49-32.28 77.92-32.28 29.89 0 57.87 11.79 78.8 33.18 41.99 42.94 41.09 112.94-2.02 156.04l-170.87 170.87c-4.44 4.44-10.35 6.88-16.64 6.88-6.3 0-12.21-2.44-16.64-6.88l-171.99-171.99c-20.81-20.81-32.27-48.48-32.27-77.91s11.46-57.1 32.27-77.91 48.49-32.28 77.92-32.28z" fill="url(#a)"/></svg>
                            </div>
                            <h4 class="samply-admin-title"><?php echo __('Show Your Love', 'samply'); ?></h4>
                        </header>
                        <div class="samply-admin-block-content">
                            <p><?php echo __('We love to have you in Samply family. We are making it more awesome everyday. Take your 2 minutes to review the plugin and spread the love to encourage us to keep it going.', 'samply'); ?></p>
                            <a rel="nofollow" href="https://wordpress.org/support/plugin/samply/reviews/#new-post" class="samply-button" target="_blank"><?php echo __('Leave a Review', 'samply'); ?></a>
                        </div>
                    </div>
                </div>
            </div> 
        <?php
    }    

    /**
	 * Define setting options as array
	 *
	 * @since    1.0.0
	 * @param    none
     * @return   array 
	 */
    public static function setting_fields() {

        $setting_fields = array(  
                'tabs' => apply_filters( 'samply_builder_tabs', array(
                    'general_settings'    => array(
                        'title'       => __('General', 'samply'),
                        'icon'        => '<svg fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18px" height="18px"><path d="M 9.6679688 2 L 9.1757812 4.5234375 C 8.3550224 4.8338012 7.5961042 5.2674041 6.9296875 5.8144531 L 4.5058594 4.9785156 L 2.1738281 9.0214844 L 4.1132812 10.707031 C 4.0445153 11.128986 4 11.558619 4 12 C 4 12.441381 4.0445153 12.871014 4.1132812 13.292969 L 2.1738281 14.978516 L 4.5058594 19.021484 L 6.9296875 18.185547 C 7.5961042 18.732596 8.3550224 19.166199 9.1757812 19.476562 L 9.6679688 22 L 14.332031 22 L 14.824219 19.476562 C 15.644978 19.166199 16.403896 18.732596 17.070312 18.185547 L 19.494141 19.021484 L 21.826172 14.978516 L 19.886719 13.292969 C 19.955485 12.871014 20 12.441381 20 12 C 20 11.558619 19.955485 11.128986 19.886719 10.707031 L 21.826172 9.0214844 L 19.494141 4.9785156 L 17.070312 5.8144531 C 16.403896 5.2674041 15.644978 4.8338012 14.824219 4.5234375 L 14.332031 2 L 9.6679688 2 z M 12 8 C 14.209 8 16 9.791 16 12 C 16 14.209 14.209 16 12 16 C 9.791 16 8 14.209 8 12 C 8 9.791 9.791 8 12 8 z"/></svg>',
                        'sections'     => apply_filters('samply_general_settings_sections', array(
                            'general_settings' => array(
                                'title'  => __('Settings', 'samply'),
                                'fields' => array(
                                        array(
                                            'name'          => 'samply_enable',
                                            'label'         => __( 'Enable', 'samply' ),
                                            'type'          => 'checkbox',
                                            'class'         => 'samply-settings-field',
                                            'description'   => __( '', 'samply' ),
                                            'placeholder'   => __( '', 'samply' ),
                                        ),                                        
                                        array(
                                            'name'          => 'button_label',
                                            'label'         => __( 'Button Label', 'samply' ),
                                            'type'          => 'text',
                                            'class'         => 'samply-settings-field',
                                            'description'   => __( '<strong>Note:</strong> Set button label', 'samply' ),
                                            'placeholder'   => __( 'Set button label', 'samply' ),
                                        ),
                                        array(
                                            'name'          => 'disable_limit_per_order',
                                            'label'         => __( 'Disable Maximum Limit', 'samply' ),
                                            'type'          => 'checkbox',
                                            'class'         => 'samply-settings-field',
                                            'description'   => __( '<strong>Note:</strong> Disable maximum order limit validation', 'samply' ),
                                        ),            
                                        array(
                                            'name'          => 'limit_per_order',
                                            'label'         => __( 'Maximum Limit Type', 'samply' ),
                                            'type'          => 'select',
                                            'class'         => 'samply-settings-field',
                                            'description'   => __( '<strong>Note:</strong> Maximum limit type', 'samply' ),
                                            'default'       => array(
                                                'product'   => 'Product',
                                                'all'       => 'Order',
                                            ),
                                            'style'			=> 'limit_per_order_area',
                                            'position'		=> 'tr'                
                                        ),            
                                        array(
                                            'name'          => 'max_qty_per_order',
                                            'label'         => __( 'Maximum Quantity Per Order', 'samply' ),
                                            'type'          => 'number',
                                            'class'         => 'samply-settings-field',
                                            'description'   => __( '<strong>Note:</strong> Maximum quantity per order', 'samply' ),
                                            'placeholder'   => 5,
                                            'style'			=> 'max_qty_per_order_area',
                                            'position'		=> 'tr'                
                                        ),
                                        array(
                                            'name'          => 'exclude_shop_page',
                                            'label'         => __( 'Hide in Shop/Categories Page', 'samply' ),
                                            'type'          => 'checkbox',
                                            'class'         => 'samply-settings-field',
                                        ),
                                        array(
                                            'name'          => 'sample_price',
                                            'label'         => __( 'Sample Price', 'samply' ),
                                            'class'         => 'samply-settings-field',
                                            'type'          => 'number',
                                            'description'   => __( 'Set Sample Price', 'samply' ),
                                            'placeholder'   => '0.00',
                                            'value'			=> 0.00,
                                            'position'		=> 'tr'
                                        ),
                                    )                                        
                                ) 
                            )
                        )
                    ),
                    'message_tab'   => array(
                        'title'     => __('Message', 'samply'),
                        'icon'      => '<svg fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="18px" height="18px"><path d="M30.5,5C23.596,5,18,10.596,18,17.5c0,1.149,0.168,2.257,0.458,3.314L5.439,33.833C5.158,34.114,5,34.496,5,34.894V41.5	C5,42.328,5.671,43,6.5,43h7c0.829,0,1.5-0.672,1.5-1.5V39h3.5c0.829,0,1.5-0.672,1.5-1.5V34h3.5c0.829,0,1.5-0.672,1.5-1.5v-3.788	C26.661,29.529,28.524,30,30.5,30C37.404,30,43,24.404,43,17.5S37.404,5,30.5,5z M32,19c-1.657,0-3-1.343-3-3s1.343-3,3-3	s3,1.343,3,3S33.657,19,32,19z"/></svg>',
                        'sections'   => apply_filters('samply_message_tab_sections', array(
                                'message' => array(
                                    'title'  => __('Message', 'samply'),
                                    'fields' => array(
                                        array(
                                            'name'          => 'maximum_qty_message',
                                            'label'         => __( 'Maximum Quantity Message', 'samply' ),
                                            'type'          => 'text',
                                            'class'         => 'samply-settings-field',
                                            'description'   => __( '<strong>Note:</strong> {product} and {qty} for dynamic content.', 'samply' ),
                                            'placeholder'   => __( '', 'samply' ),
                                        ),
                                    )
                                )
                            )
                        ),                    
                    )                       
                )
            )    
        );
		return apply_filters( 'samply_setting_fields', $setting_fields );
    }
    
    /**
	 * Retrieve all categories of the products
	 *
	 * @since    1.0.0
	 * @param    none
     * @return   void
	 */	
	public static function samply_render_tabs() {
        $tabs = "<li class=\"samply_wc_product_tabs_tab\"><a href=\"#samply-tab\"><span>" . __( 'Product Sample', 'samply' ) . "</span></a></li>";
        echo apply_filters( 'samply_render_tabs_list', $tabs );
	}
	
	/**
	 * Load product sample tab
	 *
	 * @since    1.0.0
	 * @param    noneclear
     * @return   void
	 */	
	public static function samply_tabs_panel() {
		global $woocommerce, $post;
        $paths = __DIR__  . '/views/samply-product-tab.php';
		return include_once apply_filters( 'samply_product_tab', $paths );
	}
	
	/**
	 * Save product sample meta
	 *
	 * @since    1.0.0
	 * @param    none
     * @return   void
	 */	
	public static function samply_save_tab_data( $post_id ) {
		
		$samply_manage_stock 	= isset( $_POST['samply_manage_stock'] ) ? 1 : '';
        
		update_post_meta( $post_id, 'samply_manage_stock', $samply_manage_stock );
		update_post_meta( $post_id, 'samply_qty', sanitize_text_field( $_POST['samply_qty'] ) );
        update_post_meta( $post_id, 'samply_price', sanitize_text_field( $_POST['samply_price'] ) );	
		
	}

    /**
	 * Add sample price field in product variations
	 *
	 * @since    1.0.9
	 * @param    string, array, object
     * @return   html
	 */	
	public static function sample_price_to_variations( $loop, $variation_data, $variation ) {
		woocommerce_wp_text_input( array(
			'id' 	=> 'samply_price[' . $loop . ']',
			'class' => 'short',
			'type'	=> 'number',
			'label' => sprintf(__( 'Sample Price (%s)', 'samply' ), get_woocommerce_currency_symbol()),
			'value' => !empty(get_post_meta( $variation->ID, 'samply_price', true ))?get_post_meta( $variation->ID, 'samply_price', true ):0,			
			'custom_attributes' => array(
				'step' 	=> '1',
				'min'	=> '0'
			)			
		) );
	}

    /**
	 * Save sample price field in product variations
	 *
	 * @since    1.0.9
	 * @param    string, array, object
     * @return   void
	 */		
	public static function save_sample_price_variations( $variation_id, $i ) {
		$custom_field = sanitize_text_field($_POST['samply_price'][$i]);
		if ( isset( $custom_field ) ) update_post_meta( $variation_id, 'samply_price', esc_attr( $custom_field ) );
	}

}