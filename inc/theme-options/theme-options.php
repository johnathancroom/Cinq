<?php
/**
 * Cinq Theme Options
 *
 * @package Cinq
 * @since Cinq 1.0
 */

/**
 * Register the form setting for our cinq_options array.
 *
 * This function is attached to the admin_init action hook.
 *
 * This call to register_setting() registers a validation callback, cinq_theme_options_validate(),
 * which is used when the option is saved, to ensure that our option values are properly
 * formatted, and safe.
 *
 * @since Cinq 1.0
 */
function cinq_theme_options_init() {
	register_setting(
		'cinq_options', // Options group, see settings_fields() call in cinq_theme_options_render_page()
		'cinq_theme_options', // Database option, see cinq_get_theme_options()
		'cinq_theme_options_validate' // The sanitization callback, see cinq_theme_options_validate()
	);

	// Register our settings field groups
	add_settings_section('general',	'', '__return_false', 'theme_options');
	add_settings_section('general',	'', '__return_false', 'theme_options_social_icons');

	// Test field
	add_settings_field("test", __("Test", "cinq"), "cinq_settings_field_text", "theme_options", "general", array("test"));

	// Social Fields
	add_settings_field("show_rss", __("Show RSS", "cinq"), "cinq_settings_field_checkbox", "theme_options_social_icons", "general", array("show_rss", "Show RSS"));
	add_settings_field("show_email", __("Show Email", "cinq"), "cinq_settings_field_checkbox", "theme_options_social_icons", "general", array("show_email", "Show Email"));
	add_settings_field("show_twitter", __("Show Twitter", "cinq"), "cinq_settings_field_checkbox", "theme_options_social_icons", "general", array("show_twitter", "Show Twitter"));
	add_settings_field("twitter_handle", __("Twitter Handle", "cinq"), "cinq_settings_field_text", "theme_options_social_icons", "general", array("twitter_handle"));
	add_settings_field("show_instagram", __("Show Instagram", "cinq"), "cinq_settings_field_checkbox", "theme_options_social_icons", "general", array("show_instagram", "Show Instagram"));
	add_settings_field("instagram_username", __("Instagram Username", "cinq"), "cinq_settings_field_text", "theme_options_social_icons", "general", array("instagram_username"));
}
add_action( 'admin_init', 'cinq_theme_options_init' );

/**
 * Change the capability required to save the 'cinq_options' options group.
 *
 * @see cinq_theme_options_init() First parameter to register_setting() is the name of the options group.
 * @see cinq_theme_options_add_page() The edit_theme_options capability is used for viewing the page.
 *
 * @param string $capability The capability used for the page, which is manage_options by default.
 * @return string The capability to actually use.
 */
function cinq_option_page_capability( $capability ) {
	return 'edit_theme_options';
}
add_filter( 'option_page_capability_cinq_options', 'cinq_option_page_capability' );

/**
 * Add our theme options page to the admin menu.
 *
 * This function is attached to the admin_menu action hook.
 *
 * @since Cinq 1.0
 */
function cinq_theme_options_add_page() {
	$theme_page = add_theme_page(
		__( 'Theme Options', 'cinq' ),   // Name of page
		__( 'Theme Options', 'cinq' ),   // Label in menu
		'edit_theme_options',          // Capability required
		'theme_options',               // Menu slug, used to uniquely identify the page
		'cinq_theme_options_render_page' // Function that renders the options page
	);
}
add_action( 'admin_menu', 'cinq_theme_options_add_page' );

/**
 * Returns the options array for Cinq.
 *
 * @since Cinq 1.0
 */
function cinq_get_theme_options() {
	$saved = (array) get_option( 'cinq_theme_options' );
	/*$defaults = array(
    'test' => '',
		'show_rss' => 'on',
		'show_email' => 'on',
		'show_twitter' => 'off',
		'twitter_handle'  => '',
		'show_instagram' => 'off',
		'instagram_username' => ''
	);

	$defaults = apply_filters( 'cinq_default_theme_options', $defaults );

	$options = wp_parse_args( $saved, $defaults );
	$options = array_intersect_key( $options, $defaults );*/

	return $saved;
}

/**
 * Renders a text input setting field.
 */
function cinq_settings_field_text($args) {
	$options = cinq_get_theme_options();
	?>
	<input type="text" name="cinq_theme_options[<?= $args[0] ?>]" id="<?= $args[0] ?>" value="<?= esc_attr( $options[$args[0]] ); ?>" />
	<?php
}

/**
 * Renders a checkbox setting field.
 */
function cinq_settings_field_checkbox($args) {
	$options = cinq_get_theme_options();
	?>
	<label for="<?= $args[0] ?>">
		<input type="checkbox" name="cinq_theme_options[<?= $args[0] ?>]" id="<?= $args[0] ?>" <?php checked( 'on', $options[$args[0]] ); ?> />
		<?php _e( $args[1], 'cinq' ); ?>
	</label>
	<?php
}

/**
 * Renders the Theme Options administration screen.
 *
 * @since Cinq 1.0
 */
function cinq_theme_options_render_page() {
	?>
	<div class="wrap">
		<?php screen_icon(); ?>
		<?php $theme_name = function_exists( 'wp_get_theme' ) ? wp_get_theme() : get_current_theme(); ?>
		<h2><?php printf( __( '%s Theme Options', 'cinq' ), $theme_name ); ?></h2>
		<?php settings_errors(); ?>

		<form method="post" action="options.php">
		  <?php
				settings_fields( 'cinq_options' );
		  ?>

		  <h3>Test</h3>
		  <?php
  		  do_settings_sections("theme_options");
  		?>

  		<h3>Header Social Icons</h3>
			<?php
				do_settings_sections( 'theme_options_social_icons' );
			?>

			<?php
  			submit_button();
  		?>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate form input. Accepts an array, return a sanitized array.
 *
 * @see cinq_theme_options_init()
 * @todo set up Reset Options action
 *
 * @param array $input Unknown values.
 * @return array Sanitized theme options ready to be stored in the database.
 *
 * @since Cinq 1.0
 */
function cinq_theme_options_validate( $input ) {
	/*$output = array();

	if ( isset( $input['test'] ) && ! empty( $input['test'] ) )
		$output['test'] = wp_filter_nohtml_kses( $input['test'] );

	// Checkboxes will only be present if checked.
	if ( isset( $input['show_rss'] ) )
		$output['show_rss'] = 'on';

	// The sample text input must be safe text with no HTML tags
	if ( isset( $input['twitter_handle'] ) && ! empty( $input['twitter_handle'] ) )
		$output['twitter_handle'] = wp_filter_nohtml_kses( $input['twitter_handle'] );

	return apply_filters( 'cinq_theme_options_validate', $output, $input );*/

	return $input;
}
