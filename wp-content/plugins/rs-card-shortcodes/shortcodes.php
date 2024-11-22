<?php
/*
Plugin Name: Rs Card Shortcodes
Description: Declares a plugin that will create a custom Shortcodes for Rs Card theme.
Version: 1.7
*/

// One/half
add_shortcode('wrapper', 'one_half_wrapper');
function one_half_wrapper($atts, $cont = null) {

    $str = "<div class='row'>";
    $str .= do_shortcode($cont);
    $str .= '</div>';
    return $str;
}
add_shortcode('one_half', 'one_half');
function one_half($atts, $cont = null) {
    $str = '';
    $str .= "<div class='col-sm-6'>";
    $str .= do_shortcode($cont);
    $str .= "</div>";
    return $str;
}
add_shortcode('one_third', 'one_third');
function one_third($atts, $cont = null) {

    $str = '';
    $str .= "<div class='col-sm-4'>";
    $str .= do_shortcode($cont);
    $str .= "</div>";
    return $str;
}
add_shortcode('one_fourth', 'one_fourth');
function one_fourth($atts, $cont = null) {
    $str = '';
    $str .= "<div class='col-sm-3'>";
    $str .= do_shortcode($cont);
    $str .= "</div>";
    return $str;
}

// Button
add_shortcode('rs_card_button', 'rs_card_button');
function rs_card_button( $atts ) {
    extract( shortcode_atts( array(
        'button_text' => '',
        'button_link'   => '#',
        'target'   => '_blank',
        'style'   => 'default',
        'size'   => 'large',
    ), $atts ) );
	
		if(empty($style)){
			$style = 'default';
		}
		
		switch ($size){
			case 'medium':
			$btn_size = '';
			break;
			case 'small':
			$btn_size = 'btn-sm';
			break;
			default:
			$btn_size = 'btn-lg';
		}
	
	if($button_text || $button_link):
		$out = '<a class="btn '.$btn_size.' btn-'.$style.' ripple" target="'.$target.'" href="'.$button_link.'">'.$button_text.'</a>';
	endif;

    return $out;
}

// Slider
add_shortcode('rs_card_slider', 'rs_card_slider');
function rs_card_slider($atts, $cont = null) {
	extract( shortcode_atts( array(
        'style' => '',
    ), $atts ) );
	
	if(empty($style)){
		$style = '';
	}
	
	if($style == '2'){
		$style_class = ' slider-style2';
	}else{
		$style_class = '';
	}
	
    $str = '<div class="slider'.$style_class.'">';
    $str .= do_shortcode($cont);
    $str .= '</div>';
    return $str;
}
add_shortcode('slide', 'slide');
function slide($atts) {
	extract( shortcode_atts( array(
        'image_link' => '',
    ), $atts ) );
	
    $str = '';
    $str .= "<div class='rsslide'>";
    $str .= '<img src="'.$image_link.'" alt="slide" />';
    $str .= "</div>";
    return $str;
}

add_action('media_buttons','add_sc_select',11);

//tabs
//wrapper
add_shortcode('rs_card_tabs_wrapper', 'rs_card_tabs_wrapper');
function rs_card_tabs_wrapper($atts, $cont = null) {
    extract( shortcode_atts( array(
        'type' => '',
    ), $atts ) );

    if($type == 'vertical'){
        $class="vertical";
    }else{
        $class = 'horizontal';
    }

    $out = '<div class="tabs tabs-'.$class.'">';
    $out .= do_shortcode($cont);
    $out .= '</div>';

    return $out;
}

//tabs
//title wrapper
add_shortcode('rs_card_tab_title_wrapper', 'rs_card_tab_title_wrapper');
function rs_card_tab_title_wrapper($atts, $cont = null) {

    $out = '<ul class="tabs-menu">';
    $out .= do_shortcode($cont);
    $out .= '</ul>';

    return $out;
}

//tabs
//title
add_shortcode('rs_card_tab_title', 'rs_card_tab_title');
function rs_card_tab_title($atts, $cont = null) {
    extract( shortcode_atts( array(
        'for' => '',
    ), $atts ) );

    STATIC $i = 0; $i++;

    $out = '<li><a href="#'.$i.$for.'">';
    $out .= do_shortcode($cont);
    $out .= '</a></li>';

    return $out;
}

//tabs
//content wrapper
add_shortcode('rs_card_tab_content_wrapper', 'rs_card_tab_content_wrapper');
function rs_card_tab_content_wrapper($atts,$cont = null) {

    $out = '<div class="tabs-content">';
    $out .= do_shortcode($cont);
    $out .= '</div>';

    return $out;
}

