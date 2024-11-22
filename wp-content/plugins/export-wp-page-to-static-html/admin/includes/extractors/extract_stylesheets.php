<?php

namespace ExportHtmlAdmin\extract_stylesheets;
class extract_stylesheets
{

    private  $admin;

    public function __construct($admin)
    {
        $this->admin = $admin;
    }


    /**
     * @since 2.0.0
     * @param string $url
     * @return array
     */
    public function get_stylesheets($url="")
    {
        // Check if the cancel command is found for the admin and exit if true
        if ($this->admin->is_cancel_command_found()) {
            exit;
        }
        $saveAllAssetsToSpecificDir = $this->admin->getSaveAllAssetsToSpecificDir();
        $src = $this->admin->site_data;
        $path_to_dot = $this->admin->rc_path_to_dot($url, true, true);
        //preg_match_all("/(?<=\<link rel='stylesheet|\<link rel=\"stylesheet).*?(?=\>)/",$src,$matches);
        $cssLinks = $src->find('link');

        if(!empty($cssLinks)){
            foreach ($cssLinks as $key => $link) {
                // Check if the cancel command is found for the admin and exit if true
                if ($this->admin->is_cancel_command_found()) {
                    exit;
                }
                if(isset($link->href) && !empty($link->href) ){
                    $href_link = $link->href;
                    $href_link = \html_entity_decode($href_link, ENT_QUOTES);
                    $href_link = $this->admin->ltrim_and_rtrim($href_link);

                    $href_link = \url_to_absolute($url, $href_link);
                    $host = $this->admin->get_host($href_link);
                    $exclude_url = apply_filters('wp_page_to_html_exclude_urls', false, $href_link);
                    if( !empty($host) && strpos($href_link, '.css')!==false && strpos($url, $host)!==false && !$exclude_url){

                        $newlyCreatedBasename = $this->save_stylesheet($href_link, $url);

                        if(!$saveAllAssetsToSpecificDir){
                            $middle_p = $this->admin->rc_get_url_middle_path_for_assets($href_link);
                            $link->href = $path_to_dot . $middle_p . $newlyCreatedBasename;
                        }
                        else{
                            $link->href = $path_to_dot .'css/'. $newlyCreatedBasename;
                        }

                    }
                }
            }
            $this->admin->site_data = $src;
        }

    }

