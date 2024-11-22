<?php
/**
 * The template for displaying search forms in Rs Card Theme
 *
 * @package Rs Card
 */
 $rscard_options = get_option('rscard_options');
 if(isset($rscard_options['search-label'])){
	$placeholder = $rscard_options['search-label'];
 }else{
	$placeholder = "Search ...";
 }
?>	
	<form method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label>
			<span class="screen-reader-text"><?php esc_html_e('Search for','rs-card'); ?></span>
			<input type="search" class="search-field" placeholder="<?php echo esc_attr($placeholder);?>" value="" name="s" title="Search for:">
		</label>
		<input type="submit" class="search-submit" value="Search">
	</form>