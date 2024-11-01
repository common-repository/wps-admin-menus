<?php

/*
File: Setup plugin WPS Admin Menus
Author: Leigh Gregg (wpscomplete.com)
Author URI: https://wpscomplete.com
Copyright 2018 wpscomplete.com. All rights reserved.
*/

if ( ! defined( 'ABSPATH' ) ) { exit; }

/*
* On loading, check for any redirections required
*
*/


function wpsc_loading_page_restrictions(){
	$access_denied = false;
    $url = $_SERVER['REQUEST_URI'];

    if( get_current_user_id() != 0 ){

	    $current_user_settings = get_option( 'wpsc_backend_user_restrict', false );
	    $data = get_userdata( get_current_user_id() );
	    $user_roles = $data->roles;

	    foreach($current_user_settings as $key => $value ){
	    	if( $value['backend'] == 1 ){//this role is restricted
	    		if( in_array( $key , $user_roles ) ){
	    			$access_denied = true;
	    		} 
	    	}
		}

	    if( $access_denied ){
	    	 if( get_site_url().$url ==  admin_url() ){
	       		wp_safe_redirect( get_site_url() );
	   		}
	    }
	}
}
add_action('init', 'wpsc_loading_page_restrictions');


function wpsc_update_available_roles_backend_access(){
	global $wp_roles;
	// 1 = restrcit this user
	// 0 = do not restrict this user

	$roles = array();
	foreach($wp_roles->roles as $key => $value){
		$roles_current[$key] = $value['name'];
	}
	$current_roles = array();
	foreach($roles_current as $key => $value){
		$current_roles[$key] = array(
			'role' => $key,
			'name' => $value,
			'backend' => 0,
		);
	}


	$current_user_settings = get_option( 'wpsc_backend_user_restrict', false );

	if(  is_string( $current_user_settings ) || $current_user_settings ){
		if( isset( $_POST['WPS-action'] ) ){
			if($_POST['WPS-action'] == 'update-available-roles-backend' ){
					if ( ! wp_verify_nonce( $_POST['wpsc_update_backend_access_roles'], 'wpsc_update_backend_access_roles' ) ) {
						wp_die( __( 'Nonce verification failed.', 'wps' ), __( 'Error', 'wps' ), array( 'response' => 403 ) );
					}

				foreach( $current_roles as $key => $value ){
					if ( array_key_exists ( $key , $current_user_settings ) ){
						if($key == 'administrator' || $key == 'super_admin'){
							$access = 0;//not restricted
						} else {
							$access = $current_user_settings[$key]['backend'];
						}
						$new_settings[$key] = array( 'role' => $key, 'name' => $value['name'],'backend' => $access,);
					} else { //this is a new role that is being added default, the access is not restricted as default
						$new_settings[$key] = array( 'role' => $key, 'name' => $value['name'], 'backend' => 0, );
					}
				}
				update_option( 'wpsc_backend_user_restrict', $new_settings, null );

			}
		}
	} else {
		$exists = add_option( 'wpsc_backend_user_restrict', $current_roles );
	}
}
add_action('WPS_action_update-available-roles-backend', 'wpsc_update_available_roles_backend_access');


//users update the selection of access
function wpsc_update_user_role_access_backend(){

	if ( ! wp_verify_nonce( $_POST['wpsc_update_backend_access'], 'wpsc_update_backend_access' ) ) {
		wp_die( __( 'Nonce verification failed.', 'wps' ), __( 'Error', 'wps' ), array( 'response' => 403 ) );
	}

	if( ! get_option( 'wpsc_backend_user_restrict', false ) ){
		wpsc_update_available_roles_backend_access();
	}

	$current_user_settings = get_option( 'wpsc_backend_user_restrict', false );

	foreach($current_user_settings as $key => $value ){
		if( isset( $_POST['backend_access'] ) ){
			if ( in_array ( $key , $_POST['backend_access'] ) ){
				$current_user_settings[$key]['backend'] = 1;
			} else {
				$current_user_settings[$key]['backend'] = 0;
			}
		} else {
			$current_user_settings[$key]['backend'] = 0;
		}
	}
	update_option( 'wpsc_backend_user_restrict', $current_user_settings, null );
}
add_action('WPS_action_update-selected-roles-backend', 'wpsc_update_user_role_access_backend');

