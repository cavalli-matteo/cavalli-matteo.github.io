<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Rs-Card
 * @since Rs-Card 1.0
 */

get_header(); ?>
    <?php
        if(have_posts()):the_post();
        $post_type = get_post_format(get_the_ID());
        $alt = rscard_the_attached_image_alt();
        $author_link = get_author_posts_url(get_the_author_meta( "ID" ));
        $author_name = get_the_author_meta( "display_name" );
        $comment_link = get_comments_link();
        $comment_number = get_comments_number();
		if($rscard_options['enable-side-menu-post']){
			$col_class="col-sm-8";
			$image_size = 'rs-card-single-post';
		}else{
			$col_class="col-sm-12";
			$image_size = 'rs-card-single-post-big';
		}
    ?>
        <div class="row">
            <div class="<?php echo esc_attr($col_class);?>">
                <main class="post-single">

                    <article <?php post_class();?>>
                        <div class="post-media">
                            <?php switch ($post_type) {
                                case false:
                                    if($image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), $image_size, false)):
                                    ?>
                                        <img src="<?php echo esc_url($image[0]);?>" alt="<?php echo esc_attr($alt);?>"/>
                                    <?php endif; break;
                                case 'video':
                                    $mp4_file = get_field('mp4_file');
                                    $webm_file = get_field('webm_file');
                                    $ogv_file = get_field('ogv_file');
                                    $vimeo_youtube_url = get_field('vimeo_youtube_url');
                                    $video_poster = get_field('video_poster');
                                    if($video_poster):
                                        $poster = $video_poster['url'];
                                    else:
                                        $poster = '';
                                    endif;
                                    if($mp4_file || $webm_file || $ogv_file):
                                    ?>
                                    <div class="post-embed">
                                        <div class="post-embed-item">
                                            <video style="width: 100%; height: 100%;" poster="<?php echo esc_url($poster);?>" controls="controls" preload="none">
                                                <?php if($mp4_file):?>
                                                    <source type="video/mp4" src="<?php echo esc_url($mp4_file);?>" />
                                                <?php
                                                    endif;
                                                    if($webm_file):
                                                ?>
                                                    <source type="video/webm" src="<?php echo esc_url($webm_file);?>" />
                                                <?php
                                                    endif;
                                                    if($ogv_file):
                                                ?>
                                                <source type="video/ogg" src="<?php echo esc_url($ogv_file);?>" />
                                                <?php endif;?>
                                            </video>
                                        </div>
                                    </div>
                                    <?php elseif($vimeo_youtube_url):?>
                                    <div class="post-embed">
                                        <iframe class="post-embed-item"
                                                src="<?php echo esc_url($vimeo_youtube_url);?>"
                                                allowfullscreen=""></iframe>
                                    </div>
                                    <?php endif; break;
                                case 'audio':
                                    $audio_file = get_field('audio_file');
                                    if($audio_file):
                                    ?>
                                        <div class="post-audio-wrap">
											<audio style="width: 100%" controls="controls">
												<source src="<?php echo esc_url($audio_file["url"]); ?>" type="<?php echo esc_attr($audio_file["mime_type"]); ?>">
											</audio>
                                        </div>
                                    <?php endif; break;
                                case 'gallery':
                                    $slider_images = get_field('slider_images');
                                    if($slider_images):
                                    ?>
                                    <ul class="post-slider">
                                        <?php foreach($slider_images as $image):?>
                                            <li><img src="<?php echo esc_url($image['sizes'][$image_size]);?>" alt="<?php echo esc_attr($image['alt']);?>"/></li>
                                        <?php endforeach;?>
                                    </ul>
                                    <div class="post-slider-arrows">
                                        <div class="slider-prev"></div>
                                        <div class="slider-next"></div>
                                    </div>
                                    <?php endif; break;
                            } ?>
                        </div>

                        <div class="post-inner">
                            <header class="post-header">
                                <div class="post-data">
                                    <div class="post-tag">
                                        <?php
                                            $category = get_the_category();
                                            foreach($category as $cat):
                                        ?>
                                                <a href="<?php echo esc_url(get_category_link($cat->term_id));?>"><?php esc_html_e('#','rs-card')?><?php echo esc_html($cat->name);?></a>
                                        <?php endforeach;?>
                                    </div>

                                    <div class="post-title-wrap">
                                        <h1 class="post-title"><?php the_title();?></h1>
                                        <time class="post-datetime" datetime="<?php echo get_the_date( 'c' ); ?>">
                                            <span class="day"><?php the_time('d');?></span>
                                            <span class="month"><?php the_time('M');?></span>
                                        </time>
                                    </div>

                                    <div class="post-info">
                                        <a href="<?php echo esc_url($author_link);?>"><i class="rsicon rsicon-user"></i><?php esc_html_e('by','rs-card')?> <?php echo esc_html($author_name);?></a>
                                        <?php if (comments_open()) :?>
                                            <a href="<?php echo esc_url($comment_link);?>"><i class="rsicon rsicon-comments"></i><?php echo intval($comment_number);?></a>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </header>

                            <div class="post-editor clearfix">
                               <?php the_content();?>
                               <?php
                               $defaults = array(
                                   'before'           => '<p>' . esc_html__( 'Pages:','rs-card' ),
                                   'after'            => '</p>',
                                   'link_before'      => '',
                                   'link_after'       => '',
                                   'next_or_number'   => 'number',
                                   'separator'        => ' ',
                                   'nextpagelink'     => esc_html__( 'Next page','rs-card' ),
                                   'previouspagelink' => esc_html__( 'Previous page','rs-card' ),
                                   'pagelink'         => '%',
                                   'echo'             => 1
                               );

                               wp_link_pages( $defaults );

                               ?>
                            </div>

                            <footer class="post-footer">
                                <div class="post-share">
                                    <script type="text/javascript"
                                            src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-503b5cbf65c3f4d8"
                                            async="async"></script>
                                    <div class="addthis_sharing_toolbox"></div>
                                </div>
                            </footer>
                        </div>
                    </article>
					<?php if(empty($rscard_options['disable_next_prev'])):?>
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
					<?php endif;?>

                    <?php
                    if (comments_open()) {
                        comments_template('', true);
                    }
                    ?>
                </main>
            </div>
			<?php if($rscard_options['enable-side-menu-post']):?>
				<div class="col-sm-4">
					<?php get_sidebar();?>
				</div>
			<?php endif;?>
        </div>
    <?php endif;?>
<?php get_footer(); ?>