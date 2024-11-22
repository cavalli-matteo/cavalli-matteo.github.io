<?php
/**
 * Rs-Card functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Rs-Card
 * @since Rs-Card 1.0
 */

/*remove revisions from pages*/
add_action( 'admin_init', 'disable_revisions' );
function disable_revisions() {
	remove_post_type_support( 'page', 'revisions' );
}

/*
 * Add Woocommerce Support
 */

add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
	add_theme_support( 'woocommerce' );
}

// Remove Woocommerce Styles
add_filter( 'woocommerce_enqueue_styles', 'jk_dequeue_styles' );
function jk_dequeue_styles( $enqueue_styles ) {
	unset( $enqueue_styles['woocommerce-layout'] ); // Remove the layout
	unset( $enqueue_styles['woocommerce-smallscreen'] ); // Remove the smallscreen optimisation
	unset( $enqueue_styles['woocommerce-general'] ); // Remove the gloss

	return $enqueue_styles;
}

// Enqueue Woocommerce Custom Styles 
function wp_enqueue_woocommerce_style() {
	wp_register_style( 'rscard-woocommerce-layout', get_template_directory_uri() . '/woocommerce/css/woocommerce-layout.css' );
	wp_register_style( 'rscard-woocommerce', get_template_directory_uri() . '/woocommerce/css/woocommerce.css' );
	wp_register_style( 'rscard-woocommerce-smallscreen', get_template_directory_uri() . '/woocommerce/css/woocommerce-smallscreen.css' );


	if ( class_exists( 'woocommerce' ) ) {
		wp_enqueue_style( 'rscard-woocommerce' );
		wp_enqueue_style( 'rscard-woocommerce-layout' );
		wp_enqueue_style( 'rscard-woocommerce-smallscreen' );
	}
}

add_action( 'wp_enqueue_scripts', 'wp_enqueue_woocommerce_style' );

/*
 * add to cart
 */
