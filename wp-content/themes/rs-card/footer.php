<?php
/**
 * The template for displaying the footer
 *
 * @package WordPress
 * @subpackage Rs-Card
 * @since Rs-Card 1.0
 */
?>


</div>
</div>

<footer class="footer">
    <div class="footer-social">
        <?php
            $rscard_options = get_option('rscard_options');
            if($rscard_options['display-footer-socials']):
                get_template_part('inc/components/social');
            endif;
        ?>
		<p align="center"><font color="#CBCDCF">Made with Wordpress and some night hours!</font>
		</p>
    </div>
</footer>
</div>

<div id="overlay"></div>
<div id="preloader">
	<div class="preload-icon"><span></span><span></span></div>
	<div class="preload-text"><?php esc_html__('Loading...','rs-card') ?></div>
</div>

<?php if(!empty($rscard_options['display-header-share']) && is_front_page()):?>
	<div id="profileShareWrap" class="profile-share-wrap">
		<div class="profile-share-table">
			<div class="profile-share-cell">			
				<div class="profile-share-inner">
					<button id="profileShareClose"><i class="rsicon rsicon-close"></i></button>
					<?php if(!empty($rscard_options['share-title'])):?>
						<h2 class="profile-share-title"><?php echo esc_html($rscard_options['share-title']);?></h2>
					<?php endif;?>
					<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5821a6c28931dc81"></script>
					<div class="addthis_inline_share_toolbox"></div>				
				</div>
			</div>
		</div>
	</div>
<?php endif;?>

<?php wp_footer();?>
</body>
</html>