    /**
     * @since 2.0.0
     * @param string $stylesheet_url
     * @param string $found_on
     * @return false|string
     */
    public function save_stylesheet($stylesheet_url = "", $found_on = "")
    {
        $pathname_fonts = $this->admin->getFontsPath();
        $pathname_css = $this->admin->getCssPath();
        $pathname_images = $this->admin->getImgPath();
        $host = $this->admin->get_host($found_on);
        $saveAllAssetsToSpecificDir = $this->admin->getSaveAllAssetsToSpecificDir();
        $exportTempDir = $this->admin->getExportTempDir();
        $keepSameName = $this->admin->getKeepSameName();

        //$stylesheet_url = url_to_absolute($found_on, $stylesheet_url);
        $m_basename = $this->admin->middle_path_for_filename($stylesheet_url);
        $basename = $this->admin->url_to_basename($stylesheet_url);

        if (!$this->admin->rc_is_link_already_generated($stylesheet_url)
        ) {
            $this->admin->update_export_log($stylesheet_url, 'copying', '');
            $data = $this->admin->get_url_data($stylesheet_url);
            $this->admin->add_urls_log($stylesheet_url, $found_on, 'css');
            preg_match_all("/(?<=url\().*?(?=\))/", $data, $images_links);

            foreach ($images_links as $key => $images) {
                foreach ($images as $image) {
                    // Check if the cancel command is found for the admin and exit if true
                    if ($this->admin->is_cancel_command_found()) {
                        exit;
                    }

                    $image_url = $this->admin->ltrim_and_rtrim($image);
                    if (strpos($image_url, 'data:') == false && strpos($image_url, 'data:image/') == false && strpos($image_url, 'image/svg') == false && strpos($image_url, 'base64') == false) {
                        $image_url = \html_entity_decode($image_url, ENT_QUOTES);
                        $image_url = $this->admin->ltrim_and_rtrim($image_url);
                        $newImageUrl = url_to_absolute($stylesheet_url, $image_url);
                        $this->admin->add_urls_log($image_url, $stylesheet_url, 'cssFile');
                        $item_url = $newImageUrl;
                        $url_basename = $this->admin->url_to_basename($item_url);
                        $url_basename = $this->admin->filter_filename($url_basename);

                        if(!$saveAllAssetsToSpecificDir){
                            $path_to_dot = $this->admin->rc_path_to_dot($item_url);
                        }
                        else{
                            if($saveAllAssetsToSpecificDir && $keepSameName && !empty($m_basename)){
                                $path_to_dot = $this->urlToDot($this->admin->middle_path_for_filename($item_url));
                            }
                            else{
                                $path_to_dot = './../';
                            }

                        }

                        if (strpos($item_url, $host)!==false) {
                            $urlExt = \pathinfo($url_basename, PATHINFO_EXTENSION);

                            //$path_to_dot = $this->admin->rc_path_to_dot($item_url, true, true);
                            $fontExt = array("eot", "woff", "woff2", "ttf", "otf");
                            if (in_array($urlExt, $fontExt)) {
                                if(!file_exists($pathname_fonts)){
                                    //@mkdir($pathname_fonts, 0777, true);
                                    $this->admin->create_middle_directory($pathname_fonts);
                                }
                                $my_file = $pathname_fonts . $url_basename;

                                $data = \str_replace($image, $path_to_dot .'fonts/' . $url_basename, $data);
                            }
                            if (in_array($urlExt, $this->admin->getImageExtensions())) {
                                if(!file_exists($pathname_images)){
                                    //@mkdir($pathname_images, 0777, true);
                                    $this->admin->create_middle_directory($pathname_images);
                                }
                                $my_file = $pathname_images . $url_basename;
                                $data = \str_replace($image, $path_to_dot . 'images/' . $url_basename, $data);

                            }

                            if (strpos($item_url, 'css') !== false) {
                                $my_file = $pathname_css . $url_basename;
                                $data = \str_replace($image, $path_to_dot . 'css/' . $url_basename, $data);
                            }

                            if (isset($my_file) && !file_exists($my_file)) {


                                $this->admin->add_urls_log($item_url, $found_on, 'css');
                                $this->admin->saveFile($item_url, $my_file);
                            }

                            else{
                                $this->admin->update_urls_log($image_url, $url_basename, 'new_file_name', false, $item_url);
                                $this->admin->update_urls_log($image_url, 1);
                            }
                        }
                    }
                }
            }

            if($saveAllAssetsToSpecificDir && $keepSameName && !empty($m_basename)){
                $m_basename = explode('-', $m_basename);
                $m_basename = implode('/', $m_basename);
            }

            if (strpos($basename, ".css") == false) {
                $basename = wp_rand(5000, 9999) . ".css";
                $this->admin->update_urls_log($stylesheet_url, $basename, 'new_file_name');
            }
            $basename = $this->admin->filter_filename($basename);


            if (!empty($m_basename)) {
                $my_file = $pathname_css . $m_basename . $basename;
            } else {
                $my_file = $pathname_css . $basename;
            }

            if(!$saveAllAssetsToSpecificDir){
                $middle_p = $this->admin->rc_get_url_middle_path_for_assets($stylesheet_url);
                if(!file_exists($exportTempDir .'/'. $middle_p)){
                    //@mkdir($exportTempDir .'/'. $middle_p, 0777, true);

                    $this->admin->create_middle_directory($exportTempDir, $middle_p);
                }
                $my_file = $exportTempDir .'/'. $middle_p .'/'. $basename;
            }
            else{
                if($saveAllAssetsToSpecificDir && $keepSameName && !empty($m_basename)){
                    if(!file_exists($exportTempDir .'/'. $m_basename)){
                        //@mkdir($pathname_css . $m_basename, 0777, true);

                        $this->admin->create_middle_directory($pathname_css, $m_basename);
                    }

                    $my_file = $pathname_css . $m_basename . $basename;
                }
            }

            if (!file_exists($my_file)) {

/*                $my_file = esc_html($my_file);
                $handle = @fopen($my_file, 'w') or die('Cannot open file:  ' . $my_file);
                @fwrite($handle, $data);
                fclose($handle);
                $this->admin->update_urls_log($stylesheet_url, 1);*/

                global $wp_filesystem;
                if ( ! function_exists( 'WP_Filesystem' ) ) {
                    require_once ABSPATH . 'wp-admin/includes/file.php';
                }

                WP_Filesystem();

                if ( ! $wp_filesystem->exists( $my_file ) ) {
                    $my_file = esc_html( $my_file );
                    $creds = request_filesystem_credentials( site_url() . '/wp-admin/', '', false, false, array() );

                    // Check if we have credentials, and if not, request them
                    if ( ! WP_Filesystem( $creds ) ) {
                        return; // stop if we don't have credentials
                    }

                    // Write the file
                    if ( ! $wp_filesystem->put_contents( $my_file, $data, FS_CHMOD_FILE ) ) {
                        die( 'Cannot open file: ' . $my_file );
                    }

                    $this->admin->update_urls_log( $stylesheet_url, 1 );
                }

            }

            if ($saveAllAssetsToSpecificDir && !empty($m_basename)){
                return $m_basename . $basename;
            }
            return $basename;
        }

        else{

            if($saveAllAssetsToSpecificDir && $keepSameName && !empty($m_basename)){
                $m_basename = explode('-', $m_basename);
                $m_basename = implode('/', $m_basename);
            }

            if (!(strpos($basename, ".") !== false) && $this->admin->get_newly_created_basename_by_url($stylesheet_url) != false){
                return $m_basename . $this->admin->get_newly_created_basename_by_url($stylesheet_url);
            }

            if ($saveAllAssetsToSpecificDir && !empty($m_basename)){
                return $m_basename . $basename;
            }
            return $basename;
        }

    }

    public function urlToDot($url, $isSpecific=false){
        $slashCount = explode('-', $url);
        $dot = './';
        if ($isSpecific){
            for ($i=1; $i<count($slashCount); $i++){
                $dot .= '../';
            }
        }
        else{
            for ($i=0; $i<count($slashCount); $i++){
                $dot .= '../';
            }
        }

        return $dot;
    }

}
