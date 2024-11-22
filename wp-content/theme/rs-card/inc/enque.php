<?php
/**
 * Register scripts and styles, classes for Rs-Card.
 *
 * @since Rs-Card 1.0
 *
 */

function rscard_font_url() {
    $font_url = '';
    /*
     * Translators: If there are characters in your language that are not supported
     * by Lato, translate this to 'off'. Do not translate into your own language.
     */
    if ( 'off' !== _x( 'on', 'Lato font: on or off', 'rs-card' ) ) {
        $font_url = add_query_arg( 'family', urlencode( 'Lato:300,400,700,900,300italic,400italic,700italic' ), "//fonts.googleapis.com/css" );
    }

    return $font_url;
}

/**
 * Enqueue scripts and styles for the front end.
 *
 * @since Rs-Card 1.0
 */

function add_ie_scripts () {
    echo '<!--[if lt IE 9]>';
    echo '<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>';
    echo '<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>';
    echo '<![endif]-->';
}
add_action('wp_head', 'add_ie_scripts');

function rscard_scripts() {
    // Add google-fonts.
    wp_enqueue_style( 'google-font0', 'https://fonts.googleapis.com/css?family=Fredoka+One', array() );

    $rscard_options = get_option('rscard_options');
    if(isset($rscard_options['body-font-family']) && $rscard_options['body-font-family'] !== ''){
        $font_family = $rscard_options['body-font-family'];
    }else{
        $font_family = "Open Sans";
    }
	if(isset($rscard_options['logo-font-family']) && $rscard_options['logo-font-family'] !== ''){
        $font_family_logo = $rscard_options['logo-font-family'];
    }else{
        $font_family_logo = "Fredoka One";
    }
	
	if(isset($rscard_options['heading-font-family']) && $rscard_options['heading-font-family'] !== ''){
        $font_family_heading = $rscard_options['heading-font-family'];
    }else{
        $font_family_heading = "Open Sans";
    }
    wp_enqueue_style( $font_family, "https://fonts.googleapis.com/css?family=$font_family:300,400,600,700", array() );
	if($font_family_logo != $font_family){
		wp_enqueue_style( $font_family_logo, "https://fonts.googleapis.com/css?family=$font_family_logo:400", array() );
	}
	if($font_family_heading != $font_family && $font_family_heading != $font_family_logo){
		wp_enqueue_style( $font_family_heading, "https://fonts.googleapis.com/css?family=$font_family_heading:400", array() );
	}
	
	if(isset($rscard_options['mapapi-key']) && $rscard_options['mapapi-key'] != ''){
		$key = '?key='.$rscard_options['mapapi-key'];
	}else{
		$key = '';
	}
	
    // Register Styles
    wp_enqueue_style( 'icon-fonts-map', get_template_directory_uri() . '/fonts/map-icons/css/map-icons.min.css', array() );
    wp_enqueue_style( 'icon-fonts', get_template_directory_uri() . '/fonts/icomoon/style.css', array() );

    wp_enqueue_style( 'bxslider', get_template_directory_uri() . '/js/plugins/jquery.bxslider/jquery.bxslider.css');
    wp_enqueue_style( 'custom-scroll', get_template_directory_uri() . '/js/plugins/jquery.customscroll/jquery.mCustomScrollbar.min.css');
    wp_enqueue_style( 'mediaelement-player', get_template_directory_uri() . '/js/plugins/jquery.mediaelement/mediaelementplayer.min.css');
    wp_enqueue_style( 'owl-carousel', get_template_directory_uri() . '/js/plugins/jquery.owlcarousel/owl.carousel.css');
    wp_enqueue_style( 'owl-carousel-theme', get_template_directory_uri() . '/js/plugins/jquery.owlcarousel/owl.theme.css');
    wp_enqueue_style( 'slick', get_template_directory_uri() . '/js/plugins/jquery.slick/slick.css');
    wp_enqueue_style( 'rscard-style', get_stylesheet_uri() );
    wp_enqueue_style( 'theme-color', get_template_directory_uri() . '/colors/theme-color.css');

    // Register Scripts
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'modernizr', get_template_directory_uri().'/js/libs/modernizr.js','','',false );
    wp_enqueue_script( 'maps','https://maps.googleapis.com/maps/api/js'.$key,'','',true );
    wp_enqueue_script( 'map-icons', get_template_directory_uri().'/fonts/map-icons/js/map-icons.min.js','','',true );
    //wp_enqueue_script( 'mousewheel', get_template_directory_uri().'/js/plugins/jquery.mousewheel-3.0.6.pack.js','','',true );
    wp_enqueue_script( 'imagesloaded', get_template_directory_uri().'/js/plugins/imagesloaded.pkgd.min.js','','',true );
    wp_enqueue_script( 'isotope', get_template_directory_uri().'/js/plugins/isotope.pkgd.min.js','','',true );
    wp_enqueue_script( 'appear', get_template_directory_uri().'/js/plugins/jquery.appear.js','','',true );
    wp_enqueue_script( 'onepagenav', get_template_directory_uri().'/js/plugins/jquery.onepagenav.min.js','','',true );
    wp_enqueue_script( 'bxslider', get_template_directory_uri().'/js/plugins/jquery.bxslider/jquery.bxslider.min.js','','',true );
    wp_enqueue_script( 'mCustomScrollbar', get_template_directory_uri().'/js/plugins/jquery.customscroll/jquery.mCustomScrollbar.concat.min.js','','',true );
    wp_enqueue_script( 'mediaelement', get_template_directory_uri().'/js/plugins/jquery.mediaelement/mediaelement-and-player.min.js','','',true );
	wp_enqueue_script( 'owl-carousel', get_template_directory_uri().'/js/plugins/jquery.owlcarousel/owl.carousel.js','','',true );
    wp_enqueue_script( 'slick', get_template_directory_uri().'/js/plugins/jquery.slick/slick.min.js','','',true );
    wp_enqueue_script( 'smartsticky', get_template_directory_uri().'/js/plugins/jquery.smartsticky.js','','',true );
    wp_enqueue_script( 'main', get_template_directory_uri().'/js/site.js',array('jquery'),true );
    wp_localize_script('main', 'ajax_var', array(
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('ajax-nonce')
    ));
				
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }

    if ( is_singular() && wp_attachment_is_image() ) {
        wp_enqueue_script( 'rscard-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20130402' );
    }

    if ( is_active_sidebar( 'sidebar-3' ) ) {
        wp_enqueue_script( 'jquery-masonry' );
    }

	wp_localize_script('main', 'date', array('months' => rs_card_get_month(), 'weeks' => rs_card_get_weeks()));
}
add_action( 'wp_enqueue_scripts', 'rscard_scripts' );