if ( class_exists( 'woocommerce' ) ) {
	add_filter( 'woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment' );

	function woocommerce_header_add_to_cart_fragment( $fragments ) {
		global $woocommerce;
		ob_start(); ?>

        <a class="head-woo" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
            <i class="rsicon rsicon-shopping-basket"></i>
            <span class="head-woo-count"><?php echo sprintf( _n( '%d', '%d', WC()->cart->cart_contents_count, 'rs-card' ), WC()->cart->cart_contents_count ); ?></span>
        </a>

		<?php
		$fragments['a.head-woo'] = ob_get_clean();

		return $fragments;
	}

	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
/*
 * Excerpt More
 */
add_filter( 'excerpt_more', 'rs_card_new_excerpt_more' );

if ( ! isset( $content_width ) ) {
	$content_width = 474;
}

/*
 * Add Required plugins functionality.
 */
require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';
if ( ! defined( 'rs-card' ) ) {
	define( 'rs-card', 'rs-card' );
}

add_action( 'tgmpa_register', 'rs_card_register_required_plugins' );
function rs_card_register_required_plugins() {
	$plugins = array(
		array(
			'name'               => 'Advanced Custom Fields Pro',
			// The plugin name
			'slug'               => 'advanced-custom-fields-pro',
			// The plugin slug (typically the folder name)
			'source'             => get_template_directory_uri() . '/inc/plugins/advanced-custom-fields-pro.zip',
			// The plugin source
			'version'            => '5.12.3',
			// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'required'           => true,
			// If false, the plugin is only 'recommended' instead of required
			'force_activation'   => false,
			// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' => false,
			// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'       => '',
			// If set, overrides default API URL and points to an external URL
		),
		array(
			'name'               => 'Portfolio Posts',
			// The plugin name
			'slug'               => 'portfolio-custom-post-type',
			// The plugin slug (typically the folder name)
			'source'             => get_template_directory_uri() . '/inc/plugins/portfolio-custom-post-type.zip',
			// The plugin source
			'version'            => '',
			// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'required'           => true,
			// If false, the plugin is only 'recommended' instead of required
			'force_activation'   => false,
			// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' => false,
			// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'       => '',
			// If set, overrides default API URL and points to an external URL
		),
		array(
			'name'               => 'Shortcodes',
			// The plugin name
			'slug'               => 'rs-card-shortcodes',
			// The plugin slug (typically the folder name)
			'source'             => get_template_directory_uri() . '/inc/plugins/rs-card-shortcodes.zip',
			// The plugin source
			'version'            => '1.7',
			// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'required'           => true,
			// If false, the plugin is only 'recommended' instead of required
			'force_activation'   => false,
			// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' => false,
			// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'       => '',
			// If set, overrides default API URL and points to an external URL
		),
		array(
			'name'               => 'Redux Framework',
			// The plugin name
			'slug'               => 'redux-framework',
			// The plugin slug (typically the folder name)
			'source'             => 'https://wordpress.org/plugins/redux-framework/',
			// The plugin source
			'version'            => '',
			// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'required'           => true,
			// If false, the plugin is only 'recommended' instead of required
			'force_activation'   => false,
			// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' => false,
			// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'       => 'https://wordpress.org/plugins/redux-framework/',
			// If set, overrides default API URL and points to an external URL
		),
		array(
			'name'               => 'Contact Form',
			// The plugin name
			'slug'               => 'rs-card-contact-form',
			// The plugin slug (typically the folder name)
			'source'             => get_template_directory_uri() . '/inc/plugins/rs-card-contact-form.zip',
			// The plugin source
			'version'            => '1.2',
			// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'required'           => true,
			// If false, the plugin is only 'recommended' instead of required
			'force_activation'   => false,
			// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' => false,
			// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'       => '',
			// If set, overrides default API URL and points to an external URL
		),
		array(
			'name'               => __( 'One Click Demo Importer', 'rs-card' ),
			// The plugin name
			'slug'               => 'one-click-demo-import',
			// The plugin slug (typically the folder name)
			'source'             => 'https://wordpress.org/plugins/one-click-demo-import/',
			// The plugin source
			'version'            => '',
			// E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'required'           => false,
			// If false, the plugin is only 'recommended' instead of required
			'force_activation'   => false,
			// If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' => false,
			// If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url'       => 'https://wordpress.org/plugins/one-click-demo-import/',
			// If set, overrides default API URL and points to an external URL
		)

	);


	$theme_text_domain = 'rs-card';

	$config = array(
		'domain'       => 'rs-card',                    // Text domain - likely want to be the same as your theme.
		'default_path' => '',                            // Default absolute path to pre-packaged plugins
		'menu'         => 'install-required-plugins',    // Menu slug
		'has_notices'  => true,                        // Show admin notices or not
		'is_automatic' => false,                        // Automatically activate plugins after installation or not
		'message'      => '',                            // Message to output right before the plugins table
		'strings'      => array(
			'page_title'                      => esc_html__( 'Install Required Plugins', 'rs-card' ),
			'menu_title'                      => esc_html__( 'Install Plugins', 'rs-card' ),
			'installing'                      => esc_html__( 'Installing Plugin: %s', 'rs-card' ),
			// %1$s = plugin name
			'oops'                            => esc_html__( 'Something went wrong with the plugin API.', 'rs-card' ),
			'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'rs-card' ),
			// %1$s = plugin name(s)
			'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'rs-card' ),
			// %1$s = plugin name(s)
			'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'rs-card' ),
			// %1$s = plugin name(s)
			'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'rs-card' ),
			// %1$s = plugin name(s)
			'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'rs-card' ),
			// %1$s = plugin name(s)
			'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'rs-card' ),
			// %1$s = plugin name(s)
			'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'rs-card' ),
			// %1$s = plugin name(s)
			'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'rs-card' ),
			// %1$s = plugin name(s)
			'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'rs-card' ),
			'activate_link'                   => _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'rs-card' ),
			'return'                          => esc_html__( 'Return to Required Plugins Installer', 'rs-card' ),
			'plugin_activated'                => esc_html__( 'Plugin activated successfully.', 'rs-card' ),
			'complete'                        => esc_html__( 'All plugins installed and activated successfully. %s', 'rs-card' ),
			// %1$s = dashboard link
			'nag_type'                        => 'updated'
			// Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa( $plugins, $config );

}

if( !function_exists('is_plugin_active') ) {
			
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	
}


require_once( get_template_directory() . '/inc/acf.php' );
if ( ! class_exists( 'acf' ) && ! is_admin() ) {
	function get_field() {
		return '';
	}
}

if ( is_plugin_active( 'one-click-demo-import/one-click-demo-import.php' ) ) {
	require_once( get_template_directory() . '/inc/one_click_import.php' );
}

function rs_card_languages_list() {
	if ( class_exists( 'SitePress' ) ) {
		$languages = icl_get_languages( 'skip_missing=0&orderby=code' );
		if ( ! empty( $languages ) ) {
			?>
            <div class="head-lang">
                <span class="lang-active"><?php echo esc_html( ICL_LANGUAGE_CODE ); ?></span>
                <ul class="lang-list">
					<?php foreach ( $languages as $l ): ?>
                        <li>
							<?php
							if ( $l['country_flag_url'] ):
								if ( ! $l['active'] ):
									?>
                                    <a href="<?php echo esc_url( $l['url'] ); ?>">
									<?php
								endif;
								if ( ! $l['active'] ):
									?>
                                    </a>
									<?php
								endif;
							endif;
							if ( ! $l['active'] ): ?>
                            <a href="<?php echo esc_url( $l['url'] ); ?>">
								<?php
								endif;
								echo icl_disp_language( $l['native_name'], $l['translated_name'] );
								if ( ! $l['active'] ): ?>
                            </a>
						<?php endif; ?>
                        </li>
					<?php endforeach; ?>
                </ul>
            </div>
			<?php
		}
	} else {
		return '';
	}
}


if ( ! function_exists( 'rs_card_setup' ) ) :
	/**
	 * Rs-Card setup.
	 *
	 * Set up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support post thumbnails.
	 *
	 * @since Rs-Card 1.0
	 */
	function rs_card_setup() {

		/*
		 * Make Rs-Card available for translation.
		 *
		 * Translations can be added to the /languages/ directory.
		 * If you're building a theme based on Rs-Card, use a find and
		 * replace to change 'rs-card' to the name of your theme in all
		 * template files.
		 */
		load_theme_textdomain( 'rs-card', get_template_directory() . '/languages' );

		// Include Redux Framework functions
		if ( class_exists( 'ReduxFramework' ) && is_admin() ) {
			require_once( get_template_directory() . '/inc/sample-config.php' );
		}


		// Add RSS feed links to <head> for posts and comments.
		add_theme_support( 'automatic-feed-links' );

		// Enable support for Post Thumbnails, and declare two sizes.
		add_theme_support( 'post-thumbnails' );
		add_theme_support( "title-tag" );
		set_post_thumbnail_size( 53, 53, true );
		set_post_thumbnail_size( 672, 372, true );
		// Set some image sizes
		add_image_size( 'rs-card-profile-photo', 299, 347, true );
		add_image_size( 'rs-card-profile-photo-2x', 598, 694, true );
		add_image_size( 'rs-card-single-post', 617, 400, true );
		add_image_size( 'rs-card-single-post-big', 940, 400, true );
		add_image_size( 'rs-card-archive-post', 449, 286, true );
		add_image_size( 'rs-card-thumb-widget', 78, 56, true );
		add_image_size( 'rs-card-portfolio-big', 607, 576, true );
		add_image_size( 'rs-card-portfolio-small', 294, 278, true );
		add_image_size( 'rs-card-portfolio-slider', 940, 473, true );
		add_image_size( 'rs-card-portfolio-popup', 645, 452, true );
		add_image_size( 'rs-card-clients', 200, '', true );
		add_image_size( 'rs-card-exp-logo', 400, '', true );

		/**
		 * @param $post_id
		 * @param $image_id
		 * @param string $size
		 * @param string $class
		 * @return 2x size if -2x image size is added
		 */
		function rs_card_post_thumbnail( $post_id, $image_id, $size = 'image', $class = '' )
		{
			if(!empty($post_id)){
				$thumb_id = get_post_thumbnail_id( $post_id );
			}elseif(!empty($image_id)){
				$thumb_id = $image_id;
			}else{
				$thumb_id = '';
			}

			$thumbnail_src = wp_get_attachment_image_src( $thumb_id, $size );
			$thumbnail = $thumbnail_src[0];
			$thumbnail_2x_src = wp_get_attachment_image_src( $thumb_id, $size . '-2x' );
			$thumbnail_2x = $thumbnail_2x_src[0];
			$image  = '<img alt="" src="' . $thumbnail . '"';
			$image .= ( $thumbnail_2x ?  ' srcset="' : '' ); // open srcset
			$image .= ( $thumbnail_2x ? $thumbnail_2x . ' 2x' : '' );
			$image .= ( $thumbnail_2x ?  '"' : '' ); // close srcset
			$image .= ( $class ? ' class="' . esc_attr($class) . '"' : '' );
			$image .= ' >';

			return $image;
		}

		if ( ! function_exists( 'rs_card_entry_meta' ) ) :
			/**
			 * Prints HTML with meta information for the categories, tags.
			 *
			 * @since Twenty Fifteen 1.0
			 */
			function rs_card_entry_meta() {
				if ( is_sticky() && is_home() && ! is_paged() ) {
					printf( '<span class="sticky-post">%s</span>', esc_html__( 'Featured', 'rs-card' ) );
				}

				$format = get_post_format();
				if ( current_theme_supports( 'post-formats', $format ) ) {
					printf( '<span class="entry-format">%1$s<a href="%2$s">%3$s</a></span>',
						sprintf( '<span class="screen-reader-text">%s </span>', _x( 'Format', 'Used before post format.', 'rs-card' ) ),
						esc_url( get_post_format_link( $format ) ),
						get_post_format_string( $format )
					);
				}

				if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
					$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

					if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
						$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
					}

					$time_string = sprintf( $time_string,
						esc_attr( get_the_date( 'c' ) ),
						get_the_date(),
						esc_attr( get_the_modified_date( 'c' ) ),
						get_the_modified_date()
					);

					printf( '<span class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark">%3$s</a></span>',
						_x( 'Posted on', 'Used before publish date.', 'rs-card' ),
						esc_url( get_permalink() ),
						$time_string
					);
				}

				if ( 'post' == get_post_type() ) {
					if ( is_singular() || is_multi_author() ) {
						printf( '<span class="byline"><span class="author vcard"><span class="screen-reader-text">%1$s </span><a class="url fn n" href="%2$s">%3$s</a></span></span>',
							_x( 'Author', 'Used before post author name.', 'rs-card' ),
							esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
							get_the_author()
						);
					}

					$categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'rs-card' ) );
					if ( $categories_list && rscard_categorized_blog() ) {
						printf( '<span class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
							_x( 'Categories', 'Used before category names.', 'rs-card' ),
							$categories_list
						);
					}

					$tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'rs-card' ) );
					if ( $tags_list ) {
						printf( '<span class="tags-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
							_x( 'Tags', 'Used before tag names.', 'rs-card' ),
							$tags_list
						);
					}
				}

				if ( is_attachment() && wp_attachment_is_image() ) {
					// Retrieve attachment metadata.
					$metadata = wp_get_attachment_metadata();

					printf( '<span class="full-size-link"><span class="screen-reader-text"> %1$s </span><a href="%2$s">%3$s &times; %4$s</a></span>',
						_x( 'Full size', 'Used before full size attachment link.', 'rs-card' ),
						esc_url( wp_get_attachment_url() ),
						$metadata['width'],
						$metadata['height']
					);
				}

				if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
					echo '<span class="comments-link">';
					/* translators: %s: post title */
					comments_popup_link( sprintf( esc_html__( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'rs-card' ), get_the_title() ) );
					echo '</span>';
				}
			}
		endif;

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus( array(
			'primary' => esc_html__( 'Top primary menu', 'rs-card' ),
		) );

		/*
         * Custom walker menu class.
         */
		require_once get_template_directory() . '/inc/class-rscard-walker-menu.php';

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption'
		) );

		/*
		 * Enable support for Post Formats.
		 * See http://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'video',
			'audio',
			'gallery',
		) );

		// This theme allows users to set a custom background.
		add_theme_support( 'custom-background', apply_filters( 'rscard_custom_background_args', array(
			'default-color' => 'f5f5f5',
		) ) );

		// Add support for featured content.
		add_theme_support( 'featured-content', array(
			'featured_content_filter' => 'rscard_get_featured_posts',
			'max_posts'               => 6,
		) );

		// This theme uses its own gallery styles.
		add_filter( 'use_default_gallery_style', '__return_false' );

		/**
		 * Opting out of the block-based widgets editor
		 */
		remove_theme_support( 'widgets-block-editor' );
	}