//tabs
//content
add_shortcode('rs_card_tab_content', 'rs_card_tab_content');
function rs_card_tab_content($atts, $cont = null) {
    extract( shortcode_atts( array(
        'id' => '',
    ), $atts ) );

    STATIC $i = 0; $i++;

    $out = '<div id="'.$i.$id.'" class="tab-content">';
    $out .= do_shortcode($cont);
    $out .= '</div>';

    return $out;
}

//toggle
//wrapper
add_shortcode('rs_card_toggle_wrapper', 'rs_card_toggle_wrapper');
function rs_card_toggle_wrapper($atts, $cont = null) {

    $out = '<ul class="togglebox">';
    $out .= do_shortcode($cont);
    $out .= '</ul>';

    return $out;
}

//toggle
add_shortcode('rs_card_toggle', 'rs_card_toggle');
function rs_card_toggle($atts, $cont = null) {
    extract( shortcode_atts( array(
        'title' => '',
    ), $atts ) );

    $out = '<li><h3 class="togglebox-header">'.$title.'</h3><div class="togglebox-content">';
    $out .= do_shortcode($cont);
    $out .= '</div></li>';

    return $out;
}

//Accordion
//wrapper
add_shortcode('rs_card_accordion_wrapper', 'rs_card_accordion_wrapper');
function rs_card_accordion_wrapper($atts, $cont = null) {

    $out = '<ul class="accordion">';
    $out .= do_shortcode($cont);
    $out .= '</ul>';

    return $out;
}

//accordion
add_shortcode('rs_card_accordion', 'rs_card_accordion');
function rs_card_accordion($atts, $cont = null) {
    extract( shortcode_atts( array(
        'title' => '',
    ), $atts ) );

    $out = '<li><h3 class="accordion-header">'.$title.'</h3><div class="accordion-content">';
    $out .= do_shortcode($cont);
    $out .= '</div></li>';

    return $out;
}

//Instagram

function rs_card_instagram_curl( $url ){
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url); // uri
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // RETURN RESULT true
	curl_setopt($ch, CURLOPT_HEADER, 0); // RETURN HEADER false
	curl_setopt($ch, CURLOPT_NOBODY, 0); // NO RETURN BODY false / we need the body to return
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // VERIFY SSL HOST false
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // VERIFY SSL PEER false

	return json_decode(curl_exec($ch));
}

function rs_card_instagram_f($url){
	return rs_card_instagram_curl( $url );
}

//Instagram refresh token if expired
function rs_card_instagram_refresh_token( $access_token, $expire_in, $auth_timestamp ){
	if( time() - $auth_timestamp > $expire_in - 300 ){
		$url = 'https://graph.instagram.com/access_token?grant_type=ig_exchange_token&client_secret=d1c67318b6ec558a62bbca9a178fde30&access_token=' . $access_token;

		$result = rs_card_instagram_curl( $url );

		$rs_card_options = get_option( 'rscard_options' );
		$rs_card_options[ 'instagram-token' ] = $result->access_token;
		$rs_card_options[ 'instagram-expires-in' ] = $result->expires_in;
		$rs_card_options[ 'instagram-auth-timestamp' ] = time();

		update_option( 'rscard_options', $rs_card_options );
	}
}

add_shortcode('rs_card_instagram', 'rs_card_instagram');
function rs_card_instagram($atts, $cont = null) {
	extract( shortcode_atts( array(
        'count' => '',
    ), $atts ) );
	$out = '';
	if(empty($count)){
		$count = 20;
	}
	$rscard_options = get_option('rscard_options');
	
	if(!empty($rscard_options['instagram-token'])
		&& !empty($rscard_options['instagram-user-id'])
		&&!empty($rscard_options['instagram-expires-in'])
		&& !empty($rscard_options['instagram-auth-timestamp']) ):
			// refreh tokoen if expired
			rs_card_instagram_refresh_token( $rscard_options['instagram-token'], $rscard_options['instagram-expires-in'], $rscard_options['instagram-auth-timestamp'] );

			$feed_data = rs_card_instagram_f("https://graph.instagram.com/me/media?fields=IMAGE,media_url,permalink,thumbnail_url&access_token=".$rscard_options['instagram-token']);

			if($feed_data):
			$out .= '<ul class="instagram-feed clearfix">';
				$i = 0;
				foreach ($feed_data->data as $post):
					if($i == intval($count)):break;endif;
					$insta_thumb_url = '';
					if ( isset( $post->thumbnail_url ) ) {
						$insta_thumb_url = $post->thumbnail_url;
					} else {
						$insta_thumb_url = $post->media_url;
					}
					$out .= '<li>
							<a target="blank" href="'. $post->permalink .'"><img src="'. $insta_thumb_url .'" alt=""></a>
						</li>';
				$i++; endforeach;
			$out .= '</ul>';
		endif;
	endif;

    return $out;
}

