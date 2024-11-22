<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }


    // This is your option name where all the Redux data is stored.
    $opt_name = "rscard_options";

    // Background Patterns Reader
    $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
    $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
    $sample_patterns      = array();

    if ( is_dir( $sample_patterns_path ) ) {

        if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) {
            $sample_patterns = array();

            while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                    $name              = explode( '.', $sample_patterns_file );
                    $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                    $sample_patterns[] = array(
                        'alt' => $name,
                        'img' => $sample_patterns_url . $sample_patterns_file
                    );
                }
            }
        }
    }

    if( isset( $_GET[ 'access_token' ] ) && $_GET[ 'expires_in' ] ){
    	$rs_card_options = get_option( 'rscard_options' );
	    $rs_card_options[ 'instagram-token' ] = $_GET[ 'access_token' ];
	    $rs_card_options[ 'instagram-user-id' ] = $_GET[ 'user_id' ];
	    $rs_card_options[ 'instagram-expires-in' ] = $_GET[ 'expires_in' ];
	    $rs_card_options[ 'instagram-auth-timestamp' ] = time();

		update_option( 'rscard_options', $rs_card_options );
		header( 'Location: ' . admin_url('admin.php?page=RScardOptions') );
    }

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'rscard' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => esc_html__( 'RScard Options', 'rs-card' ),
        'page_title'           => esc_html__( 'RScard Options', 'rs-card' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => true,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => true,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => 'dashicons-portfolio',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => true,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
        //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => null,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => '',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.

        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

    // Panel Intro text -> before the form
    if ( ! isset( $args['global_variable'] ) || $args['global_variable'] !== false ) {
        if ( ! empty( $args['global_variable'] ) ) {
            $v = $args['global_variable'];
        } else {
            $v = str_replace( '-', '_', $args['opt_name'] );
        }
        $args['intro_text'] = sprintf( esc_html__( '', 'rs-card' ), $v );
    } else {
        $args['intro_text'] = esc_html__( '', 'rs-card' );
    }

    // Add content after the form.
    $args['footer_text'] = esc_html__( '', 'rs-card' );

    Redux::set_args( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */


    /*
     * ---> START HELP TABS
     */

    $tabs = array(
        array(
            'id'      => 'redux-help-tab-1',
            'title'   => esc_html__( 'Theme Information 1', 'rs-card' ),
            'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'rs-card' )
        ),
        array(
            'id'      => 'redux-help-tab-2',
            'title'   => esc_html__( 'Theme Information 2', 'rs-card' ),
            'content' => esc_html__( '<p>This is the tab content, HTML is allowed.</p>', 'rs-card' )
        )
    );
    Redux::set_help_tab( $opt_name, $tabs );

    // Set the help sidebar
    $content = esc_html__( '<p>This is the sidebar content, HTML is allowed.</p>', 'rs-card' );
    Redux::set_help_sidebar( $opt_name, $content );


    /*
     * <--- END HELP TABS
     */


    /*
     *
     * ---> START SECTIONS
     *
     */

    /*

        As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


     */

    // -> START Basic Fields
    Redux::set_section( $opt_name, array(
        'title'            => esc_html__( 'General Settings', 'rs-card' ),
        'id'               => 'basic',
        'desc'             => esc_html__( 'These are general settings for Rs-Card', 'rs-card' ),
        'customizer_width' => '400px',
        'icon'             => 'el el-home'
    ) );

    Redux::set_section( $opt_name, array(
        'title'            => esc_html__( 'Favicon', 'rs-card' ),
        'id'               => 'favicon-opt',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'       => 'favicon',
                'type'     => 'media',
                'preview'  => false,
                'title'    => esc_html__( 'Favicon', 'rs-card' ),
                'desc'     => esc_html__( 'Upload your theme favicon', 'rs-card' ),
                'subtitle' => esc_html__( 'Upload any media using the WordPress native uploader', 'rs-card' ),
            )
        )
    ) );
	Redux::set_section( $opt_name, array(
        'title'            => esc_html__( 'Api Options', 'rs-card' ),
        'id'               => 'api-opt',
        'subsection'       => true,
        'customizer_width' => '450px',
        'fields'           => array(
            array(
                'id'       => 'fontapi-key',
                'type'     => 'text',
                'preview'  => false,
                'title'    => esc_html__( 'Google Font Api Key', 'rs-card' ),
                'desc'     => esc_html__( 'Follow ', 'rs-card' ).' <a target="_blank" href="https://support.google.com/cloud/answer/6158862">the instructions</a>'.esc_html__( ' to get api key', 'rs-card' ),
                'subtitle' => esc_html__( 'Please paste google font api key here', 'rs-card' ),
            ),
			array(
                'id'       => 'mapapi-key',
                'type'     => 'text',
                'preview'  => false,
                'title'    => esc_html__( 'Google Map Api Key', 'rs-card' ),
                'desc'     => esc_html__( 'Follow ', 'rs-card' ).' <a target="_blank" href="https://developers.google.com/maps/documentation/javascript/get-api-key">the instructions</a>'.esc_html__( ' to get api key', 'rs-card' ),
                'subtitle' => esc_html__( 'Please paste google map api key here', 'rs-card' ),
            ),
			array(
                'id'       => 'instagram-token',
                'type'     => 'text',
                'title'    => esc_html__( 'Instagram Access Token', 'rs-card' ),
                'subtitle' => wp_kses_post("<a href='https://api.instagram.com/oauth/authorize?app_id=671104463654705&redirect_uri=https://px-lab.com/instagram-auth.php&response_type=code&scope=user_profile,user_media&state=" . admin_url('admin.php?page=RScardOptions&tab=1'). "'>Generate Access Token and User ID</a>", 'rs-card'),
                'default'  => '',// 1 = on | 0 = off
                'readonly' => true

            ),
            array(
	            'id'       => 'instagram-user-id',
	            'type'     => 'text',
	            'title'    => esc_html__( 'Instagram User ID', 'rs-card' ),
	            'default'  => '',// 1 = on | 0 = off
	            'readonly' => true
            ),
            array(
	            'id'       => 'instagram-expires-in',
	            'type'     => 'text',
	            'title'    => esc_html__( 'Instagram token expiration', 'rs-card' ),
	            'default'  => '',// 1 = on | 0 = off
	            'readonly' => true
            ),
            array(
	            'id'       => 'instagram-auth-timestamp',
	            'type'     => 'text',
	            'title'    => esc_html__( 'Instagram auth timestamp', 'rs-card' ),
	            'default'  => '',// 1 = on | 0 = off
	            'readonly' => true
            ),
			array(
                'id'       => 'twitter-consumer_key',
                'type'     => 'text',
                'title'    => esc_html__( 'Twitter Consumer Key', 'rs-card' ),
                'subtitle' => wp_kses_post("You need to <a target='_blank' href='https://apps.twitter.com/'>create new app</a> to get all of the twitter keys", 'rs-card'),
                'default'  => ''// 1 = on | 0 = off
            ),
			array(
                'id'       => 'twitter-consumer_secret',
                'type'     => 'text',
                'title'    => esc_html__( 'Twitter Consumer Secret', 'rs-card' ),
                'subtitle' => wp_kses_post("You need to <a target='_blank' href='https://apps.twitter.com/'>create new app</a> to get all of the twitter keys", 'rs-card'),
                'default'  => ''// 1 = on | 0 = off
            ),
			array(
                'id'       => 'twitter-access_token',
                'type'     => 'text',
                'title'    => esc_html__( 'Twitter Access Token', 'rs-card' ),
                'subtitle' => wp_kses_post("You need to <a target='_blank' href='https://apps.twitter.com/'>create new app</a> to get all of the twitter keys", 'rs-card'),
                'default'  => ''// 1 = on | 0 = off
            ),
			array(
                'id'       => 'twitter-access_token_secret',
                'type'     => 'text',
                'title'    => esc_html__( 'Twitter Access Token Secret', 'rs-card' ),
                'subtitle' => wp_kses_post("You need to <a target='_blank' href='https://apps.twitter.com/'>create new app</a> to get all of the twitter keys", 'rs-card'),
                'default'  => ''// 1 = on | 0 = off
            ),
        )
    ) );
    Redux::set_section( $opt_name, array(
        'title'            => esc_html__( 'Sidebar Settings', 'rs-card' ),
        'id'               => 'sidebar-settings',
        'subsection'       => true,
        'customizer_width' => '500px',
        'desc'             => esc_html__( 'These are sidebar settings', 'rs-card' ),
        'fields'           => array(
            array(
                'id'       => 'enable-side-menu',
                'type'     => 'checkbox',
                'title'    => esc_html__( 'Enable Side Menu', 'rs-card' ),
                'subtitle' => esc_html__( 'Enable theme right side menu', 'rs-card' ),
                'desc'     => esc_html__( 'Select the checkbox to show right side menu', 'rs-card' ),
                'default'  => '1'// 1 = on | 0 = off
            ),
			array(
                'id'       => 'enable-side-menu-home',
                'type'     => 'checkbox',
                'title'    => esc_html__( 'Enable Sidebar For Home Page', 'rs-card' ),
                'desc'     => esc_html__( 'Select the checkbox to show the sidebar', 'rs-card' ),
                'default'  => '1'// 1 = on | 0 = off
            ),
			array(
                'id'       => 'enable-side-menu-post',
                'type'     => 'checkbox',
                'title'    => esc_html__( 'Enable Sidebar For Posts', 'rs-card' ),
                'subtitle' => esc_html__( "Enable sidebar for post's single page", 'rs-card' ),
                'desc'     => esc_html__( 'Select the checkbox to show the sidebar', 'rs-card' ),
                'default'  => '1'// 1 = on | 0 = off
            ),
			array(
                'id'       => 'search-label',
                'type'     => 'text',
                'title'    => esc_html__( 'Search placeholder', 'rs-card' ),
                'desc'     => esc_html__( 'The placeholder text of serach filed', 'rs-card' ),
                'default'  => 'Search ...'// 1 = on | 0 = off
            ),
			array(
				'id'   => 'author',
				'type' => 'info',
				'title' => esc_html__('Author Block', 'rs-card'),
				'desc' => esc_html__('This block will appear above the sidebar', 'rs-card')
			),
			array(
                'id'       => 'author_image',
                'type'     => 'media',
                'preview'  => false,
                'title'    => esc_html__( 'Author Image', 'rs-card' ),
                'desc'     => esc_html__( 'Upload image for this block', 'rs-card' ),
                'subtitle' => esc_html__( 'Upload any media using the WordPress native uploader', 'rs-card' ),
            ),
			array(
                'id'       => 'author_image_link',
                'type'     => 'text',
                'preview'  => false,
                'title'    => esc_html__( 'Author Image Link', 'rs-card' ),
                'subtitle'     => esc_html__( 'Type link for author image', 'rs-card' ),
                'default'  => ''
            ),
			array(
                'id'       => 'author_image_title',
                'type'     => 'text',
                'preview'  => false,
                'title'    => esc_html__( 'Author Block Title', 'rs-card' ),
                'subtitle'     => esc_html__( 'Type title for author block', 'rs-card' ),
                'default'  => ''
            ),
			array(
                'id'       => 'author_image_subtitle',
                'type'     => 'text',
                'preview'  => false,
                'title'    => esc_html__( 'Author Block Subtitle', 'rs-card' ),
                'subtitle'     => esc_html__( 'Type Subtitle for author block', 'rs-card' ),
                'default'  => ''
            ),
        )
    ) );

    // -> START Editors
    Redux::set_section( $opt_name, array(
        'title'            => esc_html__( 'Header Settings', 'rs-card' ),
        'id'               => 'header-settings',
        'customizer_width' => '500px',
        'icon'             => 'el el-edit',
    ) );

    Redux::set_section( $opt_name, array(
        'title'      => esc_html__( 'Logo Settings', 'rs-card' ),
        'id'         => 'logo-settings',
        'desc'       => esc_html__( 'These are logo settings', 'rs-card' ),
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'logo-image',
                'type'     => 'media',
                'preview'  => false,
                'title'    => esc_html__( 'Logo Image', 'rs-card' ),
                'desc'     => esc_html__( 'Upload your theme logo', 'rs-card' ),
                'subtitle' => esc_html__( 'Upload any media using the WordPress native uploader', 'rs-card' ),
            ),
			array(
                'id'       => 'logo-image-sticky',
                'type'     => 'media',
                'preview'  => false,
                'title'    => esc_html__( 'Logo Image For Sticky Menu', 'rs-card' ),
                'desc'     => esc_html__( 'Upload image for sticky navigation', 'rs-card' ),
                'subtitle' => esc_html__( 'Upload any media using the WordPress native uploader', 'rs-card' ),
            ),
            array(
                'id'       => 'logo-text-first',
                'type'     => 'text',
                'preview'  => false,
                'title'    => esc_html__( 'Logo Text: 1st Part', 'rs-card' ),
                'subtitle'     => esc_html__( 'Insert logo for 1st part', 'rs-card' ),
                'hint'      => array(
                    //'title'     => '',
                    'content' => 'Logo text will not be appeared if logo image is <br/><br/> uploaded.',
                ),
                'default'  => ''
            ),
            array(
                'id'       => 'logo-text-second',
                'type'     => 'text',
                'preview'  => false,
                'title'    => esc_html__( 'Logo Text: 2nd Part', 'rs-card' ),
                'subtitle'     => esc_html__( 'Insert logo for 2nd part', 'rs-card' ),
                'default'  => '',
                'hint'      => array(
                    //'title'     => '',
                    'content' => 'Logo text will not be appeared if logo image is <br/><br/> uploaded.',
                ),
            ),
        ),
    ) );

    Redux::set_section( $opt_name, array(
        'title'      => esc_html__( 'Header Image', 'rs-card' ),
        'id'         => 'header-image',
        //'icon'  => 'el el-home'
        'subsection' => true,
        'desc'       => esc_html__( "These are header's background Settings", 'rs-card' ),
        'fields'     => array(
            array(
                'id'       => 'header-image',
                'type'     => 'media',
                'title'    => esc_html__( 'Header Image', 'rs-card' ),
                'desc'     => esc_html__( 'Upload your header background image', 'rs-card' ),
                'subtitle' => esc_html__( 'Upload any media using the WordPress native uploader', 'rs-card' ),
            ),
			array(
                'id'       => 'header-color',
                'type'     => 'color_rgba',
                'transparent' => false,
                'title'    => esc_html__( 'Background Color For Header Image', 'rs-card' ),
                'subtitle' => esc_html__( 'Pick your own background color for header image or keep this field empty to disable it', 'rs-card' ),
				'default'   => array(
					'color'     => '',
					'alpha'     => 0.8,
					'rgba'		=>'rgba(44, 51, 64, 0.8)'
				),
            ),
        )
    ) );

	Redux::set_section( $opt_name, array(
		'title'      => esc_html__( 'Sticky Options', 'rs-card' ),
		'id'         => 'sticky-options',
		//'icon'  => 'el el-home'
		'subsection' => true,
		'desc'       => esc_html__( "These are header's sticky options", 'rs-card' ),
		'fields'     => array(
			array(
				'id'       => 'sticky',
				'type'     => 'select',
				'title'    => esc_html__( 'Sticky Options', 'rs-card' ),
				'subtitle' => esc_html__( 'Select the sticky option', 'rs-card' ),
				'options'  => array("none" =>"None", "classic" =>"Classic", "smart" =>"Smart"),
				'default'  => 'classic',
			),
		)
	) );


	$rscard_options = get_option('rscard_options');
	if(isset($rscard_options['fontapi-key']) && $rscard_options['fontapi-key']!==''){
		$key = $rscard_options['fontapi-key'];
	}
  else{
		$key = 'AIzaSyDYbz36gPVail4FP08vzsmoHJ4bCv5gWKk';
	}
    $fonts = wp_remote_get('https://www.googleapis.com/webfonts/v1/webfonts?key='.$key);
    $fontsSeraliazed = json_decode( $fonts['body'] );
	$redux_font = array();
	if ( is_object( $fontsSeraliazed ) && ! isset( $fontsSeraliazed->error ) ) {
		$fontArray = $fontsSeraliazed->items;
		if (is_array($fontArray)) {
			foreach($fontArray as $font){
				$redux_font[$font->family] = $font->family;
			}
		}
	}
    Redux::set_section( $opt_name, array(
        'title'      => esc_html__( 'Typography Settings', 'rs-card' ),
        'id'         => 'font-family-settings',
        'desc'       => esc_html__( 'Here you can change the mane font family for your theme', 'rs-card' ),
		'icon'  => 'el el-font',
        'fields'     => array(
            array(
                'id'       => 'body-font-family',
                'type'     => 'select',
                'title'    => esc_html__( 'Body Font Family', 'rs-card' ),
                'subtitle' => esc_html__( 'Select your theme main font-family', 'rs-card' ),
                'desc'     => esc_html__( 'Default font-family is "Open Sans", sans-serif', 'rs-card' ),
                'options'  => $redux_font,
                'default'  => 'Open Sans',
            ),
			array(
                'id'       => 'logo-font-family',
                'type'     => 'select',
                'title'    => esc_html__( 'Logo Font Family', 'rs-card' ),
                'subtitle' => esc_html__( 'Select your theme logo font-family', 'rs-card' ),
                'desc'     => esc_html__( 'Default font-family is "Fredoka One", cursive', 'rs-card' ),
                'options'  => $redux_font,
                'default'  => 'Fredoka One',
            ),
			array(
                'id'       => 'heading-font-family',
                'type'     => 'select',
                'title'    => esc_html__( 'Heading Font Family', 'rs-card' ),
                'subtitle' => esc_html__( 'Select your theme heading font-family', 'rs-card' ),
                'desc'     => esc_html__( 'Default font-family is "Open Sans", sans-serif', 'rs-card' ),
                'options'  => $redux_font,
                'default'  => 'Open Sans',
            ),
        ),
    ) );

    // -> START Design Fields
    Redux::set_section( $opt_name, array(
        'title' => esc_html__( 'Styling Settings', 'rs-card' ),
        'id'    => 'styling-settings',
        'desc'  => esc_html__( '', 'rs-card' ),
        'icon'  => 'el el-brush'
    ) );

    Redux::set_section( $opt_name, array(
        'title'      => esc_html__( 'Theme Color Scheme', 'rs-card' ),
        'desc'       => esc_html__( 'Here you can select the main colors for your theme', 'rs-card' ),
        'id'         => 'color-scheme',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'color-scheme',
                'type'     => 'select',
                'title'    => esc_html__( 'Predefined Color Schemes', 'rs-card' ),
                'subtitle' => esc_html__( 'Select your theme color scheme', 'rs-card' ),
                'options'  => array( 'color-e83b35' => 'Red', 'color-e8676b' => 'Coral', 'color-ec407a' => 'Pink', 'color-8e45ae' => 'Violet', 'color-673bb7' => 'Purple', 'color-3f51b5' => 'Royal-blue', 'color-5d6cc1' => 'Indigo', 'color-1a77d4' => 'Blue', 'color-07aaf5' => 'Cyan', 'color-56c8d2' => 'Turquoise', 'color-27a79a' => 'Teal', 'color-07cb79' => 'Green', 'color-8dc24c' => 'Lime', 'color-ffde03' => 'Yellow','color-fec107' => 'Amber','color-ff9801' => 'Orange','color-d1a3a6' => 'Pale-red','color-ffcfd3' => 'Pale-coral','color-fbbdd4' => 'Pale-pink','color-e2bfe7' => 'Pale-violet','color-c7ccea' => 'Pale-purple','color-83d5fb' => 'Pale-cyan','color-b4e1dc' => 'Pale-teal','color-a7d9a8' => 'Pale-green'),
                'default'  => 'color-e8676b',
            ),
            array(
                'id'       => 'background_info',
                'type'     => 'info',
                'raw_html' => true,
                'desc'     => '<h2><strong>USE CUSTOM COLOR SCHEME.</strong></h2>',
            ),
            array(
                'id'       => 'primary-color',
                'type'     => 'color',
				'transparent' => false,
                'title'    => esc_html__( 'Primary Color', 'rs-card' ),
                'subtitle' => esc_html__( 'Pick your own primary theme color', 'rs-card' ),
            ),

        ),
    ) );

    Redux::set_section( $opt_name, array(
        'title'      => esc_html__( 'Theme Skin Style', 'rs-card' ),
        'desc'       => esc_html__( "Select your theme's skin style", 'rs-card' ),
        'id'         => 'skin-style',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'skin-style',
                'type'     => 'select',
                'title'    => esc_html__( 'Theme Main Skin', 'rs-card' ),
                'subtitle' => esc_html__( 'Select your theme main skin style', 'rs-card' ),
                'options'  => array( 'white-skin' => 'White Skin', 'dark-skin' => 'Dark Skin' ),
                'default'  => 'white-skin',
            ),
        ),
    ) );

    // -> START Media Uploads
    Redux::set_section( $opt_name, array(
        'title' => esc_html__( 'Social Settings', 'rs-card' ),
        'id'    => 'social-settings',
        'desc'  => esc_html__( '', 'rs-card' ),
        'icon'  => 'el el-picture'
    ) );


    Redux::set_section( $opt_name, array(
        'title'      => esc_html__( 'Enable/disable Socials', 'rs-card' ),
        'id'         => 'enable-socials',
        'desc'       => esc_html__( 'Here you can enable or disable socials', 'rs-card' ),
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'display-footer-socials',
                'type'     => 'checkbox',
                'title'    => esc_html__( 'Display Footer Socials', 'rs-card' ),
                'subtitle' => esc_html__( 'Display social icons on the footer of your theme', 'rs-card' ),
                'desc'     => esc_html__( 'Select the checkbox to show social media icons on the footer of the page', 'rs-card' ),
                'default'  => '1'// 1 = on | 0 = off
            ),
			array(
                'id'       => 'display-header-share',
                'type'     => 'checkbox',
                'title'    => esc_html__( 'Display Share Button On Header', 'rs-card' ),
                'subtitle' => esc_html__( 'Display share button on header of your homepage template', 'rs-card' ),
                'desc'     => esc_html__( 'Select the checkbox to show the share button', 'rs-card' ),
                'default'  => '0'// 1 = on | 0 = off
            ),
			array(
                'id'       => 'share-title',
                'type'     => 'text',
                'title'    => esc_html__( 'Title For Share Popup', 'rs-card' ),
                'subtitle' => esc_html__( "This field will appear at share popup", 'rs-card' ),
                'default'  => 'Connect With Us'
            ),
        )
    ) );

    Redux::set_section( $opt_name, array(
        'title'      => esc_html__( 'Social links', 'rs-card' ),
        'id'         => 'social-links',
        'desc'       => esc_html__( 'Here you can insert links for socials', 'rs-card' ),
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'social-1',
                'type'     => 'text',
                'title'    => esc_html__( 'Class', 'rs-card' ),
                'subtitle' => esc_html__( "Place the social icon's class", 'rs-card' ),
                'default'  => 'twitter'
            ),
			array(
                'id'       => 'social-1-link',
                'type'     => 'text',
                'title'    => esc_html__( 'Link', 'rs-card' ),
                'subtitle' => esc_html__( "Place the social icon's link you want", 'rs-card' ),
                'default'  => 'https://www.twitter.com/'
            ),
			array(
                'id'       => 'social-2',
                'type'     => 'text',
                'title'    => esc_html__( 'Class', 'rs-card' ),
                'subtitle' => esc_html__( "Place the social icon's class", 'rs-card' ),
                'default'  => 'facebook'
            ),
            array(
                'id'       => 'social-2-link',
                'type'     => 'text',
                'title'    => esc_html__( 'Link', 'rs-card' ),
                'subtitle' => esc_html__( "Place the social icon's link you want", 'rs-card' ),
                'default'  => 'https://www.facebook.com/'
            ),
			array(
                'id'       => 'social-3',
                'type'     => 'text',
                'title'    => esc_html__( 'Class', 'rs-card' ),
                'subtitle' => esc_html__( "Place the social icon's class", 'rs-card' ),
                'default'  => 'dribbble'
            ),
            array(
                'id'       => 'social-3-link',
                'type'     => 'text',
                'title'    => esc_html__( 'Link', 'rs-card' ),
                'subtitle' => esc_html__( "Place the social icon's link you want", 'rs-card' ),
                'default'  => 'https://dribbble.com/'
            ),
			array(
                'id'       => 'social-4',
                'type'     => 'text',
                'title'    => esc_html__( 'Class', 'rs-card' ),
                'subtitle' => esc_html__( "Place the social icon's class", 'rs-card' ),
                'default'  => 'linkedin'
            ),
            array(
                'id'       => 'social-4-link',
                'type'     => 'text',
                'title'    => esc_html__( 'Link', 'rs-card' ),
                'subtitle' => esc_html__( "Place the social icon's link you want", 'rs-card' ),
                'default'  => 'https://www.linkedin.com/'
            ),
			array(
                'id'       => 'social-5',
                'type'     => 'text',
                'title'    => esc_html__( 'Class', 'rs-card' ),
                'subtitle' => esc_html__( "Place the social icon's class", 'rs-card' ),
                'default'  => 'instagram'
            ),
            array(
                'id'       => 'social-5-link',
                'type'     => 'text',
                'title'    => esc_html__( 'Link', 'rs-card' ),
                'subtitle' => esc_html__( "Place the social icon's link you want", 'rs-card' ),
                'default'  => 'https://instagram.com/'
            ),
			array(
                'id'       => 'social-6',
                'type'     => 'text',
                'title'    => esc_html__( 'Class', 'rs-card' ),
                'subtitle' => esc_html__( "Place the social icon's class", 'rs-card' ),
                'default'  => 'google-plus'
            ),
            array(
                'id'       => 'social-6-link',
                'type'     => 'text',
                'title'    => esc_html__( 'Link', 'rs-card' ),
                'subtitle' => esc_html__( "Place the social icon's link you want", 'rs-card' ),
                'default'  => 'https://plus.google.com/'
            ),
			array(
                'id'       => 'social-7',
                'type'     => 'text',
                'title'    => esc_html__( 'Class', 'rs-card' ),
                'subtitle' => esc_html__( "Place the social icon's class", 'rs-card' ),
                'default'  => ''
            ),
            array(
                'id'       => 'social-7-link',
                'type'     => 'text',
                'title'    => esc_html__( 'Link', 'rs-card' ),
                'subtitle' => esc_html__( "Place the social icon's link you want", 'rs-card' ),
                'default'  => ''
            ),
        )
    ) );

	 // -> START Media Uploads
    Redux::set_section( $opt_name, array(
        'title' => esc_html__( 'Post Settings', 'rs-card' ),
        'id'    => 'post-settings',
        'desc'  => esc_html__( '', 'rs-card' ),
        'icon'  => 'el el-paper-clip',
		'fields'     => array(
            array(
                'id'       => 'disable_next_prev',
                'type'     => 'checkbox',
                'title'    => esc_html__( 'Disable Next/Previous Articles Section', 'rs-card' ),
                'desc'     => esc_html__( 'Select the checkbox to disable the section', 'rs-card' ),
                'default'  => '0'// 1 = on | 0 = off
            ),
        )
    ) );


    /*
     * <--- END SECTIONS
     */


    /*
     *
     * YOU MUST PREFIX THE FUNCTIONS BELOW AND ACTION FUNCTION CALLS OR ANY OTHER CONFIG MAY OVERRIDE YOUR CODE.
     *
     */

    /*
    *
    * --> Action hook examples
    *
    */

    // If Redux is running as a plugin, this will remove the demo notice and links
    add_action( 'redux/loaded', 'remove_demo' );

    // Function to test the compiler hook and demo CSS output.
    // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
    //add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 10, 3);

    // Change the arguments after they've been declared, but before the panel is created
    //add_filter('redux/options/' . $opt_name . '/args', 'change_arguments' );

    // Change the default value of a field after it's been set, but before it's been useds
    //add_filter('redux/options/' . $opt_name . '/defaults', 'change_defaults' );

    // Dynamically add a section. Can be also used to modify sections/fields
    //add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');

    /**
     * This is a test function that will let you see when the compiler hook occurs.
     * It only runs if a field    set with compiler=>true is changed.
     * */
    if ( ! function_exists( 'compiler_action' ) ) {
        function compiler_action( $options, $css, $changed_values ) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r( $changed_values ); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
        }
    }

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ) {
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            //do your validation
            if ( $value == 1 ) {
                $error = true;
                $value = $existing_value;
            } elseif ( $value == 2 ) {
                $warning = true;
                $value   = $existing_value;
            }

            $return['value'] = $value;

            if ( $error == true ) {
                $return['error'] = $field;
                $field['msg']    = 'your custom error message';
            }

            if ( $warning == true ) {
                $return['warning'] = $field;
                $field['msg']      = 'your custom warning message';
            }

            return $return;
        }
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ) {
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    }

    /**
     * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
     * Simply include this function in the child themes functions.php file.
     * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
     * so you must use get_template_directory_uri() if you want to use any of the built in icons
     * */
    if ( ! function_exists( 'dynamic_section' ) ) {
        function dynamic_section( $sections ) {
            //$sections = array();
            $sections[] = array(
                'title'  => esc_html__( 'Section via hook', 'rs-card' ),
                'desc'   => esc_html__( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'rs-card' ),
                'icon'   => 'el el-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }
    }

    /**
     * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
     * */
    if ( ! function_exists( 'change_arguments' ) ) {
        function change_arguments( $args ) {
            //$args['dev_mode'] = true;

            return $args;
        }
    }

    /**
     * Filter hook for filtering the default value of any given field. Very useful in development mode.
     * */
    if ( ! function_exists( 'change_defaults' ) ) {
        function change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }
    }

    /**
     * Removes the demo link and the notice of integrated demo from the redux-framework plugin
     */
    if ( ! function_exists( 'remove_demo' ) ) {
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                remove_filter( 'plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null );

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
            }
        }
    }

