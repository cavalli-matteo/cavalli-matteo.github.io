<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * e.g., it puts together the home page when no home.php file exists.
 *
 * Learn more: {@link https://codex.wordpress.org/Template_Hierarchy}
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Rs-Card 1.0
 */

get_header(); ?>

    <div class="blog">
		<div class="blog-grid">
            <div class="grid-sizer"></div> 
			<?php
			$category = get_the_category();
			if(have_posts()):
				while(have_posts()):the_post(); ?>					
					<div class="grid-item animate-up">
						<?php get_template_part('inc/components/post'); ?>
					</div>					
				<?php endwhile;?>				
			<?php endif;?>
		</div>
		<div class="pagination animate-up">
					<?php
					$total = $wp_query->found_posts;
					$page = isset( $_GET['page'] ) ? abs( (int) $_GET['page'] ) : 1;
					$format = 'page/%#%/';
					$current_page = max(1, $paged);
					$big = 999999999;
					echo paginate_links( array(
						'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
						'format' => '?page=%#%',
						'end_size'           => 1,
						'mid_size'           => 2,
						'prev_next'          => True,
						'prev_text'          => '<i class="rsicon rsicon-chevron_left"></i>',
						'next_text'          => '<i class="rsicon rsicon-chevron_right"></i>',
						'type'               => 'plain',
						'add_args'           => False,
						'add_fragment'       => '',
						'before_page_number' => '',
						'after_page_number'  => '',
						'total' => ceil($total / $posts_per_page),
						'current' => $current_page,
					));?>
				</div>
    </div>

<?php get_footer(); ?>