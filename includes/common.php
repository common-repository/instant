<?php
/**
 * Helper functions.
 *
 * @package Unless
 * @author  Unless
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Register style sheet.
add_action( 'admin_enqueue_scripts', 'unless_register_plugin_styles' );
function unless_register_plugin_styles($hook) {
	if   ( 'tools_page_unless' == $hook ) { 
		wp_register_style( 'unless_reset', UNLESS_PLUGIN_URL . 'css/reset.css');
		wp_enqueue_style( 'unless_reset' );
		wp_register_style( 'unless_fonts', UNLESS_PLUGIN_URL . 'css/fonts.css');
		wp_enqueue_style( 'unless_fonts' );
		wp_register_style( 'material_css', UNLESS_PLUGIN_URL . 'css/material.css' );
		wp_enqueue_style( 'material_css' );
		wp_register_style( 'dialog_polyfill_css', UNLESS_PLUGIN_URL . 'css/dialog-polyfill.css');
		wp_enqueue_style( 'dialog_polyfill_css' );
		wp_register_style( 'unless_css', UNLESS_PLUGIN_URL . 'css/unless.css');
		wp_enqueue_style( 'unless_css' );
		wp_register_script( 'dialog_polyfill_js', UNLESS_PLUGIN_URL . 'js/dialog-polyfill.js', array(), false, true );
		wp_enqueue_script( 'dialog_polyfill_js' );
		wp_register_script( 'material_js', UNLESS_PLUGIN_URL . 'js/material.js', array(), false, true );
		wp_enqueue_script( 'material_js' );
		wp_register_script( 'unless_js', UNLESS_PLUGIN_URL . 'js/unless.js', array(), false, true );
		wp_enqueue_script( 'unless_js' );
	}
}

/**
 * Remove Assets that conflict with ours from our screens.
 * NOTE: not used, put it in for later.
 */
function unless_remove_conflicting_asset_files() {

	// Get current screen.
	$screen = get_current_screen();

	// Bail if we're not on an Unless screen.
	if ( empty( $screen->id ) || strpos( $screen->id, 'unless' ) === false ) {
		return;
	}

	$styles = array(
		// 'kt_admin_css', // Pinnacle theme
		//'select2-css' // Schema theme
	);

	$scripts = array(
		// 'kad_admin_js', // Pinnacle theme
		// 'dt-chart' // DesignThemes core features plugin
	);

	foreach ( $styles as $style ) {
		wp_dequeue_style( $style ); // Remove CSS file from Unless screen
	}

	foreach ( $scripts as $script ) {
		wp_dequeue_script( $script ); // Remove JS file from Unless screen
	}
}
add_action( 'admin_enqueue_scripts', 'unless_remove_conflicting_asset_files', 9999 );

/**
 * Remove non-Unless notices from Unless page.
 */
function hide_non_unless_warnings () {
	// Bail if we're not on an Unless screen.
	if ( empty( $_REQUEST['page'] ) || strpos( $_REQUEST['page'], 'unless' ) === false ) {
		return;
	}

	global $wp_filter;
	if ( !empty( $wp_filter['user_admin_notices']->callbacks ) && is_array( $wp_filter['user_admin_notices']->callbacks ) ) {
		foreach( $wp_filter['user_admin_notices']->callbacks as $priority => $hooks ) {
			foreach ( $hooks as $name => $arr ) {
				if ( !empty( $name ) && strpos( $name, 'unless' ) === false ) {
					unset( $wp_filter['user_admin_notices']->callbacks[$priority][$name] );
				}
			}
		}
	}

	if ( !empty( $wp_filter['admin_notices']->callbacks ) && is_array( $wp_filter['admin_notices']->callbacks ) ) {
		foreach( $wp_filter['admin_notices']->callbacks as $priority => $hooks ) {
			foreach ( $hooks as $name => $arr ) {
				if ( !empty( $name ) && strpos( $name, 'unless' ) === false ) {
					unset( $wp_filter['admin_notices']->callbacks[$priority][$name] );
				}
			}
		}
	}

	if ( !empty( $wp_filter['all_admin_notices']->callbacks ) && is_array( $wp_filter['all_admin_notices']->callbacks ) ) {
		foreach( $wp_filter['all_admin_notices']->callbacks as $priority => $hooks ) {
			foreach ( $hooks as $name => $arr ) {
				if ( !empty( $name ) && strpos( $name, 'unless' ) === false ) {
					unset( $wp_filter['all_admin_notices']->callbacks[$priority][$name] );
				}
			}
		}
	}
}
add_action('admin_print_scripts', 'hide_non_unless_warnings');