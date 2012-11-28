<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Cinq
 * @since Cinq 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '&middot;', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " &middot; $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' &middot; ' . sprintf( __( 'Page %s', 'cinq' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>
</head>

<?php $theme_options = get_option("cinq_theme_options");?>

<body <?php body_class(); ?>>
  <nav role="navigation" class="site-navigation main-navigation">
    <div class="container">
  		<h1 class="assistive-text"><?php _e( 'Menu', 'cinq' ); ?></h1>
  		<div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'cinq' ); ?>"><?php _e( 'Skip to content', 'cinq' ); ?></a></div>

  		<ul class="social-icons">
    		<?php if($theme_options["show_rss"]): ?>
          <li><a href="<?php bloginfo("rss2_url"); ?>" class="icon-feed" title="View RSS Feed"></a></li>
        <?php endif; ?>

        <?php if($theme_options["show_email"]): ?>
          <li><a href="mailto:<?php echo bloginfo("admin_email"); ?>" class="icon-mail" title="Email me"></a></li>
        <?php endif; ?>

        <?php if($theme_options["show_twitter"] && $theme_options["twitter_handle"]): ?>
          <li><a href="http://twitter.com/<?php echo $theme_options["twitter_handle"]; ?>" class="icon-twitter" title="Follow me on Twitter"></a></li>
        <?php endif; ?>

        <?php if($theme_options["show_instagram"] && $theme_options["instagram_username"]): ?>
          <li><a href="http://instagram.com/<?php echo $theme_options["instagram_username"]; ?>" class="icon-instagram" title="View my photos on Instagram"></a></li>
        <?php endif; ?>
      </ul>

  		<?php
        wp_nav_menu(array(
          'menu_container' => '',
          'menu_class' => 'primary-menu',
          'theme_location' => 'primary'
        ));
      ?>
    </div>
	</nav><!-- .site-navigation .main-navigation -->

	<section class="container">
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

  	<section id="content" class="content">