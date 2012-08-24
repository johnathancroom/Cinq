<?php
/**
 * The template for displaying search forms in Cinq
 *
 * @package Cinq
 * @since Cinq 1.0
 */
?>
<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<label for="s" class="assistive-text"><?php _e( 'Search', 'cinq' ); ?></label>
	<input type="text" class="field" name="s" id="s" placeholder="<?php esc_attr_e( 'Search&hellip;', 'cinq' ); ?>" value="<?php echo $_GET["s"]; ?>">
	<input type="submit" class="submit" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'cinq' ); ?>">
</form>
