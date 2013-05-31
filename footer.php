<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Cinq
 * @since Cinq 1.0
 */
?>

  	</section><!-- .content -->

  	<section class="side">
      <header>
        <h1 class="site-title">
          <a href="<?php echo home_url( '/' ); ?>" title="Go Home" rel="home">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/site-title.png" alt="<?php bloginfo( 'name' ); ?> &middot; <?php bloginfo("description"); ?>">
          </a>
        </h1>
      </header>

      <aside class="sidebar">
        <?php get_sidebar(); ?>
      </aside>
    </section>
  </section><!-- .container -->

  <footer class="copyright">
    <div class="container">
      &nbsp;
    </div>
  </footer>

  <?php wp_footer(); ?>
</body>
</html>