<?php


/**
 * Setup the plugin
 *
 * Manage basic setups that are important
 *
 * @package     WPS Admin Menus
 * @subpackage  
 * @copyright   Copyright (c) 2018, WPS Complete
 * @license     http://opensource.org/license/gpl-2.1.php GNU Public License
 * @since       1.0
 */


if ( ! defined( 'ABSPATH' ) ) { exit; }

/**
 * Load admin stylesheets
 *
 * @param string $hook Page hook.
 *
 * @return void
 */

function wpsc_am_admin_styles( $hook ) {
	if($hook != 'wps-complete_page_wpsc_menu') {
        return;
    }
	wp_enqueue_style( 'wpsc_admin_menu_styles',  WPS_AM_PLUGIN_URL . 'includes/css/wpsc_admin_menu_styles.css', array(), WPS_AM_PLUGIN_VERSION );
}
add_action( 'admin_enqueue_scripts', 'wpsc_am_admin_styles' );




/**
 * Do the restrictions based on settings from the options
 *
 * @param 
 *
 * @return void.
 */


function wpsc_am_restrict_menu_viewings(){
	global $wpdb, $menu, $submenu;

	//to do, 
	//if the user has multiple roles?

	$role = wpsc_get_user_role();

	$option_key = 'wpsc_am_option_';
	$sql = "SELECT * FROM {$wpdb->prefix}options WHERE option_name LIKE '%{$option_key}%';";
	$results =  $wpdb->get_results( $sql ) ;

	foreach($results as $key => $value){
		$menu_name = substr ( $value->option_name , 15  );
		$restricted_roles = unserialize ( $value->option_value );
		if ( $role != 'administrator' ) {
			$search = in_array( $role, $restricted_roles );
			if( $search ) {
				if( in_array( 'wpsc_am_menu' , $restricted_roles ) ){
					remove_menu_page( $menu_name );
				} 
				if( in_array( 'wpsc_am_submenu' , $restricted_roles ) ){
					if( $submenu[$menu_name] ){
						remove_menu_page( $menu_name );
					} else {
						foreach( $restricted_roles as $options ){
							if( substr ( $options , 0 , 8  ) == 'parent__' ){
								$sub_menu_parent = substr ( $options , 8  ); 
								remove_submenu_page( $sub_menu_parent , $menu_name );
							}
						}
					}
				}
			}
		}	
	}
}

add_action( 'admin_menu', 'wpsc_am_restrict_menu_viewings', 999 );


/**
 * Display user role
 *
 * @param string $hook Page hook.
 *
 * @return void
 */
if( ! function_exists ( 'wpsc_get_user_role' )){
 	function wpsc_get_user_role( $user = null ) {
		$user = $user ? new WP_User( $user ) : wp_get_current_user();
		return $user->roles ? $user->roles[0] : false;
	}
}


