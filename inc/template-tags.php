<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Cinq
 * @since Cinq 1.0
 */

if ( ! function_exists( 'cinq_content_nav' ) ):
/**
 * Display navigation to next/previous pages when applicable
 *
 * @since Cinq 1.0
 */
function cinq_content_nav( $nav_id ) {
	global $wp_query;

	$nav_class = 'site-navigation paging-navigation';
	if ( is_single() )
		$nav_class = 'site-navigation post-navigation';

	?>
	<nav role="navigation" id="<?php echo $nav_id; ?>" class="<?php echo $nav_class; ?>">
		<h1 class="assistive-text"><?php _e( 'Post navigation', 'cinq' ); ?></h1>

	<?php if ( is_single() ) : // navigation links for single posts ?>

		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'cinq' ) . '</span> %title' ); ?>
		<?php next_post_link( '<div class="nav-next">%link</div>', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'cinq' ) . '</span>' ); ?>

	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : // navigation links for home, archive, and search pages ?>

		<?php if ( get_next_posts_link() ) : ?>
		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'cinq' ) ); ?></div>
		<?php endif; ?>

		<?php if ( get_previous_posts_link() ) : ?>
		<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'cinq' ) ); ?></div>
		<?php endif; ?>

	<?php endif; ?>

	</nav><!-- #<?php echo $nav_id; ?> -->
	<?php
}
endif; // cinq_content_nav

if ( ! function_exists( 'cinq_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Cinq 1.0
 */
function cinq_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'cinq' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'cinq' ), ' ' ); ?></p>
	<?php
			break;
		default :
	?>
  <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
    <div id="comment-<?php comment_ID(); ?>">
  		<h3>
  		  <?php if(get_comment_author_url()) : ?>
        <a href="<?php comment_author_url(); ?>">
        <?php endif; ?>
      		<?php echo get_avatar( $comment, 30, "retro" ); ?>
      		<?php comment_author(); ?>
    		<?php if(get_comment_author_url()) : ?>
        </a>
        <?php endif; ?>
  		</h3>
  
  		<?php if ( $comment->comment_approved == '0' ) : ?>
  			<em><?php _e( 'Your comment is awaiting moderation.', 'cinq' ); ?></em>
  			<br />
  		<?php endif; ?>
  
  		<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>" class="date">
  			<time pubdate datetime="<?php comment_time( 'c' ); ?>">
    			<?php printf( __( '%1$s at %2$s', 'cinq' ), get_comment_date(), get_comment_time() ); ?>
    		</time>
      </a>
  
  		<div class="comment-content"><?php comment_text(); ?></div>

  		<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
    </div>
	<?php
			break;
	endswitch;
}
endif; // ends check for cinq_comment()

if ( ! function_exists( 'cinq_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 *
 * @since Cinq 1.0
 */
function cinq_posted_on() {
  $byline = 'by <a href="%5$s" title="%6$s" rel="author">%7$s</a> on <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a> ';
	$tag_list = get_the_tag_list( '', ', ' );
  if(!cinq_categorized_blog())
	{
		// This blog only has 1 category so we just need to worry about tags in the meta text
		if($tag_list != '')
		{
  		// This post has tags
			$meta_text = __($byline . 'and tagged %9$s', 'cinq');
		}
		else
		{
			$meta_text = __($byline, 'cinq');
		}
	}
	else
	{
		// But this blog has loads of categories so we should probably display them here
		if($tag_list != '')
		{
  		// This post has tags
			$meta_text = __($byline . 'in %8$s and tagged %9$s', 'cinq');
		}
		else
		{
			$meta_text = __($byline . 'in %8$s', 'cinq');
		}

	}

	printf( $meta_text,
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'cinq' ), get_the_author() ) ),
		esc_html( get_the_author() ),
		get_the_category_list( __( ', ', 'cinq' ) ),
		$tag_list
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category
 *
 * @since Cinq 1.0
 */
function cinq_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'all_the_cool_cats' ) ) ) {
		// Create an array of all the categories that are attached to posts
		$all_the_cool_cats = get_categories( array(
			'hide_empty' => 1,
		) );

		// Count the number of categories that are attached to the posts
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'all_the_cool_cats', $all_the_cool_cats );
	}

	if ( '1' != $all_the_cool_cats ) {
		// This blog has more than 1 category so cinq_categorized_blog should return true
		return true;
	} else {
		// This blog has only 1 category so cinq_categorized_blog should return false
		return false;
	}
}

/**
 * Flush out the transients used in cinq_categorized_blog
 *
 * @since Cinq 1.0
 */
function cinq_category_transient_flusher() {
	// Like, beat it. Dig?
	delete_transient( 'all_the_cool_cats' );
}
add_action( 'edit_category', 'cinq_category_transient_flusher' );
add_action( 'save_post', 'cinq_category_transient_flusher' );