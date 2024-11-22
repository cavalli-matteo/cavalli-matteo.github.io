<?php
/**
 * The template for displaying all portfolio posts
 *
 * @package WordPress
 * @subpackage Rs-Card
 * @since Rs-Card 1.0
 */

get_header(); ?>

<div class="content">
	<div class="container">

		<div class="section-box animate-up">
			<?php 
			if(have_posts()):the_post();
				$alt = rscard_the_attached_image_alt();
				$project_fields = get_field('project_fields');
				$logo_image = get_field('logo_image');
				$terms = get_the_terms( get_the_ID(), 'portfolio_categories' );
				$term_name = '';
				if($terms):
					foreach($terms as $term_item){
						$term_name .= $term_item->name.' | ';
					}
				endif;
			?>
				<main class="pf-post clear-mrg">
					<header class="pf-post-head text-center clear-mrg">
						<?php if(!empty($logo_image)):?>
							<img class="pf-post-logo" src="<?php echo esc_url($logo_image['url']);?>" alt="<?php echo esc_attr($logo_image['alt']);?>">
						<?php endif;?>
						<h2 class="pf-post-title"><?php the_title();?></h2>
						<p class="pf-post-text"><?php echo esc_html(rtrim($term_name, " | "));?></p>
					</header>
					
					<?php  if(!empty($project_fields)):?>
						<dl class="pf-post-def">
							<?php foreach($project_fields as $field):?>
								<?php if(!empty($field['project_field_name'])):?>
									<dt><?php echo esc_html($field['project_field_name']);?></dt>
								<?php endif;?>
								<?php if(!empty($field['project_field_value'])):?>
									<dd><?php echo wp_kses_post($field['project_field_value']);?></dd>
								<?php endif;?>
							<?php endforeach;?>
						</dl>
					<?php endif;?>
					<?php the_content();?>								
				</main>
			<?php endif;?>
		</div>
		<nav class="post-pagination section-box animate-up">
			<?php
				$prev_post = get_previous_post();
				if($prev_post):
				$author_link = get_author_posts_url(get_the_author_meta( "ID",$prev_post->post_author ));
				$author_name = get_the_author_meta( "display_name", $prev_post->post_author );
				$comment_link = get_comments_link($prev_post->ID);
				$comment_number = get_comments_number($prev_post->ID);
			?>
				<div class="post-next">
					<div class="post-tag"><?php esc_html_e('Previous Article','rs-card');?></div>
					<h3 class="post-title"><?php previous_post_link('%link'); ?></h3>

					<div class="post-info">
						<a href="<?php echo esc_url($author_link);?>"><i class="rsicon rsicon-user"></i><?php esc_html_e('by','rs-card')?> <?php echo esc_html($author_name);?></a>
						<?php if (comments_open($prev_post->ID)) :?>
							<a href="<?php echo esc_url($comment_link);?>"><i class="rsicon rsicon-comments"></i><?php echo intval($comment_number);?></a>
						<?php endif;?>
					</div>
				</div>
			<?php endif;?>
			<?php
				$next_post = get_next_post();
				if($next_post):
					$author_link = get_author_posts_url(get_the_author_meta( "ID",$next_post->post_author ));
					$author_name = get_the_author_meta( "display_name", $next_post->post_author );
					$comment_link = get_comments_link($next_post->ID);
					$comment_number = get_comments_number($next_post->ID);
			?>
				<div class="post-prev">
					<div class="post-tag"><?php esc_html_e('Next Article','rs-card');?></div>
					<h3 class="post-title"><?php next_post_link('%link'); ?></h3>

					<div class="post-info">
						<a href="<?php echo esc_url($author_link);?>"><i class="rsicon rsicon-user"></i><?php esc_html_e('by','rs-card')?> <?php echo esc_html($author_name);?></a>
						<?php if (comments_open($next_post->ID)) :?>
							<a href="<?php echo esc_url($comment_link);?>"><i class="rsicon rsicon-comments"></i><?php echo intval($comment_number);?></a>
						<?php endif;?>
					</div>
				</div>
			<?php endif;?>
		</nav>
	</div><!-- .container -->
</div><!-- .content -->

<?php get_footer(); ?>