//Twitter
require "tweet-php-master/TweetPHP.php";
function rs_card_get_twitter($consumer_key, $consumer_secret, $access_token, $access_token_secret, $twitter_screen_name, $tweets_to_display){
	$TweetPHP = new TweetPHP(array(
		'consumer_key'              => $consumer_key,
		'consumer_secret'           => $consumer_secret,
		'access_token'              => $access_token,
		'access_token_secret'       => $access_token_secret,
		'twitter_screen_name'       => $twitter_screen_name,
		'enable_cache'          => false,
		'cache_dir'             => dirname(__FILE__) . '/cache/', // Where on the server to save cached tweets
		'cachetime'             => 60 * 60, // Seconds to cache feed (1 hour).
		'tweets_to_retrieve'    => 60, // Specifies the number of tweets to try and fetch, up to a maximum of 200
		'tweets_to_display'     => $tweets_to_display, // Number of tweets to display
		'twitter_date_text'     => array('seconds', 'minutes', 'about', 'hour', 'ago'),
		'date_format'           => '%B %e, %Y %l:%M %P', // The defult date format e.g. 12:08 PM Jun 12th. See: http://php.net/manual/en/function.strftime.php
		'date_lang'             => null, // Language for date e.g. 'fr_FR'. See: http://php.net/manual/en/function.setlocale.php
		'twitter_template'      => '<div class="latest-tweets">{tweets}</div>',
		'tweet_template'        => '<div><p class="tweet-text">{tweet}</p><p class="tweet-details"><a target="_blank" href="{link}"><time datetime="2016-07-21 07:43:32+0000">{date}</time></a></p></div>',
		'error_template'        => '<div><span class="status">Our twitter feed is unavailable right now.</span> <span class="meta"><a href="{link}">Follow us on Twitter</a></span></div>',
	));

	return $TweetPHP->get_tweet_list();
}


add_shortcode('rs_card_twitter', 'rs_card_twitter');
function rs_card_twitter($atts, $cont = null) {
	extract( shortcode_atts( array(
        'username' => '',
        'count' => '',
        'show_twitter_icon' => '',
    ), $atts ) );	
	$out = '';
	$rscard_options = get_option('rscard_options');
	
	if(empty($count)){
		$count = 10;
	}
	
	if(empty($show_twitter_icon)){
		$show_twitter_icon = true;
	}elseif($show_twitter_icon == false){
		$show_twitter_icon = false;
	}
	
	if($show_twitter_icon == 'true'):
		$out.='<div class="twitter-icon">
			<i class="rsicon rsicon-twitter"></i>
		</div>';
	endif;

	if(!empty($rscard_options['twitter-consumer_key']) && !empty($rscard_options['twitter-consumer_secret']) && !empty($rscard_options['twitter-access_token']) && !empty($rscard_options['twitter-access_token_secret'])):
		if(!empty($username)):
			$out.= rs_card_get_twitter($rscard_options['twitter-consumer_key'],$rscard_options['twitter-consumer_secret'], $rscard_options['twitter-access_token'], $rscard_options['twitter-access_token_secret'],$username,$count);
		else:
			$out.= "Please put valid username to this shortcode's 'username' attribute";
		endif;
	else:
		$out.= 'Please fill in all twitter key fields at Rs-Card Options -> Api Options';
	endif;
    return $out;
}


