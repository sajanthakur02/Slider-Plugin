<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://http://localhost/wordpress
 * @since             1.0.0
 * @package           Custom_Slider
 *
 * @wordpress-plugin
 * Plugin Name:       Custom Slider
 * Plugin URI:        https://http://localhost/wordpress
 * Description:       This is use to for post slider 
 * Version:           1.0.0
 * Author:            Mohit
 * Author URI:        https://http://localhost/wordpress
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       custom-slider
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'CUSTOM_SLIDER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-custom-slider-activator.php
 */
function activate_custom_slider() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-custom-slider-activator.php';
	Custom_Slider_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-custom-slider-deactivator.php
 */
function deactivate_custom_slider() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-custom-slider-deactivator.php';
	Custom_Slider_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_custom_slider' );
register_deactivation_hook( __FILE__, 'deactivate_custom_slider' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-custom-slider.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_custom_slider() {

	$plugin = new Custom_Slider();
	$plugin->run();

}
run_custom_slider();

function custom_slider_admin_menu()
{	
    add_menu_page('Custom Slider', 'Custom Slider', 'manage_options', 'custom_slider_plugin_page' , 'custom_slider_submenu_callback','dashicons-slides','20');
    add_submenu_page( 'custom_slider_plugin_page', 'Silder Setting', 'Slider Setting','manage_options', 'custom_slider_plugin_page');
	// add_submenu_page( 'custom_slider_plugin_page', 'Settings', 'Settings','manage_options', 'custom-slider-replace-post-link', 'custom_slider_setting_submenu_callback');
}
add_action('admin_menu', 'custom_slider_admin_menu' );
function custom_slider_submenu_callback()
{  #working
	 //include "uploadfile.php"; 
?>
<!-- Working perfectly -->
	<h3>Image Upload</h3>
	<!-- <label for="cheese">Image Upload</label> -->
	<!-- <a onclick="return false;" title="Upload image" class="thickbox" id="add_image" href="media-upload.php?type=image&amp;TB_iframe=true&amp; width=640&amp; height=105"><input type="button" name="upload" value = "Upload Image"></a> -->
	<!-- <form method="post">
		<input id="wk-media-url" type="text" name="media" />
		<input id="wk-button" type="button" class="button" value="Upload Image" />
		<input type="submit" value="Submit" />
	</form> -->
<?php
	$image_id = "";
	if(isset($_POST['save']))
	{
		$image_id = $_POST['rudr_img'];

		// update_option('custom_slider_1' , $image_id);

		$option_name = 'custom_slider_1' ;
		$new_value = $image_id ;

		if ( get_option( $option_name ) !== false ) {

			// The option already exists, so update it.
			update_option( $option_name, $new_value );

		} else {

			// The option hasn't been created yet, so add it with $autoload set to 'no'.
			$deprecated = null;
			$autoload = 'no';
			add_option( $option_name, $new_value, $deprecated, $autoload );
		}

	}
?>
	<?php if( $image = wp_get_attachment_image_url( $image_id, 'medium' ) ) : ?>
	<a href="#" class="rudr-upload">
		<img src="<?php echo esc_url( $image ) ?>" />
	</a>
	<a href="media-upload.php" class="rudr-remove">Remove image</a>
	<input type="hidden" name="rudr_img" value="<?php echo absint( $image_id ) ?>">
	<?php else : ?>
		<form action="?page=custom_slider_plugin_page" method="post">
		<a href="media-upload.php" class="button rudr-upload"> Upload image</a>
		<a href="media-upload.php" class="rudr-remove" style="display:none">Remove image</a>
		<input type="hidden" name="rudr_img" id = "img_id" value="">
		<input type="submit" name="save" value="Save"></form>
	<?php endif; ?>
<?php
}

add_action( 'admin_enqueue_scripts', 'rudr_include_js' );
function rudr_include_js() {
	
	// I recommend to add additional conditions here
	// because we probably do not need the scripts on every admin page, right?
	
	// WordPress media uploader scripts
	if ( ! did_action( 'wp_enqueue_media' ) ) {
		wp_enqueue_media();
	}
	// our custom JS
 	wp_enqueue_script( 
		'mishaupload', 
		get_stylesheet_directory_uri() . '/misha-uploader.js',
		array( 'jquery' )
	);
}

#slider Code
function slider() {
	$sliderValue = get_option('custom_slider_1');
	$slides = explode(',', $sliderValue); ?>
	<header class="intro">
	<div class="intro-slideshow">
	<?php foreach ($slides as $slide) {  
		$imageUrl = wp_get_attachment_image_url($slide, $size = 'thumbnail'); ?>
		<img src=<?= "'$imageUrl'" ?> alt="" width="300" height="300" class="alignnone size-full wp-image-538" />
<?php } ?>
</div>
</header>
<?php }
add_shortcode('custom_slider', 'slider');