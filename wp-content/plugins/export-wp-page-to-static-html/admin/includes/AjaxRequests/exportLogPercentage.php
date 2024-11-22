<?php


namespace ExportHtmlAdmin\EWPPTH_AjaxRequests\exportLogPercentage;

class initAjax extends \ExportHtmlAdmin\Export_Wp_Page_To_Static_Html_Admin
{
    private $ajax;
    public function __construct($ajax)
    {
        /*Initialize Ajax export_log_percentage*/
        add_action('wp_ajax_export_log_percentage', array( $this, 'export_log_percentage' ));
        $this->ajax = $ajax;
    }


    /**
     * Ajax action name: export_log_percentage
     * @since    2.0.0
     * @access   public
     * @return json
     */
    public function export_log_percentage(){
        $id = isset($_POST['id']) ? sanitize_key($_POST['id']) : "";

        if(!$this->ajax->nonceCheck()){
            echo wp_json_encode(array('success' => false, 'status' => 'nonce_verify_error', 'response' => ''));

            die();
        }

        global $wpdb;
        $totalExportedUrlLogs = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}export_urls_logs");
// Use prepared statements for safe querying
        $table_name_export_urls_logs = $wpdb->prefix . 'export_urls_logs';
        $table_name_export_page_to_html_logs = $wpdb->prefix . 'export_page_to_html_logs';

// Query for total exported URLs
        $totalExportedUrls = $wpdb->get_var("SELECT COUNT(*) FROM $table_name_export_urls_logs WHERE exported = 1");

// Query for total logs
        $totalLogs = $wpdb->get_var("SELECT COUNT(*) FROM $table_name_export_page_to_html_logs");

        $response = '';
        $cancel_command = $this->getSettings('cancel_command', false);
        $logs_in_details = $this->getSettings('logs_in_details', false);
        $exportStatus = $this->getSettings('task', '');
        $creatingHtmlProcess = $this->getSettings('creating_html_process', '');
        $creatingZipStatus = $this->getSettings('creating_zip_process', '');
        $total_zip_files = $this->getSettings('total_zip_files', 0);
        // Prepare the query to prevent SQL injection.
        $query = $wpdb->prepare(
            "SELECT COUNT(*) FROM {$wpdb->prefix}export_page_to_html_logs WHERE type = %s",
            'added_into_zip_file'
        );

// Execute the query.
        $total_pushed_file_to_zip = $wpdb->get_var($query);

        $zipDownloadLink = $this->getSettings('zipDownloadLink');
        $ftp_upload_enabled = $this->getSettings('ftp_upload_enabled');
        $ftp_status = $this->getSettings('ftp_status');
        $lastUpdateTotalLogs = $this->getSettings('lastLogs');
        $lastLogsTime = (int) $this->getSettings('lastLogsTime');

        $logs = array();
        $table_name = $wpdb->prefix . 'export_page_to_html_logs';

        if($logs_in_details == 1){
            if ($id == 0 || $id == '0') {
                $query = "SELECT * FROM {$table_name} ORDER BY id ASC";
            } else {
                $query = $wpdb->prepare("SELECT * FROM {$table_name} ORDER BY id ASC LIMIT 5000 OFFSET %d", intval($id));
            }
            $logs = $wpdb->get_results($query);
        }

        $createdLastHtmlFile = "";
        if ($creatingHtmlProcess == "completed") {
            $tempUrl = wp_upload_dir()['baseurl'] . '/exported_html_files/tmp_files';

            $query = $wpdb->prepare(
                "SELECT comment FROM {$wpdb->prefix}export_page_to_html_logs WHERE type = %s ORDER BY ID ASC LIMIT 1",
                'created_html_file'
            );
            $created_html_file = $wpdb->get_results($query);

            $createdLastHtmlFile = isset($created_html_file[0]) ? $created_html_file[0]->comment : '';
            if (!empty($createdLastHtmlFile)) {
                $createdLastHtmlFile = $tempUrl . '/' . $createdLastHtmlFile;
            }
        }

        $total_file_uploaded = 0;
        if ($ftp_upload_enabled == "yes") {
            $query = $wpdb->prepare(
                "SELECT COUNT(*) FROM {$wpdb->prefix}export_page_to_html_logs WHERE type = %s",
                'file_uploaded_to_ftp'
            );
            $total_file_uploaded = $wpdb->get_var($query);
        }

        $error = false;

        if(!empty($lastUpdateTotalLogs)&&!empty($lastLogsTime)){
            if ($lastUpdateTotalLogs==$totalLogs){
                if( ((time()-$lastLogsTime)/60) >= 5 ){
                    $error = true;
                    $this->setSettings('timestampError', true);
                }
            }else{
                $this->setSettings('lastLogsTime', time());
            }
        }
        else{
            $this->setSettings('lastLogsTime', time());
        }
        $this->setSettings('lastLogs', $totalLogs);



        $arrays = array(
            'success' => true,
            'status' => 'success',
            'response' => $response,
            'cancel_command' => $cancel_command,
            'total_urls_log' => $totalExportedUrlLogs,
            'total_url_exported' => $totalExportedUrls,
            'export_status' => $exportStatus,
            'creating_html_process' => $creatingHtmlProcess,
            'creating_zip_status'=> $creatingZipStatus,
            'total_pushed_file_to_zip'=> $total_pushed_file_to_zip,
            'total_zip_files'=> $total_zip_files,
            'logs_in_details'=> $logs_in_details,
            'total_logs' => $totalLogs,
            'logs' => $logs,
            'zipDownloadLink' => $zipDownloadLink,
            'ftp_upload_enabled' => $ftp_upload_enabled,
            'ftp_status' => $ftp_status,
            'total_file_uploaded' => $total_file_uploaded,
            'createdLastHtmlFile' => $createdLastHtmlFile,
            'error' => $error,
        );
        echo wp_json_encode($arrays);

        die();
    }


}