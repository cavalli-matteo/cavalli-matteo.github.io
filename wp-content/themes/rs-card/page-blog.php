<?php
/**
 * The template for displaying Blog posts
 *
 * template name: Blog
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Rs-Card
 * @since Rs-Card 1.0
 */

get_header(); ?>
    <div class="blog">
        <?php
            if( get_query_var( 'paged' ) ):
                $my_page = get_query_var( 'paged' );
            else:
                if( get_query_var( 'page' ) ):
                    $my_page = get_query_var( 'page' );
                else:
                    $my_page = 1;
                endif;
                set_query_var( 'paged', $my_page );
                $paged = $my_page;
            endif;
            $category = get_the_category();
            $posts_per_page = get_option('posts_per_page');
            $args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => $posts_per_page,
                'orderby' => 'date',
                'order' => 'DESC',
                'paged' => $paged
            );

            $blog_posts = new WP_Query($args);
        if($blog_posts->have_posts()): ?>
			<div class="blog-grid">
                <div class="grid-sizer"></div>                
				<?php while($blog_posts->have_posts()):$blog_posts->the_post(); ?>                				
					<div class="grid-item animate-up">
						<?php get_template_part('inc/components/post'); ?>
					</div>                           				
				<?php wp_reset_postdata(); endwhile;?>
			</div>
			
            <div class="pagination animate-up">
                <?php
                $total = $blog_posts->found_posts;
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
                ));
                if (comments_open()) {
                    comments_template('', true);
                }
                ?>
            </div>
        <?php endif;?>
    </div>

<?php get_footer(); ?>