endif; // rscard_setup
add_action( 'after_setup_theme', 'rs_card_setup' );

/**
 * Adjust content_width value for image attachment template.
 *
 * @since Rs-Card 1.0
 */
function rs_card_content_width() {
	if ( is_attachment() && wp_attachment_is_image() ) {
		$GLOBALS['content_width'] = 810;
	}
}

add_action( 'template_redirect', 'rs_card_content_width' );

/**
 * Getter function for Featured Content Plugin.
 *
 * @since Rs-Card 1.0
 *
 * @return array An array of WP_Post objects.
 */
function rs_card_get_featured_posts() {
	/**
	 * Filter the featured posts to return in Rs-Card.
	 *
	 * @since Rs-Card 1.0
	 *
	 * @param array|bool $posts Array of featured posts, otherwise false.
	 */
	return apply_filters( 'rs_card_get_featured_posts', array() );
}

/**
 * A helper conditional function that returns a boolean value.
 *
 * @since Rs-Card 1.0
 *
 * @return bool Whether there are featured posts.
 */
function rscard_has_featured_posts() {
	return ! is_paged() && (bool) rscard_get_featured_posts();
}

/**
 * Register three Rs-Card widget areas.
 *
 * @since Rs-Card 1.0
 */
function rs_card_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Primary Sidebar', 'rs-card' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Main sidebar that appears on the left.', 'rs-card' ),
		'before_widget' => '<aside class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}

