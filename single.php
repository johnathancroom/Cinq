<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Cinq
 * @since Cinq 1.0
 */

get_header(); ?>

		<div class="site-content">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php //cinq_content_nav( 'nav-above' ); ?>

				<?php get_template_part( 'content', 'single' ); ?>

				<?php cinq_content_nav( 'nav-below' ); ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || '0' != get_comments_number() )
						comments_template( '', true );
				?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- .site-content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>