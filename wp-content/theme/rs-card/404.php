<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Rs-Card
 * @since Rs-Card 1.0
 */

get_header(); ?>

<div class="page-404">
    <h2><?php esc_html_e('4','rs-card')?><span><?php esc_html_e('0','rs-card')?></span><?php esc_html_e('4','rs-card')?></h2>
    <p><?php esc_html_e("Ooops! This page doesn't even exist",'rs-card')?></p>
    <a class="btn btn-lg btn-border" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Go To The Homepage ?','rs-card')?></a>
</div>

<?php get_footer(); ?>