add_action( 'widgets_init', 'rs_card_widgets_init' );

// Rs-Card Widgets

// Include recent posts widget
require_once( get_template_directory() . '/inc/widgets/widget-recent-posts.php' );

// Include enque styles,scripts and custom css
require_once( get_template_directory() . '/inc/enque.php' );

function rscard_the_attached_image_alt() {

	$thumb_img = get_post_meta( get_post_thumbnail_id() );
	if ( isset( $thumb_img['_wp_attachment_image_alt'] ) ):
		$alt = $thumb_img['_wp_attachment_image_alt']['0'];
	else:
		$alt = "";
	endif;

	return $alt;
}

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Rs-Card 1.0
 *
 * @global int $paged WordPress archive pagination page count.
 * @global int $page WordPress paginated post page count.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 *
 * @return string The filtered title.
 */
function rs_card_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
		$title = "$title $sep " . sprintf( esc_html__( 'Page %s', 'rs-card' ), max( $paged, $page ) );
	}

	return $title;
}

add_filter( 'wp_title', 'rs_card_wp_title', 10, 2 );

// Edit Comments styles
if ( ! function_exists( 'rscard_comment' ) ) :
	function rscard_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		?>
    <li <?php comment_class(); ?>>
        <article class="comment-body" id="comment-<?php comment_ID(); ?>">
            <div class="comment-avatar">
				<?php echo str_replace( 'avatar ', '', get_avatar( $comment, $size = '64' ) ); ?>
            </div>
            <div class="comment-content">
                <div class="comment-meta">
                    <span class="name"><?php comment_author(); ?></span>
                    <time class="date"
                          datetime="<?php echo get_the_date( 'c' ); ?>"><?php echo get_comment_date( 'M d, Y' ); ?><?php esc_html_e( " at ", "rs-card" ) ?><?php echo get_comment_date( 'g:i a' ); ?></time>
					<?php comment_reply_link( array_merge( $args, array(
						'class'     => 'reply-link',
						'depth'     => $depth,
						'max_depth' => $args['max_depth']
					) ) ); ?>
                </div>
                <div class="comment-message">
					<?php comment_text(); ?>
                </div>
            </div>
        </article>
		<?php
	}
