<?php

/*
Plugin Name: WPS Admin Menus
Plugin URI: https://wpscomplete.com/wps-complete-plugin/
Description: Manage your WordPress backend / admin. Manage menus and restrict user roles entirely from admin / backend.
Author: WPScomplete.com
Version: 1.0.3
Author URI: https://wpscomplete.com
*/


if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( !defined( 'WPS_AM_PLUGIN_DIR' ) ) {
	define( 'WPS_AM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}
if ( !defined( 'WPS_AM_PLUGIN_URL' ) ) {
	define( 'WPS_AM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}
if ( !defined( 'WPS_AM_PLUGIN_FILE' ) ) {
	define( 'WPS_AM_PLUGIN_FILE', __FILE__ );
}
if ( !defined( 'WPS_AM_PLUGIN_VERSION' ) ) {
	define( 'WPS_AM_PLUGIN_VERSION', '1.0' );
}


class WPS_admin_menus {
	public function __construct() {
		add_action( 'admin_notices', array( $this, 'global_note' ) );
	}

	function global_note() {
		if ( ! is_plugin_active( 'wps-complete/wps_complete.php' ) ) {
			?>
            <div id="message" class="error">
                <p><?php _e( 'Please install and active <a href="https://wordpress.org/plugins/wps-complete/advanced/">WPS Complete</a> to use WPS Admin Menus plugin.', 'wpsc_am' ); ?></p>
            </div>
			<?php
		
			if ( is_plugin_active( 'wps-admin-menus/wps_admin_menus.php' ) ) {
				deactivate_plugins( 'wps-admin-menus/wps_admin_menus.php' );
				unset( $_GET['activate'] );
			}
		}
	}
}

new WPS_admin_menus;

function wpsc_admin_menus_setup(){
	require( WPS_AM_PLUGIN_DIR . 'includes/wpsc_admin_menus_setup.php' );

}



//********************************************
//includes
//********************************************
require( WPS_AM_PLUGIN_DIR . 'includes/wpsc_setup_scripts.php' );
require( WPS_AM_PLUGIN_DIR . 'includes/wpsc_class_functions.php' );
require( WPS_AM_PLUGIN_DIR . 'includes/wpsc_functions_admin_menu.php' );

//to do now
	// improve the partion menus 
	// submit to the wordpress repository


//to do
	// url block for each menu
	// toolbar modifications
	// backend lockout for each role


