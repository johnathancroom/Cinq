<?php
/**
 * @package Cinq
 * @since Cinq 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title"><?php the_title(); ?></h1>

		<div class="entry-meta">
			<?php cinq_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
	</div><!-- .entry-content -->

	<div class="biography">
    <a href="<?php echo get_author_posts_url(get_the_author_meta("ID")); ?>">
      <?php echo get_avatar(get_the_author_meta("ID"), 100, 'retro'); ?>
    </a>
    <div class="author-info">
      Written by <a href="<?php echo get_author_posts_url(get_the_author_meta("ID")); ?>"><?php the_author_meta("display_name"); ?></a>
    </div>
    <p class="author-bio"><?php the_author_meta("user_description"); ?></p>
  </div>
</article><!-- #post-<?php the_ID(); ?> -->
