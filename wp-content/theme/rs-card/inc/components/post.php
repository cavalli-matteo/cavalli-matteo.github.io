<?php
$post_type = get_post_format(get_the_ID());
$alt = rscard_the_attached_image_alt();
$author_link = get_author_posts_url(get_the_author_meta( "ID" ));
$author_name = get_the_author_meta( "display_name" );
$comment_link = get_comments_link();
$comment_number = get_comments_number();
$image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'rs-card-archive-post', false);
?>


<article <?php post_class(); ?>>
    <div class="post-media <?php if (!$image) echo 'no-media'; ?>">
        <?php if ($image) : ?>
            <?php if ($post_type == "gallery") :
                $slider_images = get_field('slider_images');
                if($slider_images):
                ?>
                <ul class="post-slider">
                    <?php foreach($slider_images as $image):?>
                        <li><img src="<?php echo esc_url($image['sizes']['rs-card-archive-post']);?>" alt="<?php echo esc_attr($image['alt']);?>"/></li>
                    <?php endforeach;?>
                </ul>                
                <div class="post-slider-arrows">
                    <div class="slider-prev"></div>
                    <div class="slider-next"></div>
                </div>
            <?php endif; else : ?>
                <div class="post-image">
                    <a href="<?php the_permalink();?>">
                        <img src="<?php echo esc_url($image[0]);?>" alt="<?php echo esc_attr($alt);?>"/>

                        <?php if ($post_type == "video") : ?>
                            <span class="post-type-icon"><i class="rsicon rsicon-play"></i></span>
                        <?php endif; ?>

                        <?php if ($post_type == "audio") : ?>
                            <span class="post-type-icon"><i class="rsicon rsicon-audio"></i></span>
                        <?php endif; ?>
                    </a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <div class="post-data">
        <time class="post-datetime" datetime="<?php echo get_the_date( 'c' ); ?>">
            <span class="day"><?php the_time('d');?></span>
            <span class="month"><?php the_time('M');?></span>
        </time>

        <div class="post-tag">
            <?php
            $category = get_the_category();
            foreach($category as $cat):
                ?>
                <a href="<?php echo esc_url(get_category_link($cat->term_id));?>"><?php esc_html_e('#','rs-card')?><?php echo esc_html($cat->name);?></a>
            <?php endforeach;?>
        </div>

        <h3 class="post-title">
            <a href="<?php the_permalink();?>"><?php the_title();?></a>
        </h3>
        <?php if ( is_front_page() && is_home() ):?>
            <div class="post-editor clearfix">
                <?php
                    if(strstr($post->post_content,'<!--more-->')) { the_content(); }
                    else { the_excerpt(); }
                ?>
            </div>
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
            <?php if(!strstr($post->post_content,'<!--more-->')) :?>
                <div class="post-more"><a class="btn btn-border" href="<?php the_permalink();?>"><?php esc_html_e('Read More', 'rs-card')?></a></div>
            <?php endif;?>
        <?php endif;?>

        <div class="post-info">
            <a href="<?php echo esc_url($author_link);?>"><i class="rsicon rsicon-user"></i><?php esc_html_e('by','rs-card')?> <?php echo esc_html($author_name);?></a>
            <?php if (comments_open()) :?>
                <a href="<?php echo esc_url($comment_link);?>"><i class="rsicon rsicon-comments"></i><?php echo intval($comment_number);?></a>
            <?php endif;?>
        </div>
    </div>
</article>