<?php
/**
 * The template for displaying search results pages.
 *
 * @package WordPress
 * @subpackage Rs-Card
 * @since Rs-Card 1.0
 */

get_header(); ?>
    <main class="search-page">
        <section class="section-box animate-up">
            <?php if (have_posts()) : ?>
                <h2><?php printf( esc_html__( "Search Results for: %s", 'rs-card' ), get_search_query() ); ?></h2>
                <?php while (have_posts()):the_post(); ?>
                    <article class="search-post">
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <?php the_excerpt(); ?>
                    </article>
                <?php  endwhile;?>
            <?php else :?>
                <h2><?php esc_html_e( 'Nothing Found', 'rs-card' ); ?></h2>
                <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'rs-card' ); ?></p>
                <div class="search-page-form">
                    <form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <div class="input-field">
                            <input name="s" type="text" title="Search">
                            <span class="line"></span>
                            <label><?php esc_html_e( 'Search and hit enter...', 'rs-card' ); ?></label>
                        </div>
                    </form>
                </div>
            <?php endif;?>
        </section>
    </main>
<?php get_footer(); ?>