function rs_card_get_month(){
	$months = array();
	for ($m=1; $m<=12; $m++) {
		$months[] = date_i18n('F', mktime(0, 0, 0, $m));	
	}
	return $months;
}

function rs_card_get_weeks(){
	$weeks = array();
	for ($w=2, $i = 1; $i<=7; $i++, $w++) {
		$weeks[] = date_i18n('l',mktime(0, 0, 0, 7, $w, 2000));	
	}
	return $weeks;
}

// Push styles to wp_head
$rscard_options = get_option('rscard_options');
add_action('wp_head','hook_css');
function hook_css(){	
    $rscard_options = get_option('rscard_options');
    if(isset($rscard_options['body-font-family']) && $rscard_options['body-font-family'] !== ''){
        $font_family = '"'. str_replace("+"," ", $rscard_options['body-font-family']).'"';
    }else{
        $font_family =  '"Open Sans", sans-serif';
    }
	if(isset($rscard_options['logo-font-family']) && $rscard_options['logo-font-family'] !== ''){
        $font_family_logo = '"'.str_replace("+"," ", $rscard_options['logo-font-family']).'"';
    }else{
        $font_family_logo =  '"Fredoka One", cursive';
    }
	if(isset($rscard_options['heading-font-family']) && $rscard_options['heading-font-family'] !== ''){
        $font_family_heading = '"'.str_replace("+"," ", $rscard_options['heading-font-family']).'"';
    }else{
        $font_family_heading =  '"Open Sans", sans-serif';
    }
    $output='';
    $output.="<style type='text/css'>";
    $output.="
					body,
					select,
					textarea,
					input[type='tel'],
					input[type='text'],
					input[type='email'],
					input[type='search'],
					input[type='password'],
					.btn,
					.filter button,
					.nav-wrap .nav a,
					.mobile-nav .nav a {
                        font-family: ".$font_family.";
                    }
				";
	$output.="
				.logo,
				.site-title {
                        font-family: ".$font_family_logo.";
                    }
				";
	$output.="
				h1,
				h2,
				h3,
				h4,
				h5,
				h6  {
                        font-family: ".$font_family_heading.";
                    }
				";				
	if((isset($rscard_options['header-color']['rgba'])) and ($rscard_options['header-color']['rgba']!='')){ 
        $output.=".head-bg:before {
						background-color: {$rscard_options['header-color']['rgba']};
					}";
	}else{
		$output.=".head-bg:before {
						background-color: transparent;
					}";
	}
	
    if(($rscard_options['color-scheme'] === '') and ($rscard_options['primary-color']!=='')){
        $color_class = str_ireplace("#","",$rscard_options['primary-color']);
        $output.="
			.theme-color-{$color_class} a,
			.theme-color-{$color_class} blockquote:before,			
			.theme-color-{$color_class} .contact-map .contact-info a:hover,
			.theme-color-{$color_class} .interests-list i,
			.theme-color-{$color_class} .input-field.used label,
			.theme-color-{$color_class} .logo span,
			.theme-color-{$color_class} #map .map-icon,
			.theme-color-{$color_class} .head-cont .btn-mobile,
			.theme-color-{$color_class} .page-404 h2 span,
			.theme-color-{$color_class} .post-box .post-title a:hover,
			.theme-color-{$color_class} .post-single .post-title a:hover,
			.theme-color-{$color_class} .post-pagination .post-title a:hover,
			.theme-color-{$color_class} .post-comments .section-title,
			.theme-color-{$color_class} .ref-box .person-speech:before,			
			.theme-color-{$color_class} .service-icon,
			.theme-color-{$color_class} .statistic-value,
			.theme-color-{$color_class} .service-sub-title,			
			.theme-color-{$color_class} .styled-list li:before,			
			.theme-color-{$color_class} .timeline-box .date,			
			.theme-color-{$color_class} .twitter-icon .rsicon,			
			.theme-color-{$color_class} .tabs-vertical .tabs-menu a:hover,			
			.theme-color-{$color_class} .tabs-vertical .tabs-menu .active a,			
			.theme-color-{$color_class} .widget-title,
			.theme-color-{$color_class} .widget_search label:before,
			.theme-color-{$color_class} .widget_search .search-form:before,
			.theme-color-{$color_class} .widget_meta ul li a:hover,
			.theme-color-{$color_class} .widget_archive ul li a:hover,
			.theme-color-{$color_class} .widget_nav_menu ul li a:hover,
			.theme-color-{$color_class} .widget_categories ul li a:hover,
			.theme-color-{$color_class} .widget_recent_entries ul li a:hover,
			.theme-color-{$color_class} .widget_recent_comments ul li a:hover,
			.theme-color-{$color_class} .widget-popuplar-posts .post-title a:hover,
			.theme-color-{$color_class} .widget-recent-posts .post-title a:hover,
			.theme-color-{$color_class} .head-woo-count {
			  color: #{$color_class}; }
			  
			.theme-color-{$color_class} .head-nav .sub-menu li:hover>a,
			.theme-color-{$color_class} .head-nav .sub-menu li.active,
			.theme-color-{$color_class} .head-lang .lang-list a:hover{
			  color: #{$color_class} !important;
			}
			  			
			.theme-color-{$color_class} mark,
			.theme-color-{$color_class} .btn-primary,
			.theme-color-{$color_class} .btn-primary-outer,
			.theme-color-{$color_class} .btn-sidebar-close,
			.theme-color-{$color_class} .calendar-today .date,
			.theme-color-{$color_class} .calendar-body .busy-day,
			.theme-color-{$color_class} .calendar-body td .current-day,
			.theme-color-{$color_class} .filter .active:after,
			.theme-color-{$color_class} .filter-bar .filter-bar-line,
			.theme-color-{$color_class} .input-field .line:before,
			.theme-color-{$color_class} .input-field .line:after,
			.theme-color-{$color_class} .mobile-nav,
			.theme-color-{$color_class} .head-nav .nav>ul>li>a:after,
			.theme-color-{$color_class} .post-datetime,
			.theme-color-{$color_class} .profile-social,
			.theme-color-{$color_class} .profile-preword span,
			.theme-color-{$color_class} .progress-bar .bar-fill,
			.theme-color-{$color_class} .progress-bar .bar-line:after,
			.theme-color-{$color_class} .price-box.box-primary .btn,
			.theme-color-{$color_class} .price-box.box-primary .price-box-top,
			.theme-color-{$color_class} .profile-list .button,
			
			.theme-color-{$color_class} .pagination span.page-numbers.current,
			.theme-color-{$color_class} .pagination a.page-numbers:active,
			
			.theme-color-{$color_class} .latest-tweets .slick-dots button:hover,
			.theme-color-{$color_class} .latest-tweets .slick-dots .slick-active button,
						
			.theme-color-{$color_class} .tabs-horizontal .tabs-menu a:hover:after,
			.theme-color-{$color_class} .tabs-horizontal .tabs-menu .active a:after,
			.theme-color-{$color_class} .togglebox-header,
			.theme-color-{$color_class} .accordion-header,
			.theme-color-{$color_class} .timeline-bar,
			.theme-color-{$color_class} .timeline-box .dot,
			.theme-color-{$color_class} .timeline-box-compact .date span,
			.theme-color-{$color_class} .widget_tag_cloud a:hover,
			.theme-color-{$color_class} .widget_product_tag_cloud a:hover,
			.theme-color-{$color_class} .wpcf7-form .wpcf7-submit {
			  background-color: #{$color_class}; }
			  
			.theme-color-{$color_class} .mejs-container .mejs-controls .mejs-time-rail .mejs-time-current,
			.theme-color-{$color_class} .mejs-container .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current {
			  background: #{$color_class}; }
			  
			.theme-color-{$color_class} .timeline-box-inner,
			.theme-color-{$color_class} .price-box.box-primary .btn,
			.theme-color-{$color_class} .widget_search .search-form,
			.theme-color-{$color_class} .widget_product_search .search-form,
			.theme-color-{$color_class} .widget_tag_cloud a:hover,
			.theme-color-{$color_class} .widget_product_tag_cloud a:hover,
			.theme-color-{$color_class} .wpcf7-form .wpcf7-form-control:focus {
			  border-color: #{$color_class}; }
			  
			.theme-color-{$color_class} .page-404 h2 span:before,
			.theme-color-{$color_class} .profile-preword span:before,
			.theme-color-{$color_class} .timeline-box-compact .date span:before {
			  border-left-color: #{$color_class}; }
			  
			.theme-color-{$color_class} .price-box.box-primary .price-box-top:before {
			  border-top-color: #{$color_class}; }";
			if ( class_exists( 'woocommerce' ) ) {		
			
				$output.="
				.woocommerce .star-rating,
				.woocommerce .star-rating:before,
				.woocommerce .product-links .button,
				.woocommerce .product-links .button:hover,
				.woocommerce div.product p.price,
				.woocommerce div.product span.price,
				.widget_product_search .woocommerce-product-search:before,
				.woocommerce .product-links a,
				.woocommerce .product-links a.button {
					color: #{$color_class};
				}

				.woocommerce span.onsale,
				.woocommerce #respond input#submit.alt,
				.woocommerce a.button.alt,
				.woocommerce button.button.alt,
				.woocommerce input.button.alt,
				.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover:after,
				.woocommerce div.product .woocommerce-tabs ul.tabs li.active a:after {
					background-color: #{$color_class};
				}

				.woocommerce span.onsale:before {
					border-left-color: #{$color_class};
				}
				
				.widget_product_search .woocommerce-product-search {
					border-color: #{$color_class};
				}";				
			}
    }
    $output.="</style>";

    echo $output;

}

/**
 * Enqueue Google fonts style to admin screen for custom header display.
 *
 * @since Rs-Card 1.0
 */
function rscard_admin_fonts() {
    wp_enqueue_style( 'rscard-lato', rscard_font_url(), array(), null );
}
add_action( 'admin_print_scripts-appearance_page_custom-header', 'rscard_admin_fonts' );

/**
 * Extend the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Presence of header image except in Multisite signup and activate pages.
 * 3. Index views.
 * 4. Full-width content layout.
 * 5. Presence of footer widgets.
 * 6. Single views.
 * 7. Featured content layout.
 *
 * @since Rs-Card 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function rscard_body_classes( $classes ) {
    $rscard_options = get_option('rscard_options');
	
	$hide_header_image = get_field('hide_header_image');
	if(class_exists( 'WooCommerce' )){
		if(!is_woocommerce() && !is_cart() && !is_checkout()){
			if ( ((isset($rscard_options['header-image']) && $rscard_options['header-image']['url'] != '') || get_field('header_image'))  && !is_404() && !isset($hide_header_image[0])) {
				$classes[] = 'header-has-img';
			}
		}
	}else{
		if ( ((isset($rscard_options['header-image']) && !empty($rscard_options['header-image']['url'])) || get_field('header_image'))  && !is_404() && !isset($hide_header_image[0])) {
				$classes[] = 'header-has-img';
			}
	}
	
	if(isset($rscard_options["enable-side-menu"]) && $rscard_options["enable-side-menu"] == 1){
        $classes[] = '';
    }else {
        $classes[] = 'no-sidebar';
    }

    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }

    if ( get_header_image() ) {
        $classes[] = 'header-image';
    } elseif ( ! in_array( $GLOBALS['pagenow'], array( 'wp-activate.php', 'wp-signup.php' ) ) ) {
        $classes[] = 'masthead-fixed';
    }

    if ( is_archive() || is_search() || is_home() ) {
        $classes[] = 'list-view';
    }

    if ( is_singular('post') ) {
        $classes[] = 'page-single';
    }

    if ( is_front_page() ) {
        $classes[] = 'home';
    }

    $classes[] = 'loading';

    return $classes;
}
add_filter( 'body_class', 'rscard_body_classes' );

/**
 * Extend the default WordPress post classes.
 *
 * Adds a post class to denote:
 * Non-password protected page with a post thumbnail.
 *
 * @since Rs-Card 1.0
 *
 * @param array $classes A list of existing post class values.
 * @return array The filtered post class list.
 */
function rscard_post_classes( $classes ) {
    if ( ! post_password_required() && ! is_attachment() && has_post_thumbnail() ) {
        $classes[] = 'has-post-thumbnail';
    }
	
	if ( is_single() ) {
		$classes[] = 'post-content section-box';
	}
	
	if ( !is_single() ) {
		$classes[] = 'post-box';
	}
    
    return $classes;
}
add_filter( 'post_class', 'rscard_post_classes' );