<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to cinq_comment() which is
 * located in the functions.php file.
 *
 * @package Cinq
 * @since Cinq 1.0
 */
?>

<?php
	/*
	 * If the current post is protected by a password and
	 * the visitor has not yet entered the password we will
	 * return early without loading the comments.
	 */
	if ( post_password_required() )
		return;
?>

<?php
  comment_form(array(
    'fields' => array(//. ( $req ? '<span class="required">*</span>' : '' ) .
      'author' => '<div class="left">' . '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" placeholder="Name' . ( $req ? ' *' : '' ) . '"' . $aria_req . '>',
	    'email' => '<input id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" placeholder="Email' . ( $req ? ' *' : '' ) . '"' . $aria_req . '>',
	    'url' => '<input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="Website">' . '</div>',
    ),
    'comment_field' => '<textarea id="comment" name="comment" aria-required="true" placeholder="Comment *"></textarea>',
    'title_reply' => __('Join the Discussion', 'cinq'),
    'comment_notes_before' => '',
    'comment_notes_after' => ''  
  ));
?>

<div id="comments">
  <?php if ( have_comments() ) : ?>
  	<h2 class="comments-title">
  		<?php
  			printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'cinq' ),
  				number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
  		?>
  	</h2>
  
  	<ol class="comment-list">
  		<?php
  			/* Loop through and list the comments. Tell wp_list_comments()
  			 * to use cinq_comment() to format the comments.
  			 * If you want to overload this in a child theme then you can
  			 * define cinq_comment() and that will be used instead.
  			 * See cinq_comment() in inc/template-tags.php for more.
  			 */
  			wp_list_comments( array( 'callback' => 'cinq_comment' ) );
  		?>
  	</ol><!-- .commentlist -->
  
  	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
  	<nav role="navigation" id="comment-nav-below" class="site-navigation comment-navigation">
  		<h1 class="assistive-text"><?php _e( 'Comment navigation', 'cinq' ); ?></h1>
  		<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'cinq' ) ); ?></div>
  		<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'cinq' ) ); ?></div>
  	</nav><!-- #comment-nav-below .site-navigation .comment-navigation -->
  	<?php endif; // check for comment navigation ?>
  
  <?php endif; ?>
</div>