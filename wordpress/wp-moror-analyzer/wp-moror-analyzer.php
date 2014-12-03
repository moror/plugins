<?php
/*
Plugin Name: WP Moror Analyzer
Plugin URI: http://wordpress.org/extend/plugins/wp-moror-analyzer/
Description: This plugin add Moror analyzer code to your site
Version: 0.0.1
Author: Moror
Author URI: http://moror.ir
Text Domain: wp-moror-analyzer
Domain Path: /lang


Copyright (c) 2013-2014
*/

if(!class_exists('WPMororAnalyzer')) {
class WPMororAnalyzer {

function is_str_and_not_empty($var) {
	if (!is_string($var))
		return false;

	if (empty($var))
		return false;

	if ($var=='')
		return false;

	return true;
}


function wpma_Head($content) {
	$wp_moror_analyzer = maybe_unserialize(get_option('wp_moror_analyzer'));

	if($wp_moror_analyzer['load_pos'] == 'head') {
		if( $wp_moror_analyzer['allow_user'] == 'no' && is_user_logged_in()) {
			return;
		}

		echo $wp_moror_analyzer['analyzer_code'];
	}
}

function wpma_Footer($content) {

	$wp_moror_analyzer = maybe_unserialize(get_option('wp_moror_analyzer'));

	if($wp_moror_analyzer['load_pos'] == 'head') {
		return;
	}

	if( $wp_moror_analyzer['allow_user'] == 'no' && is_user_logged_in()) {
		return;
	}

	echo $wp_moror_analyzer['analyzer_code'];
}

/**
 * Registers additional links for the plugin on the WP plugin configuration page
 *
 * Registers the links if the $file param equals to the plugin
 * @param $links Array An array with the existing links
 * @param $file string The file to compare to
 */
function RegisterPluginLinks($links, $file) {
	load_plugin_textdomain( 'wp-moror-analyzer', false, dirname( plugin_basename( __FILE__ ) ) . "/lang" );
	$base = plugin_basename(__FILE__);
	if ($file ==$base) {
		$links[] = '<a href="options-general.php?page=wp-moror-analyzer">' . __('Settings','wp-moror-analyzer') . '</a>';
	}
	return $links;
}

/**
 * Handled the plugin activation on installation
 */
function ActivatePlugin() {
	$optfile = trailingslashit(dirname(__FILE__)) . "options.txt";
	$options = file_get_contents($optfile);
	add_option("wp_moror_analyzer", $options, null, 'no');
}

/**
 * Handled the plugin deactivation
 */
function DeactivatePlugin() {
	$optfile = trailingslashit(dirname(__FILE__)) . "options.txt";
	file_put_contents($optfile, get_option("wp_moror_analyzer"));
	delete_option("wp_moror_analyzer");
}

} // end of class WPMororAnalyzer
} // end of if(!class_exists('WPMororAnalyzer'))

load_plugin_textdomain( 'wp-moror-analyzer', false, dirname( plugin_basename( __FILE__ ) ) . "/lang" );

if(class_exists('WPMororAnalyzer')) {

	$WPMororAnalyzer = new WPMororAnalyzer();

	if(isset($WPMororAnalyzer)) {
		register_activation_hook(__FILE__, array(&$WPMororAnalyzer, 'ActivatePlugin'));
		register_deactivation_hook(__FILE__, array(&$WPMororAnalyzer, 'DeactivatePlugin'));

		//Additional links on the plugin page
		add_filter('plugin_row_meta', array(&$WPMororAnalyzer, 'RegisterPluginLinks'),10,2);

		//Add the actions
		add_action('wp_head', array(&$WPMororAnalyzer, 'wpma_Head'));
		add_action('get_footer', array(&$WPMororAnalyzer, 'wpma_Footer'));

	}
}

/* Options Page */
require_once(trailingslashit(dirname(__FILE__)) . "wp-moror-analyzer-page.php");

if(class_exists('WPMororAnalyzerPage')) {
	$WPMororAnalyzer_page = new WPMororAnalyzerPage();

	if(isset($WPMororAnalyzer_page)) {
		add_action('admin_menu', array(&$WPMororAnalyzer_page, 'WPMororAnalyzer_Menu'), 1);
	}
}
?>
