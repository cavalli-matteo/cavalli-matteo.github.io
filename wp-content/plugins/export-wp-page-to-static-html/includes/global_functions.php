<?php

    function rc_static_html_task_events_activate() {
        if (! wp_next_scheduled ( 'wpptsh_daily_schedules' )) {
            wp_schedule_event( time(), 'daily', 'wpptsh_daily_schedules');
        }
    }

    add_action( 'wpptsh_daily_schedules', 'wpptsh_active_cron_job_everyday', 10, 2 );
    function wpptsh_active_cron_job_everyday() {
        $home_url = get_home_url();
        $response = wp_remote_get('http://api.myrecorp.com/wpptsh_notices.php?version=free&url=' . urlencode($home_url));

        // Check for errors in the response
        if (is_wp_error($response)) {
            // Handle the error as needed, for example, log it or set a default value
            error_log('Error retrieving notices: ' . $response->get_error_message());
            return; // Exit if there was an error
        }

        // Get the response body
        $notices = wp_remote_retrieve_body($response);

        // Update the option with the notices
        update_option('wpptsh_notices', $notices);
    }


    function rc_static_html_task_events_deactivate() {
            wp_clear_scheduled_hook( 'wpptsh_daily_schedules' );
        }

    function wpptsh_right_side_notice(){
        $notices = get_option('wpptsh_notices');
        $notices = json_decode($notices);
        $html = "";

        if (!empty($notices)) {
            foreach ($notices as $key => $notice) {
                $title = wp_kses_post($notice->title);
                $key = $notice->key;
                $publishing_date = $notice->publishing_date;
                $auto_hide = $notice->auto_hide;
                $auto_hide_date = $notice->auto_hide_date;
                $is_right_sidebar = $notice->is_right_sidebar;
                $content = wp_kses_post($notice->content);
                $status = $notice->status;
                $version = isset($notice->version) ? $notice->version : array();
                $styles = isset($notice->styles) ? wp_strip_all_tags($notice->styles) : "";

                $current_time = time();
                $publish_time = strtotime($publishing_date);
                $auto_hide_time = strtotime($auto_hide_date);

                if ($status && $is_right_sidebar == 1 && $current_time > $publish_time && $current_time < $auto_hide_time && in_array('free', $version)) {
                    $html .= '<div class="sidebar_notice_section">';
                    $html .= '<div class="right_notice_title">' . $title . '</div>';
                    $html .= '<div class="right_notice_details">' . $content . '</div>';
                    $html .= '</div>';

                    if (!empty($styles)) {
                        $html .= '<style>' . $styles . '</style>';
                    }
                }
            }
        }

        echo $html;
    }

    add_action("wpptsh_right_side_notice", "wpptsh_right_side_notice");

//    function wpptsh_admin_notices(){
//
//
//        $notices = get_option('wpptsh_notices');
//        $notices = json_decode($notices);
//        $html = "";
//
//
//        if (!empty($notices)) {
//            foreach ($notices as $key2 => $notice) {
//                $title = isset($notice->title) ? $notice->title : "";
//                $key = isset($notice->key) ? $notice->key : "";
//                $publishing_date = isset($notice->publishing_date) ? $notice->publishing_date : time();
//                $auto_hide = isset($notice->auto_hide) ? $notice->auto_hide : false;
//                $auto_hide_date = isset($notice->auto_hide_date) ? $notice->auto_hide_date : time();
//                $is_right_sidebar = isset($notice->is_right_sidebar) ? $notice->is_right_sidebar : true;
//                $content = isset($notice->content) ? $notice->content : "";
//                $status = isset($notice->status) ? $notice->status : false;
//                $alert_type = isset($notice->alert_type) ? $notice->alert_type : "success";
//                $version = isset($notice->version) ? $notice->version : array();
//                $styles = isset($notice->styles) ? $notice->styles : "";
//
//                $current_time = time();
//                $publish_time = strtotime($publishing_date);
//                $auto_hide_time = strtotime($auto_hide_date);
//
//                $clicked_data = (array) get_option('wpptsh_notices_clicked_data');
//
//                if ( $status && !$is_right_sidebar && $current_time > $publish_time && $current_time < $auto_hide_time && !in_array($key, $clicked_data) && in_array('free', $version) ) {
//                    $html .=  '<div class="notice notice-'. $alert_type .' is-dismissible dcim-alert wpptsh" wpptsh_notice_key="'.$key.'">
//						'.$content.'
//					</div>';
//
//                    if ( !empty($styles) ) {
//                        $html .= '<style>' . $styles . '</style>';
//                    }
//                }
//            }
//        }
//
//        echo $html;
//
//    }
//    add_action('admin_notices', 'wpptsh_admin_notices');

