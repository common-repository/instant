<?php
/**
 * Plugin Name:         Unless
 * Plugin URI:          http://unless.com/
 * Description:         Add Unless to your website - generate multiple, optimized variations of your existing web pages to cater to different audiences, for a better conversion rate.
 * Author:              Unless.com
 * Author URI:          http://unless.com/
 * Version:             3.0.1
 * Requires at least:   3.0.1
 * Tested up to:        6.1.1
 *
 * License:             GPL v2 or later
 * 
 * Text Domain:         unless
 *
 * Unless.com, support@unless.com
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @category            Plugin
 * @author              Unless.com
 *
 */
 
  defined( 'ABSPATH' ) or die( 'Nope, not accessing this' );
	define( 'UNLESS_VERSION', '3.0.1' );
	define( 'UNLESS_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
	define( 'UNLESS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
	
	if ( !is_admin() )
		{
			add_action('wp_head','hook_javascript_unless_script', 1);
			function hook_javascript_unless_script()
				{
					if (get_option('unless_data')) {
					$output="<!-- Added by Unless for Wordpress -->
<script data-unless='1.2' data-installer='wordpress'>!function(o,p,t,i,m,a,l){function s(e){o.documentElement.style.opacity=e}function d(e){i.parentNode.insertBefore(e,i)}s((window.TxtOptions||{}).asyncMode?':0),setTimeout(function(){s('')},3e3),i=(o.head||o.documentElement).firstChild,l='https://'+t+'.unless.com/js/v5/latest/txt.min.js?id='+t+'&domain='+window.location.hostname,(m=o.createElement('link')).href=l,m.rel='preconnect preload',m.as=p,d(m),(a=o.createElement(p)).src=l,d(a),a.onerror=function(){s('')}}(document,'script','" . trim(get_option('unless_data')) . "');</script>
<!-- End Unless Code -->";
					echo $output;
					}
				}

			function unless_plugin_get_version()
				{
					if ( ! function_exists( 'get_plugins' ) ) 
						{
							require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
						}

					$plugin_folder = get_plugins( '/' . plugin_basename( dirname( __FILE__ ) ) );
					$plugin_file = basename( ( __FILE__ ) );
					echo $plugin_folder[$plugin_file]['Version'];
				}
		}

	if ( is_admin () )
		{
			require_once( UNLESS_PLUGIN_PATH . 'includes/common.php' );

			// Runs when plugin is activated
			register_activation_hook(__FILE__,'unless_install');
			function unless_install()
				{
					if ( !get_option('unless_data') ) {
						add_option("unless_data", '', '', 'yes');
					}
				}

			// Runs on plugin uninstall
			register_uninstall_hook( __FILE__, 'unless_remove' );
			function unless_remove()
				{
					delete_option('unless_data');
				}

			// Add Admin submenu page
			add_action('admin_menu', 'unless_account_id_options_panel');
			function unless_account_id_options_panel()
				{
					add_submenu_page( 'tools.php', 'Unless', 'Unless', 'manage_options', 'unless', 'unless_html_page');
				}

			// Add nagging error-message in admin
			add_action( 'admin_notices', 'unless_no_account_id_admin_notice' );
			function unless_no_account_id_admin_notice()
				{
				if ( !get_option('unless_data') )
						{
							?>
							<div class="wrap">
								<div class="unless notice notice-error error">
									<p><?php _e( 'Please provide your <a href="tools.php?page=unless">Unless account ID</a>.', 'unless' ); ?></p>
								</div>
							</div>
							<?php
						}
				}

			// Add settings link on plugin page
			$plugin = plugin_basename(__FILE__); 
			add_filter("plugin_action_links_$plugin", 'unless_settings_link' );
			function unless_settings_link($links)
				{ 
					$settings_link = '<a href="tools.php?page=unless.php">' . __( 'Settings', 'unless' ) . '</a>'; 
					array_unshift($links, $settings_link); 
					return $links;
				}

			// Markup for the settings page
			function unless_html_page ()
				{
					require_once( UNLESS_PLUGIN_PATH . 'includes/html.php' );
					echo unless_get_html();
				}
		}
