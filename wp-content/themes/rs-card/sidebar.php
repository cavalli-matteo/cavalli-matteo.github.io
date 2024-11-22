<?php
/**
 * The sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Rs-Card 1.0
 */
?>
<?php
$class = "";
$rscard_options = get_option('rscard_options');
if (!is_singular('post')) {
    $class = "sidebar-fixed";
} elseif(is_singular('post') && !(isset($rscard_options['author_image']['url']) && $rscard_options['author_image']['url'] != '' && isset($rscard_options['header-image'])) && isset($rscard_options['header-image']) && $rscard_options['header-image']['url'] != '') {
    $class = "sidebar-default sidebar-shift";
}else{
	$class = "sidebar-default";
}
?>
<div class="sidebar <?php echo esc_attr($class); ?>">
    <?php if (!is_singular('post')) : ?>
        <button class="btn-sidebar btn-sidebar-close"><i class="rsicon rsicon-close"></i></button>
    <?php endif; ?>
    <div class="widget-area">
		<?php if((isset($rscard_options['author_image']['url']) && $rscard_options['author_image']['url'] != '') || $rscard_options['author_image_title'] || $rscard_options['author_image_subtitle']):?>
			<aside class="widget widget-profile">
				<?php if(isset($rscard_options['author_image']['url']) && $rscard_options['author_image']['url'] != ''):?>
					<div class="profile-photo">
						<?php if($rscard_options['author_image_link']):?>
							<a href="<?php echo esc_url($rscard_options['author_image_link']);?>">
						<?php endif;?>
							<img src="<?php echo esc_url($rscard_options['author_image']['url']);?>" alt="Author Image">
						<?php if($rscard_options['author_image_link']):?>
							</a>
						<?php endif;?>
					</div>
				<?php endif;?>
				<div class="profile-info">
					<?php if($rscard_options['author_image_title']):?>
						<h2 class="profile-title"><?php echo esc_html($rscard_options['author_image_title']);?></h2>
					<?php endif;?>
					<?php if($rscard_options['author_image_subtitle']):?>
						<h3 class="profile-position"><?php echo esc_html($rscard_options['author_image_subtitle']);?></h3>
					<?php endif;?>
				</div>
			</aside>			
		<?php endif;?>
        <?php dynamic_sidebar('sidebar-1');?>
    </div>
</div>