function add_sc_select(){
    global $shortcode_tags;
	$shortcodes_list = '';
    echo '&nbsp;<select class="sc_select"><option value="">Select Shortcode</option>';
    $shortcodes_list .= '<option value="'."[wrapper][one_half]
<h3>ONE HALF</h3>
Established fact that a reader will be distracted by the readable content of a page when lookingt its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.[/one_half][one_half]
<h3>ONE HALF</h3>
Established fact that a reader will be distracted by the readable content of a page when lookingt its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.[/one_half][/wrapper]".'">One Half</option>';
    $shortcodes_list .= '<option value="'."[wrapper][one_third]
<h3>ONE�THIRD</h3>
Established fact that a reader will be distracted by the readable content of a page when lookingt its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.[/one_third][one_third]
<h3>ONE�THIRD</h3>
Established fact that a reader will be distracted by the readable content of a page when lookingt its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.[/one_third][one_third]
<h3>ONE�THIRD</h3>
Established fact that a reader will be distracted by the readable content of a page when lookingt its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.[/one_third][/wrapper]".'">One Third</option>';
    $shortcodes_list .= '<option value="'."[wrapper][one_fourth]
<h3>ONE�FOURTH</h3>
Established fact that a reader will be distracted by the readable content of a page when lookingt its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.[/one_fourth][one_fourth]
<h3>ONE�FOURTH</h3>
Established fact that a reader will be distracted by the readable content of a page when lookingt its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.[/one_fourth][one_fourth]
<h3>ONE�FOURTH</h3>
Established fact that a reader will be distracted by the readable content of a page when lookingt its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.[/one_fourth][one_fourth]
<h3>ONE�FOURTH</h3>
Established fact that a reader will be distracted by the readable content of a page when lookingt its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters.[/one_fourth][/wrapper]".'">One Fourth</option>';
	$shortcodes_list .= '<option value="'."[rs_card_button button_text='Download' button_link='#' target='_blank' style='border|default|primary|warning' size='small|medium|large']".'">Button</option>';
	$shortcodes_list .= '<option value="'."[rs_card_slider style='1|2'][slide image_link=''][slide image_link=''][slide image_link=''][/rs_card_slider]".'">Slider</option>';
	$shortcodes_list .= '<option value="'."[rs_card_tabs_wrapper type='horizontal|vertical']
											[rs_card_tab_title_wrapper]
												[rs_card_tab_title for='1']Tab 1[/rs_card_tab_title]
												[rs_card_tab_title for='2']Tab 2[/rs_card_tab_title]
												[rs_card_tab_title for='3']Tab 3[/rs_card_tab_title]
												[rs_card_tab_title for='4']Tab 4[/rs_card_tab_title]
											[/rs_card_tab_title_wrapper]
											[rs_card_tab_content_wrapper]
												[rs_card_tab_content id='1']
													Tab 1 content<br/>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna.
													Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit
													fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor.
												[/rs_card_tab_content]
												[rs_card_tab_content id='2']
													Tab 2 content<br/>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna.
													Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit
													fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor.
												[/rs_card_tab_content]
												[rs_card_tab_content id='3']
													Tab 3 content<br/>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna.
													Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit
													fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor.
												[/rs_card_tab_content]
												[rs_card_tab_content id='4']
													Tab 4 content<br/>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna.
													Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit
													fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor.
												[/rs_card_tab_content]
											[/rs_card_tab_content_wrapper]
										[/rs_card_tabs_wrapper]".'">Tabs</option>';
	$shortcodes_list .= '<option value="'."[rs_card_toggle_wrapper]
			[rs_card_toggle title='Toggle Box Title 1']
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna.
				Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit
				fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna.
				Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit
				fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor.
			[/rs_card_toggle]
			[rs_card_toggle title='Toggle Box Title 2']
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna.
				Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit
				fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna.
				Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit
				fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor.
			[/rs_card_toggle]
			[rs_card_toggle title='Toggle Box Title 3']
				Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna.
				Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit
				fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna.
				Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit
				fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor.
			[/rs_card_toggle]
	   [/rs_card_toggle_wrapper]".'">Toggle</option>';
	   
		$shortcodes_list .= '<option value="'."[rs_card_accordion_wrapper]
					[rs_card_accordion title='Accordion Box Title 1']
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna.
						Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit
						fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna.
						Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit
						fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor.
					[/rs_card_accordion]
					[rs_card_accordion title='Accordion Box Title 2']
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna.
						Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit
						fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna.
						Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit
						fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor.
					[/rs_card_accordion]
					[rs_card_accordion title='Accordion Box Title 3']
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna.
						Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit
						fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam sit amet purus urna.
						Proin dictum fringilla enim, sit amet suscipit dolor dictum in. Maecenas porttitor, est et malesuada congue, ligula elit
						fermentum massa, sit amet porta odio est at velit. Sed nec turpis neque. Fusce at mi felis, sed interdum tortor.
					[/rs_card_accordion]
			   [/rs_card_accordion_wrapper]".'">Accordion</option>';
		$shortcodes_list .= '<option value="'."[rs_card_instagram count='20']".'">Instagram</option>';
		$shortcodes_list .= '<option value="'."[rs_card_twitter username='' count='10' show_twitter_icon='true|false']".'">Twitter Rotator</option>';
    echo $shortcodes_list;
	
    echo '</select>';
}

function rscard_shortcode_enqueue_script() {
	wp_enqueue_script( 'rs-shortcode-button-js', plugin_dir_url( __FILE__ ).'shortcodes.js',array('jquery'),'', true );
} 
add_action( 'admin_enqueue_scripts', 'rscard_shortcode_enqueue_script' );
		
remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop' , 99 );
add_filter( 'the_content', 'shortcode_unautop', 100 );