endif;

//style comment form submit button
function rs_card_awesome_comment_form_submit_button( $button ) {
	$button =
		'
			<span class="btn-outer btn-primary-outer ripple">
				<input class="btn btn-lg btn-primary" name="submit" type="submit" value="Leave Comment">
			</span>
		';

	return $button;
}

add_filter( 'comment_form_submit_button', 'rs_card_awesome_comment_form_submit_button' );

//Excerpt styles
function rs_card_custom_excerpt_length( $length ) {
	return 50;
}

add_filter( 'excerpt_length', 'rs_card_custom_excerpt_length', 999 );
function rs_card_new_excerpt_more( $more ) {
	return '';
}

add_filter( 'excerpt_more', 'rs_card_new_excerpt_more' );

add_filter( 'the_content_more_link', 'rs_card_modify_read_more_link' );
function rs_card_modify_read_more_link() {
	return '<div class="post-more"><a class="btn btn-border" href="' . get_permalink() . '">Read More</a></div>';
}

if ( is_admin() ) {
	add_action( 'wp_ajax_rs_card_get_portfolio', 'rs_card_get_portfolio' );
	add_action( 'wp_ajax_nopriv_rs_card_get_portfolio', 'rs_card_get_portfolio' );
}

function rs_card_get_portfolio() {
	$data = get_template_part( 'inc/components/portfolio' );
	echo json_encode( $data );
	exit;
}

// Allow iframe tags within editor
function rs_card_allow_multisite_tags( $multisite_tags ) {
	$multisite_tags['iframe'] = array(
		'src'             => true,
		'width'           => true,
		'height'          => true,
		'align'           => true,
		'class'           => true,
		'name'            => true,
		'id'              => true,
		'frameborder'     => true,
		'seamless'        => true,
		'srcdoc'          => true,
		'sandbox'         => true,
		'allowfullscreen' => true
	);

	return $multisite_tags;
}

add_filter( 'wp_kses_allowed_html', 'rs_card_allow_multisite_tags', 1 );