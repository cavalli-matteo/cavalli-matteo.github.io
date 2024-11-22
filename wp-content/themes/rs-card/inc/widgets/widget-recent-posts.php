<?php
/**
 * Add function to widgets_init that will load our widget.
 */
add_action( 'widgets_init', 'recent_posts_load_widgets' );

/**
 * Register our widget.
 */
function recent_posts_load_widgets() {
	register_widget( 'recent_Posts_Widget' );
}

/**
 * recent_Posts Widget class.
 */
class recent_Posts_Widget extends WP_Widget {

	/**
	 * Widget setup.
	 */
	function __construct() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'widget-popuplar-posts', 'description' => 'Latest Posts' );

		/* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 250, 'id_base' => 'latest-blog-posts-widget' );

		/* Create the widget. */
		parent::__construct( 'latest-blog-posts-widget', 'Rs-Card: Recent Posts', $widget_ops, $control_ops );
	}

	/**
	 * How to display the widget on the screen.
	 */
	function widget( $args, $instance ) {
		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$count = $instance['count'];
		$cat = $instance['cat'];
		$show_cat = isset($instance['show_cat']) ? 'true' : 'false';
		$show_thumbnail = isset($instance['show_thumbnail']) ? 'true' : 'false';


		/* Before widget (defined by themes). */			
		echo $before_widget;		

		
		/* Display the widget title if one was input (before and after defined by themes). */
		if ( $title ) echo $before_title . $title . $after_title;

        $args = array(
            'posts_per_page'   => $count,
            'category'         => $cat,
            'orderby'          => 'date',
            'order'            => 'DESC',
            'post_type'        => 'post',
            'post_status'      => 'publish',
            'suppress_filters' => true
        );
        $posts_array = get_posts( $args );
        if($posts_array):?>
            <ul>
            <?php
            global $post;
            foreach($posts_array as $post):setup_postdata($post);
            $comment_link = get_comments_link();
            $comment_number = get_comments_number();
            ?>
            <li>
                <?php
                    if($show_thumbnail == 'true' && has_post_thumbnail(get_the_ID())):
                    $image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'rs-card-thumb-widget', false);
                    $alt = rscard_the_attached_image_alt();
                ?>
                    <div class="post-media"><a href="<?php the_permalink();?>"><img src="<?php echo esc_url($image[0]);?>" alt="<?php echo esc_attr($alt);?>"/></a></div>
                <?php endif;?>
                <?php
                if($show_cat == 'true'):
                    $category = get_the_category();
                ?>
                    <div class="post-tag">
                        <?php foreach($category as $cat):?>
                            <a href="<?php echo esc_url(get_category_link($cat->term_id));?>"><?php esc_html_e('#','rs-card')?><?php echo esc_html($cat->name);?></a>
                        <?php endforeach;?>
                    </div>
                <?php endif;?>
                <h3 class="post-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                <?php if (comments_open()) :?>
                    <div class="post-info">
                        <a href="<?php echo esc_url($comment_link);?>"><i class="rsicon rsicon-comments"></i><?php echo intval($comment_number);?><?php esc_html_e(' comments','rs-card')?></a>
                    </div>
                <?php endif;?>
            </li>
	<?php 
		endforeach;wp_reset_postdata();?>
        </ul>
		<?php endif;

		/* After widget (defined by themes). */
		echo $after_widget;
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['count'] = strip_tags( $new_instance['count'] );
		$instance['cat'] = strip_tags( $new_instance['cat'] );
		$instance['show_cat'] = $new_instance['show_cat'];
		$instance['show_thumbnail'] = $new_instance['show_thumbnail'];
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => '', 'count' => '3', 'cat'=>'', 'show_thumbnail' => 'on','show_cat' => 'on', 'description' => 'Recent Blog Posts' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>"><?php esc_html_e( 'Title:','rs-card' ); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" style="width:100%;" />
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'count' )); ?>"><?php esc_html_e( 'Count:','rs-card' ); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'count' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'count' )); ?>" value="<?php echo esc_attr($instance['count']); ?>" style="width:100%;" />
		</p>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'cat' )); ?>"><?php esc_html_e( 'Category ID (optional):','rs-card' ); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id( 'cat' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'cat' )); ?>" value="<?php echo esc_attr($instance['cat']); ?>" style="width:100%;" />
		</p>

        <p>
            <input class="checkbox" type="checkbox" <?php checked($instance['show_cat'], 'on'); ?> id="<?php echo esc_attr($this->get_field_id('show_cat')); ?>" name="<?php echo esc_attr($this->get_field_name('show_cat')); ?>" />
            <label for="<?php echo esc_attr($this->get_field_id('show_cat')); ?>">Show Categories</label>
        </p>

		<p>
			<input class="checkbox" type="checkbox" <?php checked($instance['show_thumbnail'], 'on'); ?> id="<?php echo esc_attr($this->get_field_id('show_thumbnail')); ?>" name="<?php echo esc_attr($this->get_field_name('show_thumbnail')); ?>" /> 
			<label for="<?php echo esc_attr($this->get_field_id('show_thumbnail')); ?>">Show thumbnail</label>
		</p>
		
	<?php
	}
}

?>