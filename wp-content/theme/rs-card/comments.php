<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package WordPress
 * @subpackage Rs-Card
 * @since Rs-Card 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div class="post-comments animate-up" id="comments">
    <h2 class="section-title"><?php esc_html_e('Comments (', 'rs-card'); ?><?php echo intval(get_comments_number());?><?php esc_html_e(')', 'rs-card'); ?></h2>
    <div class="section-box">
        <?php if ( have_comments() ) : ?>
		<?php paginate_comments_links(); ?>
            <ol class="comment-list">
                <?php
                    wp_list_comments( array(
                        'style'       => 'ol',
                        'callback' => 'rscard_comment'
                    ) );
                ?>
            </ol>
        <?php endif;?>
        <?php
            if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
        ?>
            <p class="no-comments"><?php esc_html__( 'Comments are closed.', 'rs-card' ); ?></p>
        <?php endif; ?>
        <?php
        $req = get_option( 'require_name_email' );
        $aria_req = ( $req ? " aria-required='true'" : '' );
         $comment_args = array(
            'fields' => apply_filters( 'comment_form_default_fields', array(
                'author' => '<div class="input-field">
                                <input type="text" class="form-control" id="name" name="author" value="' . esc_attr( $commenter['comment_author'] ) . '" ' . $aria_req . ' />
                                <span class="line"></span>
                                <label>'.esc_html__('Name','rs-card').($req ? ' *' : '').'</label>
                            </div>',

                'email'  => '<div class="input-field">
                                <input type="email" class="form-control" id="email" name="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" ' . $aria_req . ' />
                                <span class="line"></span>
                                <label>'.esc_html__('Email','rs-card').($req ? ' *' : '').'</label>
                            </div>',

                'url'    => '<div class="input-field">
                                <input type="text" class="form-control" id="website" name="website" value="' .  esc_attr( $commenter['comment_author_url'] ) . '" />
                                <span class="line"></span>
                                <label>'.esc_html__('Website','rs-card').'</label>
                            </div>' ) ),

            'comment_field' => '<div class="input-field">
                                    <textarea id="comment" rows="4" name="comment" class="form-control" ' . $aria_req . '></textarea>
                                    <span class="line"></span>
                                    <label for="comment">'.esc_html__('Type Comment Here','rs-card').($req ? ' *' : '').'</label>
                                </div>',

            'comment_notes_after' => '',
            'comment_notes_before' => '',
            'title_reply' => '',

        );
        comment_form($comment_args); ?>
    </div>
</div>
