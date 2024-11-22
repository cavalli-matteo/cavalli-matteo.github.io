<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Rs-Card 1.0
 */

get_header();
if(have_posts()):the_post();?>
    <div class="section-box animate-up animated">
        <h2><?php the_title();?></h2>
		<div class="clearfix"><?php the_content();?></div>		
    </div>
	
	<?php if (comments_open()) {
        comments_template('', true);
    }?>
<?php endif;
get_footer(); ?>
