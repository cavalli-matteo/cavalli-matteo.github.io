<?php
/**
 * One click importer options
 *
 */
// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
    die( 'No direct script access allowed' );
}

function rscard_after_import_setup($selected_import) {

	//set demos
	$demos = array();
	$demos['Startuper'] = array(
		'homepage' => 'Homepage Startuper',
		'menu' => 'Top menu - startuper',
	);
	$demos['Doctor'] = array(
		'homepage' => 'Homepage Doctor',
		'menu' => 'Top menu - doctor',
	);
	$demos['Singer'] = array(
		'homepage' => 'Homepage Singer',
		'menu' => 'Top menu - singer',
	);
	$demos['Student'] = array(
		'homepage' => 'Homepage Student',
		'menu' => 'Top menu - student',
	);
	$demos['Actor'] = array(
		'homepage' => 'Homepage Actor',
		'menu' => 'Top menu - actor',
	);


	foreach($demos as $key => $demo) {
		if ($key === $selected_import['import_file_name']) {
			//Set Menu
			$main_menu = get_term_by('name', $demo['menu'], 'nav_menu');
			set_theme_mod('nav_menu_locations', array(
					'primary' => $main_menu->term_id,
				)
			);

			//Set Front page
			$page = get_page_by_path($demo['homepage']);
			if (isset($page->ID)) {
				update_option('page_on_front', $page->ID);
				update_option('show_on_front', 'page');
			}
			update_option('rscard_has_demo_data', 1);
		}
	}
}

function rscard_import_files() {

    $rscard_demo_url = 'https://rscard.px-lab.com/demoimporter/';
    $warning_html = '';

    if( get_option( 'rscard_has_demo_data', false ) ) {
        $wp_reset_plugin = sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://srd.wordpress.org/plugins/wp-reset/', esc_html__( 'WP Reset', 'rs-card' ) );
        $wordpress_reset_plugin = sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://srd.wordpress.org/plugins/wordpress-reset/', esc_html__( 'WordPress Reset', 'rs-card' ) );
        $wordpress_database_reset_plugin = sprintf( '<a href="%1$s" target="_blank">%2$s</a>', 'https://hy.wordpress.org/plugins/wordpress-database-reset/', esc_html__( 'WordPress Database Reset', 'rs-card' ) );

        $warning_text = sprintf(
            '<p>%1$s</p><p>%2$s</p><p>%3$s</p>',
            esc_html__( 'If you want your demo to looked exactly like selected demo and to prevent conflicts with current content, we highly recommend importing demo data on a clean installation.', 'rs-card' ),
            esc_html__( 'We highly recommend to create backup of your site before database reset if you are working on your database. Please note that database reset means cleaning all content that you have in your WordPress and restore to WordPress defaults.', 'rs-card' ),
            sprintf( esc_html__( 'Please feel free to use %1$s, %2$s or %3$s plugins to reset your WordPress site.', 'rs-card' ), $wp_reset_plugin, $wordpress_reset_plugin, $wordpress_database_reset_plugin )
        );

        $warning_html = sprintf( '<p>%s</p>', $warning_text );
    }

    return array(
        array(
            'import_file_name'           => 'Startuper',
            'import_file_url'            => $rscard_demo_url.'/startuper/demodata.xml',
            'import_widget_file_url'     => $rscard_demo_url.'/startuper/widgets.wie',
            'import_redux'               => array(
                array(
                    'file_url'    => $rscard_demo_url.'/startuper/reduxsettings.json',
                    'option_name' => 'rscard_options',
                ),
            ),
            'import_preview_image_url'   => $rscard_demo_url.'/startuper/screenshot.jpg',
            'import_notice'              => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'Startuper', 'rs-card' ), $warning_html ),
        ),
        array(
            'import_file_name'           => 'Doctor',
            'import_file_url'            => $rscard_demo_url.'/doctor/demodata.xml',
            'import_widget_file_url'     => $rscard_demo_url.'/doctor/widgets.wie',
            'import_redux'               => array(
                array(
                    'file_url'    => $rscard_demo_url.'/doctor/reduxsettings.json',
                    'option_name' => 'rscard_options',
                ),
            ),
            'import_preview_image_url'   => $rscard_demo_url.'/doctor/screenshot.jpg',
            'import_notice'              => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'Doctor', 'rs-card' ), $warning_html ),
        ),
        array(
            'import_file_name'           => 'Singer',
            'import_file_url'            => $rscard_demo_url.'/singer/demodata.xml',
            'import_widget_file_url'     => $rscard_demo_url.'/singer/widgets.wie',
            'import_redux'               => array(
                array(
                    'file_url'    => $rscard_demo_url.'/singer/reduxsettings.json',
                    'option_name' => 'rscard_options',
                ),
            ),
            'import_preview_image_url'   => $rscard_demo_url.'/singer/screenshot.jpg',
            'import_notice'              => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'Singer', 'rs-card' ), $warning_html ),
        ),
        array(
            'import_file_name'           => 'Student',
            'import_file_url'            => $rscard_demo_url.'/student/demodata.xml',
            'import_widget_file_url'     => $rscard_demo_url.'/student/widgets.wie',
            'import_redux'               => array(
                array(
                    'file_url'    => $rscard_demo_url.'/student/reduxsettings.json',
                    'option_name' => 'rscard_options',
                ),
            ),
            'import_preview_image_url'   => $rscard_demo_url.'/student/screenshot.jpg',
            'import_notice'              => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'Student', 'rs-card' ), $warning_html ),
        ),
	    array(
		    'import_file_name'           => 'Actor',
		    'import_file_url'            => $rscard_demo_url.'/actor/demodata.xml',
		    'import_widget_file_url'     => $rscard_demo_url.'/actor/widgets.wie',
		    'import_redux'               => array(
			    array(
				    'file_url'    => $rscard_demo_url.'/actor/reduxsettings.json',
				    'option_name' => 'rscard_options',
			    ),
		    ),
		    'import_preview_image_url'   => $rscard_demo_url.'/actor/screenshot.jpg',
		    'import_notice'              => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'Actor', 'rs-card' ), $warning_html ),
	    ),
	    array(
		    'import_file_name'           => 'WooCommerce',
		    'import_file_url'            => $rscard_demo_url.'/woocommerce/demodata.xml',
		    'import_preview_image_url'   => $rscard_demo_url.'/woocommerce/screenshot.jpg',
		    'import_notice'              => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'Please make sure that WooCommerce is active before importing dummy data', 'rs-card' ), $warning_html ),
	    ),
    );
}

function rscard_plugin_page_setup( $default_settings ) {
	$default_settings['page_title'] = esc_html__( 'RScard demo importer' , 'rs-card' );
	$default_settings['menu_title'] = esc_html__( 'RScard demo importer' , 'rs-card' );

	return $default_settings;
}

add_filter( 'pt-ocdi/import_files', 'rscard_import_files' );
add_action( 'pt-ocdi/after_import', 'rscard_after_import_setup' );
add_filter( 'pt-ocdi/plugin_page_setup','rscard_plugin_page_setup');