function wpptsh_admin_notices(){
    $notices = get_option('wpptsh_notices');
    $notices = json_decode($notices);
    $html = "";

    if (!empty($notices)) {
        foreach ($notices as $key2 => $notice) {
            $title = isset($notice->title) ? wp_kses_post($notice->title) : "";
            $key = isset($notice->key) ? esc_attr($notice->key) : "";
            $publishing_date = isset($notice->publishing_date) ? esc_attr($notice->publishing_date) : time();
            $auto_hide = isset($notice->auto_hide) ? (bool)$notice->auto_hide : false;
            $auto_hide_date = isset($notice->auto_hide_date) ? esc_attr($notice->auto_hide_date) : time();
            $is_right_sidebar = isset($notice->is_right_sidebar) ? (bool)$notice->is_right_sidebar : true;
            $content = isset($notice->content) ? wp_kses_post($notice->content) : "";
            $status = isset($notice->status) ? (bool)$notice->status : false;
            $alert_type = isset($notice->alert_type) ? esc_attr($notice->alert_type) : "success";
            $version = isset($notice->version) ? array_map('esc_attr', (array)$notice->version) : array();
            $styles = isset($notice->styles) ? wp_strip_all_tags($notice->styles) : "";

            $current_time = time();
            $publish_time = strtotime($publishing_date);
            $auto_hide_time = strtotime($auto_hide_date);

            $clicked_data = (array) get_option('wpptsh_notices_clicked_data');

            if ($status && !$is_right_sidebar && $current_time > $publish_time && $current_time < $auto_hide_time && !in_array($key, $clicked_data) && in_array('free', $version)) {
                $html .= '<div class="notice notice-' . esc_attr($alert_type) . ' is-dismissible dcim-alert wpptsh" wpptsh_notice_key="' . esc_attr($key) . '">';
                $html .= $content;
                $html .= '</div>';

                if (!empty($styles)) {
                    $html .= '<style>' . $styles . '</style>';
                }
            }
        }
    }

    echo $html;
}
add_action('admin_notices', 'wpptsh_admin_notices');




    add_action('wp_ajax_wpptsh_notice_has_clicked', 'wpptsh_notice_has_clicked');
    add_action('wp_ajax_nopriv_wpptsh_notice_has_clicked', 'wpptsh_notice_has_clicked');

    function wpptsh_notice_has_clicked(){
        //$post = $_POST['post'];
        $wpptsh_notice_key = isset($_POST['wpptsh_notice_key']) ? sanitize_text_field($_POST['wpptsh_notice_key']) : "";
        $nonce = isset($_POST['rc_nonce']) ? sanitize_text_field($_POST['rc_nonce']) : "";

        if(!empty($nonce)){
            if(!wp_verify_nonce( $nonce, "recorp_different_menu" )){
                echo wp_json_encode(array('success' => 'false', 'status' => 'nonce_verify_error', 'response' => ''));

                die();
            }
        }

        set_wpptsh_notices_clicked_data($wpptsh_notice_key);

        $response = "";


        echo wp_json_encode(array('success' => 'true', 'status' => 'success', 'response' => $response));

        die();
    }


    function set_wpptsh_notices_clicked_data($new = ""){

        $gop = get_option('wpptsh_notices_clicked_data');

        if (!empty($gop)) {

            if (!empty($new)) {
                $gop[] = $new;
            }


        } else {
            $gop = array();
            $gop[] = $new;
        }

        update_option('wpptsh_notices_clicked_data', $gop);

        return $gop;
    }

    function rc_wpptsh_notice_dissmiss_scripts(){
        ?>
        <script>
            jQuery(document).on("click", ".wpptsh .notice-dismiss", function(){
                if (jQuery(this).parent().attr('wpptsh_notice_key').length) {
                    var datas = {
                        'action': 'wpptsh_notice_has_clicked',
                        'rc_nonce': '<?php echo wp_create_nonce( "recorp_different_menu" ); ?>',
                        'wpptsh_notice_key': jQuery(this).parent().attr('wpptsh_notice_key'),
                    };

                    jQuery.ajax({
                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                        data: datas,
                        type: 'post',
                        dataType: 'json',

                        beforeSend: function(){

                        },
                        success: function(r){
                            if(r.success == 'true'){
                                console.log(r.response);


                            } else {
                                alert('Something went wrong, please try again!');
                            }

                        }, error: function(){

                        }
                    });
                }
            });
        </script>
        <?php
    }
    add_action("admin_footer", "rc_wpptsh_notice_dissmiss_scripts");




// Hook into admin_init to run our check
add_action('admin_init', 'rc_check_zip_extension');

function rc_check_zip_extension() {
    // Check if Zip extension is enabled
    if (!extension_loaded('zip')) {
        // Zip extension is not installed or enabled
        add_action('admin_notices', 'rc_display_zip_extension_notice');
    }
}

// Function to display admin notice
function rc_display_zip_extension_notice() {
    ?>
    <div class="notice notice-error">
        <p><?php esc_html_e('The Export WP Pages to HTML/CSS plugin requires the Zip extension, which is not installed or enabled on your server. Without the Zip extension, the plugin may not function correctly. Please enable the Zip extension to export zip file of html/css.', 'export-wp-page-to-static-html'); ?></p>
    </div>
    <?php
}


